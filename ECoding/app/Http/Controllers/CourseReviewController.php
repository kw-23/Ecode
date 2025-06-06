<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseReviewController extends Controller
{
    
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Check if client already reviewed this course
        $existingReview = CourseReview::where('client_id', Auth::guard('client')->id())
                                    ->where('course_id', $course->id)
                                    ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this course.');
        }

        CourseReview::create([
            'client_id' => Auth::guard('client')->id(),
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true, // Auto-approve or set to false for manual approval
        ]);

        // Update course average rating
        $this->updateCourseRating($course);

        return redirect()->back()->with('success', 'Your review has been submitted successfully!');
    }

    public function update(Request $request, Course $course, CourseReview $review)
    {
        // Check if client owns this review
        if ($review->client_id !== Auth::guard('client')->id()) {
            return redirect()->back()->with('error', 'You can only edit your own reviews.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update course average rating
        $this->updateCourseRating($course);

        return redirect()->back()->with('success', 'Your review has been updated successfully!');
    }

    public function destroy(Course $course, CourseReview $review)
    {
        // Check if client owns this review
        if ($review->client_id !== Auth::guard('client')->id()) {
            return redirect()->back()->with('error', 'You can only delete your own reviews.');
        }

        $review->delete();

        // Update course average rating
        $this->updateCourseRating($course);

        return redirect()->back()->with('success', 'Your review has been deleted successfully!');
    }

    /**
     * Update the course's average rating
     */
    private function updateCourseRating(Course $course)
    {
        $averageRating = CourseReview::where('course_id', $course->id)
                                    ->where('is_approved', true)
                                    ->avg('rating') ?? 0;
        
        $course->update(['rating' => $averageRating]);
    }
}