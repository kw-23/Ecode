<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Client;

class PaymentController extends Controller
{
    /**
     * Show the checkout page for a specific course
     */
    public function checkout(Course $course)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login')->with('error', 'Vous devez être connecté pour effectuer un achat.');
        }

        // Vérifier si l'utilisateur a déjà acheté ce cours
        $client = Auth::guard('client')->user();
        $existingPurchase = Purchase::where('client_id', $client->id)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->first();

        if ($existingPurchase) {
            return redirect()->route('client.course.show', $course)
                ->with('info', 'Vous avez déjà acheté ce cours.');
        }

        // Passer le cours à la vue
        return view('payment.checkout', compact('course'));
    }

    /**
     * Process the payment
     */
    public function process(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
                'amount' => 'required|numeric|min:0',
                'email' => 'required|email',
                'name' => 'required|string|max:255',
                'payment_method' => 'required|string',
            ]);

            $course = Course::findOrFail($request->course_id);
            $client = Auth::guard('client')->user();

            // Vérifier que le montant correspond au prix du cours
            if ($request->amount != $course->price) {
                return response()->json([
                    'error' => ['message' => 'Le montant ne correspond pas au prix du cours.']
                ], 400);
            }

            // Create Stripe PaymentIntent
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
            
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $course->price * 100, // Stripe uses cents
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('payment.success', $course),
                'metadata' => [
                    'course_id' => $course->id,
                    'client_id' => $client->id,
                    'course_title' => $course->title,
                    'client_email' => $client->email,
                ]
            ]);

            if ($paymentIntent->status === 'requires_action') {
                return response()->json([
                    'requires_action' => true,
                    'payment_intent' => [
                        'id' => $paymentIntent->id,
                        'client_secret' => $paymentIntent->client_secret
                    ]
                ]);
            } else if ($paymentIntent->status === 'succeeded') {
                // Create purchase record
                $purchase = Purchase::create([
                    'client_id' => $client->id,
                    'course_id' => $course->id,
                    'amount' => $course->price,
                    'currency' => 'usd',
                    'payment_intent_id' => $paymentIntent->id,
                    'status' => 'completed',
                    'payment_method' => 'stripe',
                    'completed_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'client_secret' => $paymentIntent->client_secret,
                    'purchase_id' => $purchase->id
                ]);
            } else {
                return response()->json([
                    'error' => ['message' => 'Payment failed']
                ], 400);
            }

        } catch (\Stripe\Exception\CardException $e) {
            return response()->json([
                'error' => ['message' => $e->getError()->message]
            ], 400);
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => ['message' => 'Une erreur est survenue lors du traitement du paiement.']
            ], 500);
        }
    }

    /**
     * Confirm payment after successful Stripe payment
     */
    public function confirmPayment(Request $request)
    {
        try {
            $request->validate([
                'payment_intent_id' => 'required|string',
                'purchase_id' => 'required|exists:purchases,id',
            ]);

            $purchase = Purchase::findOrFail($request->purchase_id);
            
            // Mettre à jour le statut de l'achat
            $purchase->update([
                'status' => 'completed',
                'payment_intent_id' => $request->payment_intent_id,
                'completed_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'redirect_url' => route('payment.success', $purchase->course)
            ]);

        } catch (\Exception $e) {
            Log::error('Payment confirmation error: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la confirmation du paiement.'
            ], 500);
        }
    }

    /**
     * Show payment success page
     */
    public function success(Course $course)
    {
        $client = Auth::guard('client')->user();
        
        // Vérifier que l'utilisateur a bien acheté ce cours
        $purchase = Purchase::where('client_id', $client->id)
            ->where('course_id', $course->id)
            ->where('status', 'completed')
            ->latest()
            ->first();

        if (!$purchase) {
            return redirect()->route('client.courses')
                ->with('error', 'Aucun achat trouvé pour ce cours.');
        }

        return view('payment.success', [
            'course' => $course,
            'purchase' => $purchase,
            'paymentIntentId' => $purchase->payment_intent_id
        ]);
    }

    /**
     * Show payment cancel page
     */
    public function cancel(Course $course)
    {
        return view('payment.cancel', compact('course'));
    }

    /**
     * Handle Stripe webhooks
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            if ($endpoint_secret) {
                $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
            } else {
                $event = json_decode($payload, true);
            }
            
            Log::info('Webhook received', ['event_type' => $event['type']]);

            // Handle different event types
            switch ($event['type']) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event['data']['object'];
                    $this->handlePaymentSuccess($paymentIntent);
                    break;
                    
                case 'payment_intent.payment_failed':
                    $paymentIntent = $event['data']['object'];
                    $this->handlePaymentFailure($paymentIntent);
                    break;
                    
                default:
                    Log::info('Unhandled event type: ' . $event['type']);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook error'], 400);
        }
    }

    /**
     * Handle successful payment
     */
    private function handlePaymentSuccess($paymentIntent)
    {
        $purchase = Purchase::where('payment_intent_id', $paymentIntent['id'])
            ->first();

        if ($purchase && $purchase->status !== 'completed') {
            $purchase->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            Log::info('Payment confirmed via webhook', ['purchase_id' => $purchase->id]);
        }
    }

    /**
     * Handle failed payment
     */
    private function handlePaymentFailure($paymentIntent)
    {
        $purchase = Purchase::where('payment_intent_id', $paymentIntent['id'])
            ->first();

        if ($purchase) {
            $purchase->update([
                'status' => 'failed',
            ]);

            Log::info('Payment failed via webhook', ['purchase_id' => $purchase->id]);
        }
    }

    /**
     * Show payment history
     */
    public function history()
    {
        $client = Auth::guard('client')->user();
        $purchases = Purchase::where('client_id', $client->id)
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payment.history', compact('purchases'));
    }

    /**
     * Generate invoice
     */
    public function invoice(Purchase $purchase)
    {
        $client = Auth::guard('client')->user();
        
        if ($purchase->client_id !== $client->id) {
            abort(403, 'Accès non autorisé');
        }

        return view('payment.invoice', compact('purchase'));
    }

    /**
     * Sales report (admin)
     */
    public function salesReport()
    {
        $sales = Purchase::where('status', 'completed')
            ->with(['course', 'client'])
            ->orderBy('completed_at', 'desc')
            ->paginate(20);

        return view('admin.reports.sales', compact('sales'));
    }

    /**
     * Revenue report (admin)
     */
    public function revenueReport()
    {
        $totalRevenue = Purchase::where('status', 'completed')->sum('amount');
        $monthlyRevenue = Purchase::where('status', 'completed')
            ->whereMonth('completed_at', now()->month)
            ->sum('amount');

        return view('admin.reports.revenue', compact('totalRevenue', 'monthlyRevenue'));
    }

    /**
     * Show cart payment success page - FIXED METHOD
     */
    public function cartPaymentSuccess(Request $request)
    {
        try {
            $client = Auth::guard('client')->user();

            if (!$client) {
                return redirect()->route('client.login')
                    ->with('error', 'Please log in to view your purchases.');
            }

            // Get recent completed purchases for this client
            $purchases = Purchase::where('client_id', $client->id)
                ->where('status', 'completed')
                ->whereNotNull('course_id')
                ->with(['course', 'course.instructor'])
                ->orderBy('completed_at', 'desc')
                ->limit(10) // Get last 10 purchases
                ->get();

            if ($purchases->isEmpty()) {
                return redirect()->route('client.courses')
                    ->with('error', 'No recent purchases found.');
            }

            $paymentIntentId = $request->query('payment_intent', null);
            return view('cart.payment-success', [
                'purchases' => $purchases,
                'paymentIntentId' => $paymentIntentId
            ]);

        } catch (\Exception $e) {
            Log::error('Cart payment success processing error: ' . $e->getMessage(), [
                'user_id' => Auth::guard('client')->id(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('client.dashboard')
                ->with('error', 'There was an error processing your request. Please contact support.');
        }
    }
}