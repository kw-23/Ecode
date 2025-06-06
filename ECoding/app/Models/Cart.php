<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'course_id',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the client that owns the cart item
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the course associated with the cart item
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the total price for this cart item
     */
    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get all cart items for a specific client
     */
    public static function getCartItems($clientId)
    {
        return self::with('course', 'course.category')
            ->where('client_id', $clientId)
            ->get();
    }

    /**
     * Get cart total for a specific client
     */
    public static function getCartTotal($clientId)
    {
        return self::where('client_id', $clientId)
            ->sum(\DB::raw('price * quantity'));
    }

    /**
     * Get cart count for a specific client
     */
    public static function getCartCount($clientId)
    {
        return self::where('client_id', $clientId)->count();
    }

    /**
     * Add item to cart
     */
    public static function addToCart($clientId, $courseId, $price)
    {
        return self::updateOrCreate(
            [
                'client_id' => $clientId,
                'course_id' => $courseId,
            ],
            [
                'price' => $price,
                'quantity' => 1,
            ]
        );
    }

    /**
     * Remove item from cart
     */
    public static function removeFromCart($clientId, $courseId)
    {
        return self::where('client_id', $clientId)
            ->where('course_id', $courseId)
            ->delete();
    }

    /**
     * Clear entire cart for a client
     */
    public static function clearCart($clientId)
    {
        return self::where('client_id', $clientId)->delete();
    }

    /**
     * Check if course is in cart
     */
    public static function isInCart($clientId, $courseId)
    {
        return self::where('client_id', $clientId)
            ->where('course_id', $courseId)
            ->exists();
    }
}   