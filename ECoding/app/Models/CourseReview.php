<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'client_id', // Changed from user_id to client_id
        'rating',
        'comment',
        'is_approved',
    ];

    /**
     * Get the course that owns the review.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the client that wrote the review.
     */
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class); // Assuming you have a Client model
    }

    /**
     * Scope for approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}