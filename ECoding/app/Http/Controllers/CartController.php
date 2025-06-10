<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Course;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CartPurchaseConfirmationMail;

class CartController extends Controller
{
    /**
     * Display the cart page with modern design
     */
    public function index()
    {
        $clientId = Auth::guard('client')->id();
        $cartItems = Cart::getCartItems($clientId);
        $cartTotal = Cart::getCartTotal($clientId);
        $cartCount = Cart::getCartCount($clientId);

        // Check for already purchased courses
        $purchasedCourseIds = Purchase::where('client_id', $clientId)
            ->where('status', 'completed')
            ->pluck('course_id')
            ->toArray();

        // Calculate pricing breakdown
        $subtotal = $cartItems->sum('total');
        $discount = $subtotal * 0.1; // 10% discount
        $tax = ($subtotal - $discount) * 0.08; // 8% tax
        $shipping = 0; // Free shipping
        $finalTotal = $subtotal - $discount + $tax + $shipping;

        // Ensure all course images are valid
        $this->validateCourseImages($cartItems);

        return view('cart.index', compact(
            'cartItems', 
            'cartTotal', 
            'cartCount', 
            'purchasedCourseIds',
            'subtotal',
            'discount',
            'tax',
            'shipping',
            'finalTotal'
        ));
    }

    /**
     * Add course to cart with AJAX response
     */
    public function add(Request $request, Course $course)
    {
        if (!Auth::guard('client')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to cart',
                'redirect' => route('client.login')
            ], 401);
        }

        $clientId = Auth::guard('client')->id();

        // Check if user already purchased this course
        $alreadyPurchased = Purchase::where('client_id', $clientId)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->exists();

        if ($alreadyPurchased) {
            return response()->json([
                'success' => false,
                'message' => 'You already own this course',
                'type' => 'warning'
            ], 400);
        }

        // Check if course is already in cart
        if (Cart::isInCart($clientId, $course->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Course is already in your cart',
                'type' => 'info'
            ], 400);
        }

        try {
            Cart::addToCart($clientId, $course->id, $course->price ?? 99);

            $cartCount = Cart::getCartCount($clientId);
            $cartTotal = Cart::getCartTotal($clientId);

            // Ensure course image is valid
            $courseImage = $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('images/course-placeholder.jpg');

            return response()->json([
                'success' => true,
                'message' => 'Course added to cart successfully!',
                'type' => 'success',
                'cartCount' => $cartCount,
                'cartTotal' => number_format($cartTotal, 2),
                'courseImage' => $courseImage
            ]);
        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to add course to cart',
                'type' => 'error'
            ], 500);
        }
    }

    /**
     * Remove course from cart with smooth animation
     */
    public function remove(Request $request, Course $course)
    {
        $clientId = Auth::guard('client')->id();

        try {
            Cart::removeFromCart($clientId, $course->id);

            $cartCount = Cart::getCartCount($clientId);
            $cartTotal = Cart::getCartTotal($clientId);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Course removed from cart',
                    'type' => 'success',
                    'cartCount' => $cartCount,
                    'cartTotal' => number_format($cartTotal, 2),
                    'isEmpty' => $cartCount === 0
                ]);
            }

            return redirect()->route('cart.index')
                ->with('success', 'Course removed from cart');
        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove course from cart',
                    'type' => 'error'
                ], 500);
            }

            return redirect()->route('cart.index')
                ->with('error', 'Failed to remove course from cart');
        }
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request)
    {
        $clientId = Auth::guard('client')->id();

        try {
            Cart::clearCart($clientId);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart cleared successfully',
                    'type' => 'success',
                    'cartCount' => 0,
                    'cartTotal' => '0.00'
                ]);
            }

            return redirect()->route('cart.index')
                ->with('success', 'Cart cleared successfully');
        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to clear cart',
                    'type' => 'error'
                ], 500);
            }

            return redirect()->route('cart.index')
                ->with('error', 'Failed to clear cart');
        }
    }

    /**
     * Modern checkout page
     */
    public function checkout()
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login')
                ->with('message', 'Please login to proceed with checkout.');
        }

        $clientId = Auth::guard('client')->id();
        $cartItems = Cart::getCartItems($clientId);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        // Load relationships for cart items
        $cartItems->load(['course.category', 'course.instructor']);

        // Get cart count
        $cartCount = Cart::getCartCount($clientId);
        
        // Calculate pricing
        $subtotal = $cartItems->sum('total');
        $discount = $subtotal * 0.1; // 10% discount
        $tax = ($subtotal - $discount) * 0.08; // 8% tax
        $shipping = 0; // Free shipping
        $finalTotal = $subtotal - $discount + $tax + $shipping;

        // Check for already purchased courses
        $purchasedCourseIds = Purchase::where('client_id', $clientId)
            ->where('status', 'completed')
            ->pluck('course_id')
            ->toArray();

        // Remove already purchased courses from cart
        foreach ($cartItems as $item) {
            if (in_array($item->course_id, $purchasedCourseIds)) {
                Cart::removeFromCart($clientId, $item->course_id);
            }
        }

        // Refresh cart items after removing purchased courses
        $cartItems = Cart::getCartItems($clientId);
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        // Ensure all course images are valid
        $this->validateCourseImages($cartItems);

        return view('payment.checkout', compact(
            'cartItems', 
            'cartCount',
            'subtotal', 
            'discount', 
            'tax', 
            'shipping', 
            'finalTotal',
            'purchasedCourseIds'
        ));
    }

    /**
     * Process cart payment with modern error handling
     */
    public function processCartPayment(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0',
                'payment_method' => 'required|string',
                'email' => 'required|email',
                'name' => 'required|string|max:255'
            ]);

            if (!Auth::guard('client')->check()) {
                return response()->json([
                    'error' => [
                        'message' => 'Authentication required.',
                        'type' => 'auth_error'
                    ]
                ], 401);
            }

            $clientId = Auth::guard('client')->id();
            $cartItems = Cart::getCartItems($clientId);

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'error' => [
                        'message' => 'Your cart is empty.',
                        'type' => 'cart_empty'
                    ]
                ], 400);
            }

            // Create payment intent
            $response = Http::timeout(30)->post('http://localhost:5000/payment_intent', [
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'metadata' => [
                    'cart_items' => $cartItems->pluck('course_id')->toArray(),
                    'client_id' => $clientId,
                    'email' => $request->email,
                    'name' => $request->name,
                    'type' => 'cart_purchase'
                ]
            ]);

            if ($response->successful()) {
                $paymentData = $response->json();
                
                // Create pending purchase records with calculated prices
                DB::transaction(function () use ($cartItems, $clientId, $paymentData) {
                    // Calculate pricing breakdown
                    $subtotal = $cartItems->sum('total');
                    $discount = $subtotal * 0.1; // 10% discount
                    $tax = ($subtotal - $discount) * 0.08; // 8% tax
                    $shipping = 0; // Free shipping
                    $finalTotal = $subtotal - $discount + $tax + $shipping;

                    // Calculate individual course prices after discount and tax
                    $discountRate = $discount / $subtotal; // Discount rate per course
                    $taxRate = $tax / ($subtotal - $discount); // Tax rate after discount

                    foreach ($cartItems as $item) {
                        $courseSubtotal = $item->price;
                        $courseDiscount = $courseSubtotal * $discountRate;
                        $coursePriceAfterDiscount = $courseSubtotal - $courseDiscount;
                        $courseTax = $coursePriceAfterDiscount * $taxRate;
                        $finalCoursePrice = $coursePriceAfterDiscount + $courseTax;

                        Purchase::create([
                            'client_id' => $clientId,
                            'course_id' => $item->course_id,
                            'payment_intent_id' => $paymentData['payment_intent_id'] ?? null,
                            'amount' => $finalCoursePrice,
                            'status' => 'pending',
                            'purchased_at' => now(),
                        ]);
                    }
                });

                return response()->json([
                    'success' => true,
                    'client_secret' => $paymentData['clientSecret'],
                    'payment_intent_id' => $paymentData['payment_intent_id'] ?? null
                ]);
            } else {
                return response()->json([
                    'error' => [
                        'message' => 'Payment service unavailable. Please try again.',
                        'type' => 'payment_error'
                    ]
                ], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => [
                    'message' => 'Please check your payment information.',
                    'type' => 'validation_error',
                    'details' => $e->errors()
                ]
            ], 422);
        } catch (\Exception $e) {
            Log::error('Cart payment processing error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => [
                    'message' => 'An unexpected error occurred. Please try again.',
                    'type' => 'server_error'
                ]
            ], 500);
        }
    }

    /**
     * Cart payment success with celebration
     */
    public function cartPaymentSuccess(Request $request)
    {
        $paymentIntentId = $request->get('payment_intent');
        
        if (!$paymentIntentId) {
            return redirect()->route('cart.index')
                ->with('error', 'Invalid payment session.');
        }

        $clientId = Auth::guard('client')->id();

        try {
            DB::transaction(function () use ($paymentIntentId, $clientId) {
                $purchases = Purchase::where('payment_intent_id', $paymentIntentId)
                    ->where('client_id', $clientId)
                    ->get();

                foreach ($purchases as $purchase) {
                    $purchase->update([
                        'status' => 'completed',
                        'purchased_at' => now(),
                    ]);

                    // Update course statistics
                    $course = Course::find($purchase->course_id);
                    if ($course) {
                        $course->increment('downloads_count');
                        $course->increment('sales_count');
                    }
                }

                // Clear the cart after successful payment
                Cart::clearCart($clientId);
            });

            $purchasedCourses = Purchase::where('payment_intent_id', $paymentIntentId)
                ->where('client_id', $clientId)
                ->with(['course.category', 'course.instructor'])
                ->get();

            // Get client details for email
            $client = Auth::guard('client')->user();
            
            // Send confirmation email
            try {
                Log::info('Attempting to send cart purchase confirmation email', [
                    'client_id' => $clientId,
                    'payment_intent_id' => $paymentIntentId,
                    'courses_count' => $purchasedCourses->count()
                ]);

                Mail::to($client->email)->send(new CartPurchaseConfirmationMail($purchasedCourses, $client));

                Log::info('Cart purchase confirmation email sent successfully', [
                    'client_id' => $clientId,
                    'payment_intent_id' => $paymentIntentId
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send cart purchase confirmation email', [
                    'client_id' => $clientId,
                    'payment_intent_id' => $paymentIntentId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Don't throw the error - we still want to show the success page
            }

            return view('cart.payment-success', compact('purchasedCourses'));

        } catch (\Exception $e) {
            Log::error('Cart payment success processing error: ' . $e->getMessage(), [
                'client_id' => $clientId,
                'payment_intent_id' => $paymentIntentId,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('cart.index')
                ->with('error', 'There was an issue processing your payment. Please contact support.');
        }
    }

    /**
     * Get cart data for AJAX requests
     */
    public function getCartData()
    {
        if (!Auth::guard('client')->check()) {
            return response()->json([
                'count' => 0,
                'total' => '0.00',
                'items' => []
            ]);
        }

        $clientId = Auth::guard('client')->id();
        $cartItems = Cart::getCartItems($clientId);
        $cartCount = Cart::getCartCount($clientId);
        $cartTotal = Cart::getCartTotal($clientId);

        // Ensure all course images are valid
        $this->validateCourseImages($cartItems);

        return response()->json([
            'count' => $cartCount,
            'total' => number_format($cartTotal, 2),
            'items' => $cartItems->map(function ($item) {
                $imageUrl = $item->course->thumbnail 
                    ? asset('storage/' . $item->course->thumbnail) 
                    : asset('images/course-placeholder.jpg');
                
                return [
                    'id' => $item->course_id,
                    'title' => $item->course->title,
                    'price' => number_format($item->price, 2),
                    'image' => $imageUrl
                ];
            })
        ]);
    }

    /**
     * Validate and ensure course images are available
     */
    private function validateCourseImages($cartItems)
    {
        foreach ($cartItems as $item) {
            if ($item->course && $item->course->thumbnail) {
                $path = 'public/' . $item->course->thumbnail;
                if (!Storage::exists($path)) {
                    // Set default placeholder if image doesn't exist
                    $item->course->thumbnail = null;
                }
            }
        }
    }
}