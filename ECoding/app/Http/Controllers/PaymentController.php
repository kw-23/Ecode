<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function checkout(Course $course)
    {
        // Check if user is authenticated
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login')
                ->with('message', 'Please login to purchase this course.');
        }

        // Check if user already purchased this course
        $existingPurchase = Purchase::where('client_id', Auth::guard('client')->id())
            ->where('course_id', $course->id)
            ->first();

        if ($existingPurchase) {
            return redirect()->route('client.course.show', $course)
                ->with('info', 'You already have access to this course.');
        }

        return view('payment.checkout', compact('course'));
    }

    public function success(Request $request, Course $course)
    {
        $paymentIntentId = $request->get('payment_intent');
        
        if (!$paymentIntentId) {
            return redirect()->route('client.course.show', $course)
                ->with('error', 'Invalid payment session.');
        }

        // Verify payment with Stripe (optional - you can call your Express server)
        try {
            // Record the purchase in database
            DB::transaction(function () use ($course, $paymentIntentId) {
                $purchase = Purchase::firstOrCreate([
                    'client_id' => Auth::guard('client')->id(),
                    'course_id' => $course->id,
                ], [
                    'payment_intent_id' => $paymentIntentId,
                    'amount' => $course->price ?? 99,
                    'status' => 'completed',
                    'purchased_at' => now(),
                ]);

                // Update course downloads count
                $course->increment('downloads_count');
            });

            // Send confirmation email (implement as needed)
            // Mail::to(Auth::guard('client')->user())->send(new PurchaseConfirmation($course));

            return view('payment.success', compact('course'));

        } catch (\Exception $e) {
            Log::error('Payment success processing error: ' . $e->getMessage());
            
            return redirect()->route('client.course.show', $course)
                ->with('error', 'There was an issue processing your payment. Please contact support.');
        }
    }

    public function webhook(Request $request)
    {
        // Handle Stripe webhooks for additional security
        // This is optional but recommended for production
        
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
            
            switch ($event['type']) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event['data']['object'];
                    // Handle successful payment
                    $this->handleSuccessfulPayment($paymentIntent);
                    break;
                    
                case 'payment_intent.payment_failed':
                    $paymentIntent = $event['data']['object'];
                    // Handle failed payment
                    $this->handleFailedPayment($paymentIntent);
                    break;
                    
                default:
                    Log::info('Received unknown event type: ' . $event['type']);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook error'], 400);
        }
    }

    private function handleSuccessfulPayment($paymentIntent)
    {
        // Update purchase status in database
        $purchase = Purchase::where('payment_intent_id', $paymentIntent['id'])->first();
        
        if ($purchase) {
            $purchase->update(['status' => 'completed']);
        }
    }

    private function handleFailedPayment($paymentIntent)
    {
        // Update purchase status in database
        $purchase = Purchase::where('payment_intent_id', $paymentIntent['id'])->first();
        
        if ($purchase) {
            $purchase->update(['status' => 'failed']);
        }
    }
}