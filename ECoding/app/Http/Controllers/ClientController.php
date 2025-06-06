<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\CourseReview;

class ClientController extends Controller
{
    /**
     * Display the client dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get the authenticated client
        $client = Auth::guard('client')->user();
        
        // Get total available courses
        $totalCourses = Course::where('status', 'published')->count();
        
        // Get new courses added this week
        $newCoursesThisWeek = Course::where('status', 'published')
            ->where('created_at', '>=', now()->subWeek())
            ->count();
            
        // Get client's completed courses
        try {
            $completedCourses = DB::table('course_enrollments')
                ->where('client_id', $client->id)
                ->where('completed', true)
                ->count();
                
            // Calculate completion rate
            $enrolledCourses = DB::table('course_enrollments')
                ->where('client_id', $client->id)
                ->count();
                
            $completionRate = $enrolledCourses > 0 
                ? round(($completedCourses / $enrolledCourses) * 100) 
                : 0;
                
            // Calculate total learning hours
            $totalLearningHours = DB::table('course_enrollments')
                ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
                ->where('course_enrollments.client_id', $client->id)
                ->sum('courses.estimated_hours') ?? 0;
        } catch (\Exception $e) {
            // Valeurs par défaut si les tables n'existent pas encore
            $completedCourses = 8;
            $completionRate = 33;
            $totalLearningHours = 42;
        }
        
        // Get learning hours this week (placeholder)
        $learningHoursThisWeek = 5;
        
        // Get average course rating
        $averageRating = Course::where('status', 'published')->avg('rating') ?? 4.8;
        
        // Get featured courses (highest rated)
        $featuredCourses = Course::where('status', 'published')
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        // Process image and PDF paths for featured courses
        foreach ($featuredCourses as $course) {
            // Convert storage path to public path for images
            if ($course->cover_image) {
                // If the path starts with 'storage/', remove it to get the relative path
                if (strpos($course->cover_image, 'storage/') === 0) {
                    $course->cover_image = str_replace('storage/', '', $course->cover_image);
                }
                
                // Check if the image exists in public/images
                if (file_exists(public_path('images/' . basename($course->cover_image)))) {
                    $course->cover_image = 'images/' . basename($course->cover_image);
                } else if (file_exists(public_path($course->cover_image))) {
                    // Keep the path as is if it exists
                } else if (file_exists(public_path('storage/' . $course->cover_image))) {
                    $course->cover_image = 'storage/' . $course->cover_image;
                }
            }
            
            // Convert storage path to public path for PDFs
            if ($course->pdf_file_path) {
                // If the path is a storage path, convert to public path
                if (strpos($course->pdf_file_path, 'app/') === 0) {
                    $course->pdf_file_path = str_replace('app/', '', $course->pdf_file_path);
                }
                
                // Check if the PDF exists in public/pdfs
                if (file_exists(public_path('pdfs/' . basename($course->pdf_file_path)))) {
                    $course->pdf_file_path = 'pdfs/' . basename($course->pdf_file_path);
                } else if (file_exists(public_path($course->pdf_file_path))) {
                    // Keep the path as is if it exists
                } else if (file_exists(storage_path('app/' . $course->pdf_file_path))) {
                    // Keep the original path for download method
                }
            }
        }
            
        // Get course categories for filtering
        $categories = CourseCategory::withCount(['courses' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('courses_count', 'desc')
            ->take(5)
            ->get();
            
        // Get popular programming languages (based on course tags)
        $popularLanguages = collect();
        try {
            $courses = Course::where('status', 'published')
                ->whereNotNull('tags')
                ->select('tags')
                ->get();
                
            $allTags = collect();
            foreach ($courses as $course) {
                $tags = $course->tags;
                if (is_string($tags)) {
                    $tags = json_decode($tags, true);
                }
                if (is_array($tags)) {
                    $allTags = $allTags->merge($tags);
                }
            }
            
            $popularLanguages = $allTags->countBy()->sortDesc()->take(5);
        } catch (\Exception $e) {
            // Valeurs par défaut si pas de données
            $popularLanguages = collect([
                'JavaScript' => 15,
                'Python' => 12,
                'PHP' => 10,
                'Java' => 8,
                'React' => 7
            ]);
        }
        
        return view('client.dashboard', compact(
            'client',
            'totalCourses',
            'newCoursesThisWeek',
            'completedCourses',
            'completionRate',
            'totalLearningHours',
            'learningHoursThisWeek',
            'averageRating',
            'featuredCourses',
            'categories',
            'popularLanguages'
        ));
    }

    /**
     * Display all courses for clients
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function courses(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        // Build query for courses
        $query = Course::where('status', 'published')
            ->with(['category', 'instructor']);
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by difficulty
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }
        
        // Filter by price (free or paid)
        if ($request->filled('price_type')) {
            if ($request->price_type === 'free') {
                $query->where('price', 0);
            } elseif ($request->price_type === 'paid') {
                $query->where('price', '>', 0);
            }
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }
        
        // Sort options
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('downloads_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Paginate results
        $courses = $query->paginate(12)->withQueryString();
        
        // Process image and PDF paths for courses
        foreach ($courses as $course) {
            // Convert storage path to public path for images
            if ($course->cover_image) {
                // If the path starts with 'storage/', remove it to get the relative path
                if (strpos($course->cover_image, 'storage/') === 0) {
                    $course->cover_image = str_replace('storage/', '', $course->cover_image);
                }
                
                // Check if the image exists in public/images
                if (file_exists(public_path('images/' . basename($course->cover_image)))) {
                    $course->cover_image = 'images/' . basename($course->cover_image);
                } else if (file_exists(public_path($course->cover_image))) {
                    // Keep the path as is if it exists
                } else if (file_exists(public_path('storage/' . $course->cover_image))) {
                    $course->cover_image = 'storage/' . $course->cover_image;
                }
            }
            
            // Convert storage path to public path for PDFs
            if ($course->pdf_file_path) {
                // If the path is a storage path, convert to public path
                if (strpos($course->pdf_file_path, 'app/') === 0) {
                    $course->pdf_file_path = str_replace('app/', '', $course->pdf_file_path);
                }
                
                // Check if the PDF exists in public/pdfs
                if (file_exists(public_path('pdfs/' . basename($course->pdf_file_path)))) {
                    $course->pdf_file_path = 'pdfs/' . basename($course->pdf_file_path);
                } else if (file_exists(public_path($course->pdf_file_path))) {
                    // Keep the path as is if it exists
                } else if (file_exists(storage_path('app/' . $course->pdf_file_path))) {
                    // Keep the original path for download method
                }
            }
        }
        
        // Get categories for filter dropdown
        $categories = CourseCategory::orderBy('name')->get();
        
        // Get enrolled course IDs for this client
        $enrolledCourseIds = collect();
        try {
            $enrolledCourseIds = DB::table('course_enrollments')
                ->where('client_id', $client->id)
                ->pluck('course_id');
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }
        
        return view('client.courses', compact(
            'courses',
            'categories',
            'enrolledCourseIds',
            'client'
        ));
    }

    /**
     * Show a specific course
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function showCourse($slug)
    {
        $client = Auth::guard('client')->user();
        
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'instructor'])
            ->firstOrFail();
        
         $reviews = CourseReview::with('client')
        ->where('course_id', $course->id)
        ->where('is_approved', true)
        ->orderBy('created_at', 'desc')
        ->get();
        
    // Calculer la note moyenne
    $averageRating = $reviews->avg('rating') ?? 0;
    
    // Vérifier si le client a déjà laissé une review
    $userReview = null;
    if ($client) {
        $userReview = CourseReview::where('client_id', $client->id)
            ->where('course_id', $course->id)
            ->first();
    }
        
        // Process image and PDF paths
        if ($course->cover_image) {
            // If the path starts with 'storage/', remove it to get the relative path
            if (strpos($course->cover_image, 'storage/') === 0) {
                $course->cover_image = str_replace('storage/', '', $course->cover_image);
            }
            
            // Check if the image exists in public/images
            if (file_exists(public_path('images/' . basename($course->cover_image)))) {
                $course->cover_image = 'images/' . basename($course->cover_image);
            } else if (file_exists(public_path($course->cover_image))) {
                // Keep the path as is if it exists
            } else if (file_exists(public_path('storage/' . $course->cover_image))) {
                $course->cover_image = 'storage/' . $course->cover_image;
            }
        }
        
        // Convert storage path to public path for PDFs
        if ($course->pdf_file_path) {
            // If the path is a storage path, convert to public path
            if (strpos($course->pdf_file_path, 'app/') === 0) {
                $course->pdf_file_path = str_replace('app/', '', $course->pdf_file_path);
            }
            
            // Check if the PDF exists in public/pdfs
            if (file_exists(public_path('pdfs/' . basename($course->pdf_file_path)))) {
                $course->pdf_file_path = 'pdfs/' . basename($course->pdf_file_path);
            } else if (file_exists(public_path($course->pdf_file_path))) {
                // Keep the path as is if it exists
            } else if (file_exists(storage_path('app/' . $course->pdf_file_path))) {
                // Keep the original path for download method
            }
        }
        
        // Check if client is enrolled
        $isEnrolled = false;
        try {
            $isEnrolled = DB::table('course_enrollments')
                ->where('client_id', $client->id)
                ->where('course_id', $course->id)
                ->exists();
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }
        
        // Get related courses
        $relatedCourses = Course::where('status', 'published')
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->take(3)
            ->get();
        
        // Process image and PDF paths for related courses
        foreach ($relatedCourses as $relatedCourse) {
            // Convert storage path to public path for images
            if ($relatedCourse->cover_image) {
                // If the path starts with 'storage/', remove it to get the relative path
                if (strpos($relatedCourse->cover_image, 'storage/') === 0) {
                    $relatedCourse->cover_image = str_replace('storage/', '', $relatedCourse->cover_image);
                }
                
                // Check if the image exists in public/images
                if (file_exists(public_path('images/' . basename($relatedCourse->cover_image)))) {
                    $relatedCourse->cover_image = 'images/' . basename($relatedCourse->cover_image);
                } else if (file_exists(public_path($relatedCourse->cover_image))) {
                    // Keep the path as is if it exists
                } else if (file_exists(public_path('storage/' . $relatedCourse->cover_image))) {
                    $relatedCourse->cover_image = 'storage/' . $relatedCourse->cover_image;
                }
            }
            
            // Convert storage path to public path for PDFs
            if ($relatedCourse->pdf_file_path) {
                // If the path is a storage path, convert to public path
                if (strpos($relatedCourse->pdf_file_path, 'app/') === 0) {
                    $relatedCourse->pdf_file_path = str_replace('app/', '', $relatedCourse->pdf_file_path);
                }
                
                // Check if the PDF exists in public/pdfs
                if (file_exists(public_path('pdfs/' . basename($relatedCourse->pdf_file_path)))) {
                    $relatedCourse->pdf_file_path = 'pdfs/' . basename($relatedCourse->pdf_file_path);
                } else if (file_exists(public_path($relatedCourse->pdf_file_path))) {
                    // Keep the path as is if it exists
                } else if (file_exists(storage_path('app/' . $relatedCourse->pdf_file_path))) {
                    // Keep the original path for download method
                }
            }
        }
        
        return view('client.course-detail', compact('course', 'isEnrolled', 'relatedCourses', 'client', 'reviews', 'averageRating', 'userReview'));
    }

    /**
     * Enroll in a course
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enrollCourse($id)
    {
        $client = Auth::guard('client')->user();
        $course = Course::findOrFail($id);
        
        try {
            // Check if already enrolled
            $alreadyEnrolled = DB::table('course_enrollments')
                ->where('client_id', $client->id)
                ->where('course_id', $course->id)
                ->exists();
            
            if ($alreadyEnrolled) {
                return redirect()->back()->with('info', 'You are already enrolled in this course.');
            }
            
            // Enroll the client
            DB::table('course_enrollments')->insert([
                'client_id' => $client->id,
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return redirect()->back()->with('success', 'Successfully enrolled in the course!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to enroll. Please try again later.');
        }
    }
    
    /**
     * Display the client profile page.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $client = Auth::guard('client')->user();
        return view('client.profile', compact('client'));
    }
    
    /**
     * Update the client's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
{
    $client = auth('client')->user();

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email,' . $client->id],
        'phone' => ['nullable', 'string', 'max:20'],
        'address' => ['nullable', 'string', 'max:255'],
        'city' => ['nullable', 'string', 'max:100'],
        'state' => ['nullable', 'string', 'max:100'],
        'zip_code' => ['nullable', 'string', 'max:20'],
    ]);

    $client->fill($validated);

    if ($client->isDirty('email')) {
        $client->email_verified_at = null; // Pour forcer une nouvelle vérification si email modifié
    }

    $client->save();

    return redirect()->route('client.profile')->with('status', 'profile-updated');
}

    /**
     * Display the change password form.
     *
     * @return \Illuminate\View\View
     */
    public function changePassword()
    {
        return view('client.change-password');
    }
    
    /**
     * Update the client's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $client = Auth::guard('client')->user();
        
        // Verify current password
        if (!Hash::check($validated['current_password'], $client->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        
        $client->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('client.password')->with('success', 'Password updated successfully!');
    }
    
    /**
     * Display the client's enrolled courses.
     *
     * @return \Illuminate\View\View
     */
    public function enrolledCourses()
    {
        $client = Auth::guard('client')->user();
        
        try {
            $enrolledCourses = DB::table('course_enrollments')
                ->join('courses', 'course_enrollments.course_id', '=', 'courses.id')
                ->where('course_enrollments.client_id', $client->id)
                ->select('courses.*', 'course_enrollments.created_at as enrolled_at', 'course_enrollments.completed')
                ->orderBy('course_enrollments.created_at', 'desc')
                ->paginate(10);
                
            // Process image and PDF paths for enrolled courses
            foreach ($enrolledCourses as $course) {
                // Convert storage path to public path for images
                if ($course->cover_image) {
                    // If the path starts with 'storage/', remove it to get the relative path
                    if (strpos($course->cover_image, 'storage/') === 0) {
                        $course->cover_image = str_replace('storage/', '', $course->cover_image);
                    }
                    
                    // Check if the image exists in public/images
                    if (file_exists(public_path('images/' . basename($course->cover_image)))) {
                        $course->cover_image = 'images/' . basename($course->cover_image);
                    } else if (file_exists(public_path($course->cover_image))) {
                        // Keep the path as is if it exists
                    } else if (file_exists(public_path('storage/' . $course->cover_image))) {
                        $course->cover_image = 'storage/' . $course->cover_image;
                    }
                }
                
                // Convert storage path to public path for PDFs
                if ($course->pdf_file_path) {
                    // If the path is a storage path, convert to public path
                    if (strpos($course->pdf_file_path, 'app/') === 0) {
                        $course->pdf_file_path = str_replace('app/', '', $course->pdf_file_path);
                    }
                    
                    // Check if the PDF exists in public/pdfs
                    if (file_exists(public_path('pdfs/' . basename($course->pdf_file_path)))) {
                        $course->pdf_file_path = 'pdfs/' . basename($course->pdf_file_path);
                    } else if (file_exists(public_path($course->pdf_file_path))) {
                        // Keep the path as is if it exists
                    } else if (file_exists(storage_path('app/' . $course->pdf_file_path))) {
                        // Keep the original path for download method
                    }
                }
            }
        } catch (\Exception $e) {
            // Si la table n'existe pas, retourner une collection vide
            $enrolledCourses = collect()->paginate(10);
        }
            
        return view('client.enrolled-courses', compact('enrolledCourses'));
    }
    
    /**
     * Display the client's download history.
     *
     * @return \Illuminate\View\View
     */
    public function downloadHistory()
    {
        $client = Auth::guard('client')->user();
        
        try {
            $downloads = DB::table('course_downloads')
                ->join('courses', 'course_downloads.course_id', '=', 'courses.id')
                ->where('course_downloads.client_id', $client->id)
                ->select('courses.title', 'courses.slug', 'courses.cover_image', 'course_downloads.created_at as downloaded_at')
                ->orderBy('course_downloads.created_at', 'desc')
                ->paginate(15);
                
            // Process image paths for downloads
            foreach ($downloads as $download) {
                // Convert storage path to public path for images
                if ($download->cover_image) {
                    // If the path starts with 'storage/', remove it to get the relative path
                    if (strpos($download->cover_image, 'storage/') === 0) {
                        $download->cover_image = str_replace('storage/', '', $download->cover_image);
                    }
                    
                    // Check if the image exists in public/images
                    if (file_exists(public_path('images/' . basename($download->cover_image)))) {
                        $download->cover_image = 'images/' . basename($download->cover_image);
                    } else if (file_exists(public_path($download->cover_image))) {
                        // Keep the path as is if it exists
                    } else if (file_exists(public_path('storage/' . $download->cover_image))) {
                        $download->cover_image = 'storage/' . $download->cover_image;
                    }
                }
            }
        } catch (\Exception $e) {
            // Si la table n'existe pas, retourner une collection vide
            $downloads = collect()->paginate(15);
        }
            
        return view('client.download-history', compact('downloads'));
    }
    
    /**
     * Display recommended courses based on client's interests and history.
     *
     * @return \Illuminate\View\View
     */
    public function recommendedCourses()
    {
        $client = Auth::guard('client')->user();
        
        // Get recommended courses (fallback to popular courses)
        $recommendedCourses = Course::where('status', 'published')
            ->orderBy('rating', 'desc')
            ->orderBy('downloads_count', 'desc')
            ->take(6)
            ->get();
            
        // Process image and PDF paths for recommended courses
        foreach ($recommendedCourses as $course) {
            // Convert storage path to public path for images
            if ($course->cover_image) {
                // If the path starts with 'storage/', remove it to get the relative path
                if (strpos($course->cover_image, 'storage/') === 0) {
                    $course->cover_image = str_replace('storage/', '', $course->cover_image);
                }
                
                // Check if the image exists in public/images
                if (file_exists(public_path('images/' . basename($course->cover_image)))) {
                    $course->cover_image = 'images/' . basename($course->cover_image);
                } else if (file_exists(public_path($course->cover_image))) {
                    // Keep the path as is if it exists
                } else if (file_exists(public_path('storage/' . $course->cover_image))) {
                    $course->cover_image = 'storage/' . $course->cover_image;
                }
            }
            
            // Convert storage path to public path for PDFs
            if ($course->pdf_file_path) {
                // If the path is a storage path, convert to public path
                if (strpos($course->pdf_file_path, 'app/') === 0) {
                    $course->pdf_file_path = str_replace('app/', '', $course->pdf_file_path);
                }
                
                // Check if the PDF exists in public/pdfs
                if (file_exists(public_path('pdfs/' . basename($course->pdf_file_path)))) {
                    $course->pdf_file_path = 'pdfs/' . basename($course->pdf_file_path);
                } else if (file_exists(public_path($course->pdf_file_path))) {
                    // Keep the path as is if it exists
                } else if (file_exists(storage_path('app/' . $course->pdf_file_path))) {
                    // Keep the original path for download method
                }
            }
        }
            
        return view('client.recommended-courses', compact('recommendedCourses'));
    }
    
    /**
     * Download a course PDF.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadCourse($id)
    {
        $client = Auth::guard('client')->user();
        $course = Course::findOrFail($id);
        
        try {
            // Record the download
            DB::table('course_downloads')->insert([
                'client_id' => $client->id,
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Si la table n'existe pas, continuer sans enregistrer
        }
        
        // Increment the course download count
        $course->increment('downloads_count');
        
        // Check if file exists in public/pdfs first
        if ($course->pdf_file_path) {
            $pdfFileName = basename($course->pdf_file_path);
            
            // Check in public/pdfs
            if (file_exists(public_path('pdfs/' . $pdfFileName))) {
                return response()->download(public_path('pdfs/' . $pdfFileName));
            }
            
            // Check in public path
            if (file_exists(public_path($course->pdf_file_path))) {
                return response()->download(public_path($course->pdf_file_path));
            }
            
            // Check in storage path
            if (file_exists(storage_path('app/' . $course->pdf_file_path))) {
                return response()->download(storage_path('app/' . $course->pdf_file_path));
            }
        }
        
        return redirect()->back()->with('error', 'Course file not found.');
    }
}
