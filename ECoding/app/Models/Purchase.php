<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'course_id',
        'payment_intent_id',
        'amount',
        'status',
        'purchased_at',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Scope for completed purchases
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Check if purchase is completed
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}