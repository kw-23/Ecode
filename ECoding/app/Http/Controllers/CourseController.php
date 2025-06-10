<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseReview;
use App\Models\Purchase;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('courses.index', compact('courses'));
    }
     
    public function searchByName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $courses = Course::with(['category', 'instructor'])
            ->where('title', 'like', '%' . $request->name . '%')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show all courses without any restrictions.
     */
    public function all(Request $request)
    {
        $query = Course::with(['category', 'instructor']);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('short_description', 'like', "%{$searchTerm}%")
                  ->orWhereHas('instructor', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('category', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Difficulty filter
        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }

        // Price filter
        if ($request->filled('price_type')) {
            if ($request->price_type === 'free') {
                $query->where('price', 0);
            } elseif ($request->price_type === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'popular':
                $query->withCount('enrollments')->orderBy('enrollments_count', 'desc');
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
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('updated_at', 'desc');
        }

        $courses = $query->paginate(15);
        $categories = CourseCategory::where('is_active', true)->get();

        return view('courses.all', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = CourseCategory::where('is_active', true)->get();
        return view('courses.create', compact('categories'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published,archived',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'estimated_hours' => 'nullable|integer|min:1',
            'tags' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
        ]);

        // Handle slug
        $validated['slug'] = Str::slug($validated['title']);
        
        // Handle tags (convert comma-separated string to JSON array)
        if (isset($validated['tags'])) {
            $validated['tags'] = explode(',', $validated['tags']);
        }
        
        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $imagesPath = public_path('images');
            if (!File::exists($imagesPath)) {
                File::makeDirectory($imagesPath, 0755, true);
            }
            
            $image = $request->file('cover_image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $image->move($imagesPath, $imageName);
            
            $validated['cover_image'] = 'images/' . $imageName;
        }
        
        // Handle PDF file upload
        if ($request->hasFile('pdf_file')) {
            $pdfsPath = public_path('pdfs');
            if (!File::exists($pdfsPath)) {
                File::makeDirectory($pdfsPath, 0755, true);
            }
            
            $pdf = $request->file('pdf_file');
            $pdfName = time() . '_' . Str::slug($validated['title']) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move($pdfsPath, $pdfName);
            
            $validated['pdf_file_path'] = 'pdfs/' . $pdfName;
        }
        
        // Set instructor ID
        $validated['instructor_id'] = Auth::id();
        
        // Set published_at if status is published
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }
        
        $course = Course::create($validated);
        
        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified course with enhanced purchase logic.
     */
    public function show(Course $course)
    {
        $course->load(['category', 'instructor']);
        
        // Get reviews with client information
        $reviews = CourseReview::with('client')
                          ->where('course_id', $course->id)
                          ->where('is_approved', true)
                          ->orderBy('created_at', 'desc')
                          ->get();

        // Calculate average rating
        $averageRating = $reviews->avg('rating') ?? 0;

        // Check if current client has already reviewed
        $userReview = null;
        if (Auth::guard('client')->check()) {
            $userReview = CourseReview::where('client_id', Auth::guard('client')->id())
                                 ->where('course_id', $course->id)
                                 ->first();
        }

        // Enhanced purchase status checking
        $purchaseStatus = $this->getPurchaseStatus($course->id);
        $isEnrolled = $purchaseStatus['status'] === 'purchased';

        // Get related courses
        $relatedCourses = Course::where('status', 'published')
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->take(3)
            ->get();

        // Get course statistics
        $courseStats = [
            'enrollments' => $course->enrollments()->count(),
            'reviews' => $reviews->count(),
            'downloads' => $course->downloads_count ?? 0,
            'rating' => $averageRating
        ];
        
        return view('courses.show', compact(
            'course', 
            'reviews', 
            'averageRating', 
            'userReview', 
            'isEnrolled', 
            'relatedCourses',
            'purchaseStatus',
            'courseStats'
        ));
    }

    /**
     * Get comprehensive purchase status for a course
     */
    private function getPurchaseStatus($courseId)
    {
        if (!Auth::guard('client')->check()) {
            return [
                'status' => 'not_authenticated',
                'message' => 'Please login to purchase this course',
                'purchase' => null,
                'is_in_cart' => false
            ];
        }

        $clientId = Auth::guard('client')->id();
        
        // Check for completed purchase
        $completedPurchase = Purchase::where('client_id', $clientId)
            ->where('course_id', $courseId)
            ->where('status', 'completed')
            ->first();

        if ($completedPurchase) {
            return [
                'status' => 'purchased',
                'message' => 'Course purchased successfully',
                'purchase' => $completedPurchase,
                'purchase_date' => $completedPurchase->created_at,
                'is_in_cart' => false
            ];
        }

        // Check for pending purchase
        $pendingPurchase = Purchase::where('client_id', $clientId)
            ->where('course_id', $courseId)
            ->where('status', 'pending')
            ->first();

        if ($pendingPurchase) {
            return [
                'status' => 'pending',
                'message' => 'Payment is being processed',
                'purchase' => $pendingPurchase,
                'created_at' => $pendingPurchase->created_at,
                'is_in_cart' => false
            ];
        }

        // Check if in cart
        $isInCart = false;
        if (class_exists('App\Models\Cart')) {
            $isInCart = Cart::where('client_id', $clientId)
                ->where('course_id', $courseId)
                ->exists();
        }

        // Check for failed purchase
        $failedPurchase = Purchase::where('client_id', $clientId)
            ->where('course_id', $courseId)
            ->where('status', 'failed')
            ->latest()
            ->first();

        if ($failedPurchase) {
            return [
                'status' => 'failed',
                'message' => 'Previous payment failed. Please try again.',
                'purchase' => $failedPurchase,
                'failed_at' => $failedPurchase->updated_at,
                'is_in_cart' => $isInCart
            ];
        }

        return [
            'status' => 'not_purchased',
            'message' => 'Course not purchased',
            'purchase' => null,
            'is_in_cart' => $isInCart
        ];
    }

    /**
     * AJAX endpoint to check enrollment status
     */
    public function checkEnrollment(Course $course)
    {
        if (!Auth::guard('client')->check()) {
            return response()->json([
                'purchased' => false,
                'status' => 'not_authenticated'
            ]);
        }

        $purchaseStatus = $this->getPurchaseStatus($course->id);
        
        return response()->json([
            'purchased' => $purchaseStatus['status'] === 'purchased',
            'status' => $purchaseStatus['status'],
            'message' => $purchaseStatus['message'],
            'has_download' => $course->pdf_file_path && file_exists(public_path($course->pdf_file_path))
        ]);
    }

    /**
     * Enhanced download method with better security
     */
    public function download(Course $course)
    {
        // Check authentication
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login')
                ->with('error', 'Please login to download course materials.');
        }

        // Check purchase status
        $purchaseStatus = $this->getPurchaseStatus($course->id);
        
        

        // Check if file exists
        if (!$course->pdf_file_path) {
            return redirect()->back()
                ->with('error', 'No downloadable file available for this course.');
        }

        $filePath = public_path($course->pdf_file_path);
        
        if (!File::exists($filePath)) {
            return redirect()->back()
                ->with('error', 'Course file not found. Please contact support.');
        }

        // Log the download
        $this->logDownload($course, $purchaseStatus['purchase']);

        // Increment download count
        $course->increment('downloads_count');

        // Generate secure filename
        $filename = Str::slug($course->title) . '_' . date('Y-m-d') . '.pdf';

        return response()->download($filePath, $filename, [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    /**
     * Log download activity
     */
    private function logDownload($course, $purchase)
    {
        try {
            DB::table('download_logs')->insert([
                'client_id' => Auth::guard('client')->id(),
                'course_id' => $course->id,
                'purchase_id' => $purchase ? $purchase->id : null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'downloaded_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            // Log error but don't prevent download
            Log::error('Failed to log download: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $categories = CourseCategory::where('is_active', true)->get();
        return view('courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'category_id' => 'required|exists:course_categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,published,archived',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'estimated_hours' => 'nullable|integer|min:1',
            'tags' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
        ]);
        
        // Handle slug (only update if title changed)
        if ($course->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }
        
        // Handle tags (convert comma-separated string to JSON array)
        if (isset($validated['tags'])) {
            $validated['tags'] = explode(',', $validated['tags']);
        }
        
        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($course->cover_image && File::exists(public_path($course->cover_image))) {
                File::delete(public_path($course->cover_image));
            }
            
            $imagesPath = public_path('images');
            if (!File::exists($imagesPath)) {
                File::makeDirectory($imagesPath, 0755, true);
            }
            
            $image = $request->file('cover_image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $image->move($imagesPath, $imageName);
            
            $validated['cover_image'] = 'images/' . $imageName;
        }
        
        // Handle PDF file upload
        if ($request->hasFile('pdf_file')) {
            // Delete old file if exists
            if ($course->pdf_file_path && File::exists(public_path($course->pdf_file_path))) {
                File::delete(public_path($course->pdf_file_path));
            }
            
            $pdfsPath = public_path('pdfs');
            if (!File::exists($pdfsPath)) {
                File::makeDirectory($pdfsPath, 0755, true);
            }
            
            $pdf = $request->file('pdf_file');
            $pdfName = time() . '_' . Str::slug($validated['title']) . '.' . $pdf->getClientOriginalExtension();
            $pdf->move($pdfsPath, $pdfName);
            
            $validated['pdf_file_path'] = 'pdfs/' . $pdfName;
        }
        
        // Set published_at if status changed to published
        if ($course->status !== 'published' && $validated['status'] === 'published') {
            $validated['published_at'] = now();
        }
        
        $course->update($validated);
        
        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        // Delete associated files
        if ($course->cover_image && File::exists(public_path($course->cover_image))) {
            File::delete(public_path($course->cover_image));
        }
        
        if ($course->pdf_file_path && File::exists(public_path($course->pdf_file_path))) {
            File::delete(public_path($course->pdf_file_path));
        }
        
        $course->delete();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully!');
    }

    /**
     * Generate course report
     */
    public function coursesReport()
    {
        $courses = Course::withCount(['enrollments', 'reviews'])
                        ->with('category', 'instructor')
                        ->get();
                        
        return view('reports.courses', compact('courses'));
    }

    /**
     * Generate enrollments report
     */
    public function enrollmentsReport()
    {
        $enrollments = \App\Models\CourseEnrollment::with(['course', 'user'])
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                                                
        return view('reports.enrollments', compact('enrollments'));
    }
}