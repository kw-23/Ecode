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
            ]);

            $course = Course::findOrFail($request->course_id);
            $client = Auth::guard('client')->user();

            // Vérifier que le montant correspond au prix du cours
            if ($request->amount != $course->price) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le montant ne correspond pas au prix du cours.'
                ], 400);
            }

            // Appeler l'API Express.js pour créer le PaymentIntent
            $response = Http::post('http://localhost:3000/create-payment-intent', [
                'amount' => $course->price * 100, // Stripe utilise les centimes
                'currency' => 'usd',
                'metadata' => [
                    'course_id' => $course->id,
                    'client_id' => $client->id,
                    'course_title' => $course->title,
                    'client_email' => $client->email,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Créer un enregistrement de purchase en attente
                $purchase = Purchase::create([
                    'client_id' => $client->id,
                    'course_id' => $course->id,
                    'amount' => $course->price,
                    'currency' => 'usd',
                    'payment_intent_id' => $data['client_secret'],
                    'status' => 'pending',
                    'payment_method' => 'stripe',
                ]);

                return response()->json([
                    'success' => true,
                    'client_secret' => $data['client_secret'],
                    'purchase_id' => $purchase->id
                ]);
            } else {
                Log::error('Erreur lors de la création du PaymentIntent', [
                    'response' => $response->body(),
                    'status' => $response->status()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création du paiement.'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Erreur dans process payment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors du traitement du paiement.'
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

            // Enregistrer l'inscription du client au cours
            $client = Auth::guard('client')->user();
            $course = $purchase->course;

            // Ajouter le cours aux cours inscrits du client (si vous avez une table pivot)
            // $client->enrolledCourses()->attach($course->id);

            return response()->json([
                'success' => true,
                'redirect_url' => route('payment.success', $course)
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la confirmation du paiement', [
                'error' => $e->getMessage(),
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
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            // Vérifier la signature du webhook (optionnel mais recommandé)
            // $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
            
            $event = json_decode($payload, true);
            
            Log::info('Webhook reçu', ['event' => $event]);

            // Traiter les différents types d'événements
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
                    Log::info('Type d\'événement non géré: ' . $event['type']);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Erreur webhook', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Webhook error'], 400);
        }
    }

    /**
     * Handle successful payment
     */
    private function handlePaymentSuccess($paymentIntent)
    {
        $purchase = Purchase::where('payment_intent_id', 'like', '%' . $paymentIntent['id'] . '%')
            ->first();

        if ($purchase && $purchase->status !== 'completed') {
            $purchase->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            Log::info('Paiement confirmé via webhook', ['purchase_id' => $purchase->id]);
        }
    }

    /**
     * Handle failed payment
     */
    private function handlePaymentFailure($paymentIntent)
    {
        $purchase = Purchase::where('payment_intent_id', 'like', '%' . $paymentIntent['id'] . '%')
            ->first();

        if ($purchase) {
            $purchase->update([
                'status' => 'failed',
            ]);

            Log::info('Paiement échoué via webhook', ['purchase_id' => $purchase->id]);
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
}
