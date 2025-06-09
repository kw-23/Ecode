<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Models\CourseReview;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function dashboard()
    {
        $client = Auth::guard('client')->user();
        
        // Get total available courses
        $totalCourses = Course::where('status', 'published')->count();
        
        // Get new courses added this week
        $newCoursesThisWeek = Course::where('status', 'published')
            ->where('created_at', '>=', now()->subWeek())
            ->count();
            
        // Get client's purchased courses (without status filter)
        try {
            $purchasedCourses = Purchase::where('client_id', $client->id)
                ->count();
                
            $completionRate = $purchasedCourses > 0 ? 75 : 0;
                
            $totalLearningHours = Purchase::where('client_id', $client->id)
                ->join('courses', 'purchases.course_id', '=', 'courses.id')
                ->sum('courses.estimated_hours') ?? 0;
        } catch (\Exception $e) {
            $purchasedCourses = 0;
            $completionRate = 0;
            $totalLearningHours = 0;
        }
        
        $learningHoursThisWeek = 5;
        $averageRating = Course::where('status', 'published')->avg('rating') ?? 4.8;
        
        $featuredCourses = Course::where('status', 'published')
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        foreach ($featuredCourses as $course) {
            $this->processCoursePaths($course);
        }
            
        $categories = CourseCategory::withCount(['courses' => function($query) {
                $query->where('status', 'published');
            }])
            ->orderBy('courses_count', 'desc')
            ->take(5)
            ->get();
            
        $popularLanguages = $this->getPopularLanguages();
        
        return view('client.dashboard', compact(
            'client',
            'totalCourses',
            'newCoursesThisWeek',
            'purchasedCourses',
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
     */
    public function courses(Request $request)
    {
        $client = Auth::guard('client')->user();
        
        $query = Course::where('status', 'published')
            ->with(['category', 'instructor']);
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }
        
        if ($request->filled('price_type')) {
            if ($request->price_type === 'free') {
                $query->where('price', 0);
            } elseif ($request->price_type === 'paid') {
                $query->where('price', '>', 0);
            }
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }
        
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
        
        $courses = $query->paginate(12)->withQueryString();
        
        foreach ($courses as $course) {
            $this->processCoursePaths($course);
        }
        
        $categories = CourseCategory::orderBy('name')->get();
        
        $purchasedCourseIds = collect();
        try {
            $purchasedCourseIds = Purchase::where('client_id', $client->id)
                ->pluck('course_id');
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }
        
        return view('client.courses', compact(
            'courses',
            'categories',
            'purchasedCourseIds',
            'client'
        ));
    }

    /**
     * Show a specific course
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
        
        $averageRating = $reviews->avg('rating') ?? 0;
        
        $userReview = null;
        if ($client) {
            $userReview = CourseReview::where('client_id', $client->id)
                ->where('course_id', $course->id)
                ->first();
        }
        
        $this->processCoursePaths($course);
        
        $hasPurchased = false;
        try {
            $hasPurchased = Purchase::where('client_id', $client->id)
                ->where('course_id', $course->id)
                ->exists();
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }
        
        $relatedCourses = Course::where('status', 'published')
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->take(3)
            ->get();
        
        foreach ($relatedCourses as $relatedCourse) {
            $this->processCoursePaths($relatedCourse);
        }
        
        return view('client.course-detail', compact(
            'course', 
            'hasPurchased', 
            'relatedCourses', 
            'client', 
            'reviews', 
            'averageRating', 
            'userReview'
        ));
    }

    /**
     * Display the client's purchased courses (without status filter)
     */
    public function purchasedCourses()
    {
        $client = Auth::guard('client')->user();
        
        $purchases = Purchase::with(['course' => function($query) {
                $query->with(['instructor', 'category']);
            }])
            ->where('client_id', $client->id)
            ->orderBy('purchased_at', 'desc')
            ->get();
            
        foreach ($purchases as $purchase) {
            if ($purchase->course) {
                $this->processCoursePaths($purchase->course);
            }
        }
            
        return view('client.purchased-courses', compact('purchases'));
    }

    /**
     * Show course details for purchased course (without status check)
     */
    public function showPurchasedCourse($courseId)
    {
        $client = Auth::guard('client')->user();
        
        $purchase = Purchase::where('client_id', $client->id)
            ->where('course_id', $courseId)
            ->first();
            
        if (!$purchase) {
            return redirect()->route('client.purchased-courses')
                ->with('error', 'You do not have access to this course.');
        }
        
        $course = Course::with(['instructor', 'category'])
            ->findOrFail($courseId);
        
        $this->processCoursePaths($course);
        
        $reviews = CourseReview::with('client')
            ->where('course_id', $course->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $averageRating = $reviews->avg('rating') ?? 0;
        
        return view('client.purchased-course-detail', compact(
            'course', 
            'purchase', 
            'reviews', 
            'averageRating'
        ));
    }

    /**
     * Download course PDF materials (without status check)
     */
    public function downloadCourse($courseId)
    {
        $client = Auth::guard('client')->user();
        
        $purchase = Purchase::where('client_id', $client->id)
            ->where('course_id', $courseId)
            ->first();
            
        if (!$purchase) {
            return redirect()->route('client.purchased-courses')
                ->with('error', 'You do not have access to these course materials.');
        }
        
        $course = Course::findOrFail($courseId);
        
        if (!$course->pdf_file_path) {
            return back()->with('error', 'Course materials are not available yet.');
        }
        
        $filePaths = [
            public_path('pdfs/' . basename($course->pdf_file_path)),
            public_path($course->pdf_file_path),
            storage_path('app/' . $course->pdf_file_path),
            storage_path('app/public/' . $course->pdf_file_path)
        ];
        
        $filePath = null;
        foreach ($filePaths as $path) {
            if (file_exists($path)) {
                $filePath = $path;
                break;
            }
        }
        
        if (!$filePath) {
            return back()->with('error', 'Course materials file not found.');
        }
        
        try {
            DB::table('course_downloads')->insert([
                'client_id' => $client->id,
                'course_id' => $course->id,
                'purchase_id' => $purchase->id,
                'downloaded_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Table might not exist, continue without logging
        }
        
        $course->increment('downloads_count');
        
        $fileName = Str::slug($course->title) . '-materials.pdf';
        
        return Response::download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }
    
    /**
     * Display the client profile page.
     */
    public function profile()
    {
        $client = Auth::guard('client')->user();
        return view('client.profile', compact('client'));
    }
    
    /**
     * Update the client's profile information.
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
            $client->email_verified_at = null;
        }

        $client->save();

        return redirect()->route('client.profile')->with('status', 'profile-updated');
    }

    /**
     * Display the change password form.
     */
    public function changePassword()
    {
        return view('client.change-password');
    }
    
    /**
     * Update the client's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $client = Auth::guard('client')->user();
        
        if (!Hash::check($validated['current_password'], $client->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        
        $client->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('client.password')->with('success', 'Password updated successfully!');
    }
    
    /**
     * Display the client's enrolled courses (legacy).
     */
    public function enrolledCourses()
    {
        return redirect()->route('client.purchased-courses');
    }
    
    /**
     * Display the client's download history.
     */
    public function downloadHistory()
    {
        $client = Auth::guard('client')->user();
        
        try {
            $downloads = Purchase::with('course')
                ->where('client_id', $client->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
                
            foreach ($downloads as $download) {
                if ($download->course) {
                    $this->processCoursePaths($download->course);
                }
            }
        } catch (\Exception $e) {
            $downloads = collect()->paginate(15);
        }
            
        return view('client.download-history', compact('downloads'));
    }
    
    /**
     * Display recommended courses.
     */
    public function recommendedCourses()
    {
        $client = Auth::guard('client')->user();
        
        $recommendedCourses = Course::where('status', 'published')
            ->orderBy('rating', 'desc')
            ->orderBy('downloads_count', 'desc')
            ->take(6)
            ->get();
            
        foreach ($recommendedCourses as $course) {
            $this->processCoursePaths($course);
        }
            
        return view('client.recommended-courses', compact('recommendedCourses'));
    }

    /**
     * Process course image and PDF paths
     */
    private function processCoursePaths($course)
    {
        if ($course->cover_image) {
            if (strpos($course->cover_image, 'storage/') === 0) {
                $course->cover_image = str_replace('storage/', '', $course->cover_image);
            }
            
            if (file_exists(public_path('images/' . basename($course->cover_image)))) {
                $course->cover_image = 'images/' . basename($course->cover_image);
            } else if (file_exists(public_path($course->cover_image))) {
                // Keep the path as is
            } else if (file_exists(public_path('storage/' . $course->cover_image))) {
                $course->cover_image = 'storage/' . $course->cover_image;
            }
        }
        
        if ($course->pdf_file_path) {
            if (strpos($course->pdf_file_path, 'app/') === 0) {
                $course->pdf_file_path = str_replace('app/', '', $course->pdf_file_path);
            }
            
            if (file_exists(public_path('pdfs/' . basename($course->pdf_file_path)))) {
                $course->pdf_file_path = 'pdfs/' . basename($course->pdf_file_path);
            } else if (file_exists(public_path($course->pdf_file_path))) {
                // Keep the path as is
            } else if (file_exists(storage_path('app/' . $course->pdf_file_path))) {
                // Keep the original path for download method
            }
        }
    }

    /**
     * Get popular programming languages from course tags
     */
    private function getPopularLanguages()
    {
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
            
            return $allTags->countBy()->sortDesc()->take(5);
        } catch (\Exception $e) {
            return collect([
                'JavaScript' => 15,
                'Python' => 12,
                'PHP' => 10,
                'Java' => 8,
                'React' => 7
            ]);
        }
    }
}