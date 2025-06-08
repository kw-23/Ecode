@extends('layouts.client')

@section('title', 'Complete Your Purchase' . (isset($course) ? ' - ' . $course->title : ''))

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://js.stripe.com/v3/"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
/* Compact Modern Checkout Design */
:root {
    --primary: #6366f1;
    --primary-hover: #4f46e5;
    --secondary: #f43f5e;
    --accent: #06b6d4;
    --success: #10b981;
    --warning: #f59e0b;
    --dark: #0f172a;
    --light: #ffffff;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: var(--gray-100);
    color: var(--gray-800);
    min-height: 100vh;
    overflow-x: hidden;
}

/* Modern Background Pattern */
.checkout-page {
    min-height: 100vh;
    background-color: #f8f9fa;
    background-image: 
        radial-gradient(#6366f1 0.5px, transparent 0.5px),
        radial-gradient(#6366f1 0.5px, #f8f9fa 0.5px);
    background-size: 20px 20px;
    background-position: 0 0, 10px 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

/* Compact Layout */
.checkout-container {
    width: 100%;
    max-width: 1200px;
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    display: grid;
    grid-template-columns: 1fr 1fr;
    overflow: hidden;
    max-height: 90vh;
}

/* Left Side - Course Preview */
.checkout-preview {
    background: var(--gray-50);
    padding: 1.5rem;
    position: relative;
    overflow-y: auto;
    max-height: 90vh;
}

.preview-header {
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--gray-200);
}

.preview-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.25rem;
}

.preview-subtitle {
    font-size: 0.875rem;
    color: var(--gray-600);
}

/* Course Card Compact */
.course-compact {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
}

.course-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
    background-color: var(--gray-200);
    position: relative;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.course-image-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background: var(--gray-200);
    color: var(--gray-500);
}

.course-details {
    flex: 1;
    min-width: 0;
}

.course-title {
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
    color: var(--gray-900);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.course-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.instructor-name {
    font-size: 0.8rem;
    color: var(--gray-600);
}

.course-price {
    font-weight: 700;
    color: var(--primary);
    font-size: 1rem;
}

/* Price Summary */
.price-summary {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
}

.price-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.9rem;
}

.price-row:not(:last-child) {
    border-bottom: 1px solid var(--gray-100);
}

.price-label {
    color: var(--gray-600);
}

.price-value {
    font-weight: 600;
    color: var(--gray-900);
}

.price-total {
    font-weight: 700;
    color: var(--primary);
    font-size: 1.1rem;
}

/* Right Side - Payment Form */
.checkout-payment {
    padding: 1.5rem;
    overflow-y: auto;
    max-height: 90vh;
}

.payment-header {
    margin-bottom: 1.5rem;
}

.payment-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.payment-title svg {
    width: 20px;
    height: 20px;
    color: var(--primary);
}

.payment-subtitle {
    font-size: 0.875rem;
    color: var(--gray-600);
}

/* Form Styling */
.form-section {
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-800);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-title svg {
    width: 18px;
    height: 18px;
    color: var(--primary);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    color: var(--gray-400);
    pointer-events: none;
}

.form-input {
    width: 100%;
    padding: 0.75rem 0.75rem 0.75rem 2.5rem;
    border: 1px solid var(--gray-300);
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Card Element */
.card-container {
    border: 1px solid var(--gray-300);
    border-radius: 8px;
    padding: 0.75rem;
    background: white;
    transition: all 0.2s ease;
}

.card-container:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.card-brands {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.card-brand {
    width: 32px;
    height: 20px;
    opacity: 0.7;
}

/* Payment Button */
.payment-button {
    width: 100%;
    background: var(--primary);
    color: white;
    border: none;
    padding: 0.875rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.payment-button:hover {
    background: var(--primary-hover);
}

.payment-button svg {
    width: 18px;
    height: 18px;
}

/* Security Badges */
.security-badges {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.security-badge {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.security-badge svg {
    width: 16px;
    height: 16px;
    color: var(--success);
}

.security-badge span {
    font-size: 0.75rem;
    color: var(--gray-600);
}

/* Messages */
.payment-messages {
    margin-bottom: 1rem;
}

.message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border-radius: 8px;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.message svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

.error-message {
    background: #fee2e2;
    color: #dc2626;
}

.success-message {
    background: #dcfce7;
    color: #16a34a;
}

/* Loading State */
.loading-spinner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.spinner {
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.hidden {
    display: none;
}

/* Responsive */
@media (max-width: 768px) {
    .checkout-container {
        grid-template-columns: 1fr;
        max-height: none;
    }
    
    .checkout-preview, 
    .checkout-payment {
        max-height: none;
        overflow-y: visible;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="checkout-page">
    <div class="checkout-container">
        <!-- Left Side - Course Preview -->
        <div class="checkout-preview">
            <div class="preview-header">
                <h1 class="preview-title">Order Summary</h1>
                <p class="preview-subtitle">Review your selection</p>
            </div>
            
            @if(isset($course))
                <!-- Single Course -->
                <div class="course-compact">
                    <div class="course-image">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" onerror="this.onerror=null; this.src='{{ asset('images/course-placeholder.jpg') }}';">
                        @else
                            <div class="course-image-placeholder">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="course-details">
                        <h3 class="course-title">{{ $course->title }}</h3>
                        <div class="course-meta">
                            @if($course->instructor)
                                <span class="instructor-name">By {{ $course->instructor->name }}</span>
                            @endif
                        </div>
                        <div class="course-price">${{ number_format($course->price ?? 99, 2) }}</div>
                    </div>
                </div>
            @else
                <!-- Cart Items -->
                @if(isset($cartItems) && $cartItems->count() > 0)
                    @foreach($cartItems as $item)
                        <div class="course-compact">
                            <div class="course-image">
                                @if($item->course->thumbnail)
                                    <img src="{{ asset('storage/' . $item->course->thumbnail) }}" alt="{{ $item->course->title }}" onerror="this.onerror=null; this.src='{{ asset('images/course-placeholder.jpg') }}';">
                                @else
                                    <div class="course-image-placeholder">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="course-details">
                                <h3 class="course-title">{{ $item->course->title }}</h3>
                                <div class="course-meta">
                                    <span class="instructor-name">By {{ $item->course->instructor->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="course-price">${{ number_format($item->price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
            
            <!-- Price Summary -->
            <div class="price-summary">
                @if(isset($course))
                    <div class="price-row">
                        <span class="price-label">Course Price</span>
                        <span class="price-value">${{ number_format($course->price ?? 99, 2) }}</span>
                    </div>
                @else
                    <div class="price-row">
                        <span class="price-label">Subtotal</span>
                        <span class="price-value">${{ number_format($subtotal ?? 0, 2) }}</span>
                    </div>
                @endif
                
                @if(isset($discount) && $discount > 0)
                    <div class="price-row">
                        <span class="price-label">Discount</span>
                        <span class="price-value" style="color: var(--success);">-${{ number_format($discount, 2) }}</span>
                    </div>
                @endif
                
                @if(isset($tax) && $tax > 0)
                    <div class="price-row">
                        <span class="price-label">Tax</span>
                        <span class="price-value">${{ number_format($tax, 2) }}</span>
                    </div>
                @endif
                
                <div class="price-row">
                    <span class="price-label" style="font-weight: 600;">Total</span>
                    <span class="price-total">${{ number_format($finalTotal ?? (($course->price ?? 99) - ($discount ?? 0)), 2) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Payment Form -->
        <div class="checkout-payment">
            <div class="payment-header">
                <h2 class="payment-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Secure Checkout
                </h2>
                <p class="payment-subtitle">Complete your purchase securely</p>
            </div>
            
            <div id="payment-messages" class="payment-messages"></div>
            
            <form id="payment-form">
                @csrf
                @if(isset($course))
                    <input type="hidden" id="course-id" value="{{ $course->id }}">
                    <input type="hidden" id="amount" value="{{ ($course->price ?? 99) - ($discount ?? 0) }}">
                    <input type="hidden" id="checkout-type" value="single">
                @else
                    <input type="hidden" id="amount" value="{{ $finalTotal ?? 0 }}">
                    <input type="hidden" id="checkout-type" value="cart">
                @endif
                
                <div class="form-section">
                    <h3 class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Contact Information
                    </h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                                <input type="email" id="email" name="email" class="form-input"
                                       value="{{ auth('client')->user()->email ?? '' }}" 
                                       placeholder="your@email.com" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="name">Full Name</label>
                            <div class="input-wrapper">
                                <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <input type="text" id="name" name="name" class="form-input"
                                       value="{{ auth('client')->user()->name ?? '' }}" 
                                       placeholder="John Doe" required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3 class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Payment Details
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label" for="card-element">Card Information</label>
                        <div class="card-container">
                            <div id="card-element"></div>
                            
                        </div>
                        <div id="card-errors" style="color: #dc2626; font-size: 0.8rem; margin-top: 0.5rem;"></div>
                    </div>
                </div>
                
                <button type="submit" id="submit-payment" class="payment-button">
                    <span id="button-content">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Pay ${{ number_format($finalTotal ?? (($course->price ?? 99) - ($discount ?? 0)), 2) }}
                    </span>
                    <span id="loading-spinner" class="loading-spinner hidden">
                        <div class="spinner"></div>
                        <span>Processing...</span>
                    </span>
                </button>
                
                <div class="security-badges">
                    <div class="security-badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Secure</span>
                    </div>
                    
                    <div class="security-badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span>Encrypted</span>
                    </div>
                    
                    <div class="security-badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Guaranteed</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements({
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#6366f1',
                colorBackground: '#ffffff',
                colorText: '#1e293b',
                colorDanger: '#dc2626',
                fontFamily: 'Inter, system-ui, sans-serif',
                borderRadius: '8px',
            }
        }
    });
    
    // Create card element
    const cardElement = elements.create('card', {
        hidePostalCode: true,
        style: {
            base: {
                fontSize: '16px',
                color: '#1e293b',
                '::placeholder': {
                    color: '#94a3b8',
                },
            },
        },
    });
    
    cardElement.mount('#card-element');
    
    // Handle validation errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        const submitButton = document.getElementById('submit-payment');
        const buttonContent = document.getElementById('button-content');
        const loadingSpinner = document.getElementById('loading-spinner');
        
        // Show loading state
        submitButton.disabled = true;
        buttonContent.classList.add('hidden');
        loadingSpinner.classList.remove('hidden');
        
        try {
            const amount = document.getElementById('amount').value;
            const email = document.getElementById('email').value;
            const name = document.getElementById('name').value;
            const checkoutType = document.getElementById('checkout-type').value;
            
            // Create payment method
            const {error: methodError, paymentMethod} = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
                billing_details: {
                    name: name,
                    email: email,
                },
            });
            
            if (methodError) {
                showError(methodError.message);
                resetButton();
                return;
            }
            
            // Determine endpoint
            let endpoint, requestData;
            
            if (checkoutType === 'single') {
                endpoint = '{{ route("payment.process") }}';
                requestData = {
                    course_id: document.getElementById('course-id').value,
                    amount: parseFloat(amount),
                    payment_method: paymentMethod.id,
                    email: email,
                    name: name
                };
            } else {
                endpoint = '{{ route("cart.process-payment") }}';
                requestData = {
                    amount: parseFloat(amount),
                    payment_method: paymentMethod.id,
                    email: email,
                    name: name
                };
            }
            
            // Create payment intent
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestData),
            });
            
            const paymentData = await response.json();
            
            if (paymentData.error) {
                showError(paymentData.error.message || 'Payment failed. Please try again.');
                resetButton();
                return;
            }
            
            // Confirm payment
            const {error: confirmError, paymentIntent} = await stripe.confirmCardPayment(
                paymentData.client_secret,
                {
                    payment_method: paymentMethod.id
                }
            );
            
            if (confirmError) {
                showError(confirmError.message);
                resetButton();
                return;
            }
            
            if (paymentIntent.status === 'succeeded') {
                showSuccess('Payment successful! Redirecting...');
                
                setTimeout(() => {
                    if (checkoutType === 'single') {
                        window.location.href = `{{ route('payment.success', ['course' => $course->id ?? 0]) }}?payment_intent=${paymentIntent.id}`;
                    } else {
                        window.location.href = `{{ route('cart.payment-success') }}?payment_intent=${paymentIntent.id}`;
                    }
                }, 1500);
            }
            
        } catch (error) {
            console.error('Payment error:', error);
            showError('An unexpected error occurred. Please try again.');
            resetButton();
        }
    });
    
    function showError(message) {
        const messagesDiv = document.getElementById('payment-messages');
        messagesDiv.innerHTML = `
            <div class="message error-message">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
    }
    
    function showSuccess(message) {
        const messagesDiv = document.getElementById('payment-messages');
        messagesDiv.innerHTML = `
            <div class="message success-message">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
    }
    
    function resetButton() {
        const submitButton = document.getElementById('submit-payment');
        const buttonContent = document.getElementById('button-content');
        const loadingSpinner = document.getElementById('loading-spinner');
        
        submitButton.disabled = false;
        buttonContent.classList.remove('hidden');
        loadingSpinner.classList.add('hidden');
    }
    
    // Fix image loading errors
    document.querySelectorAll('img').forEach(img => {
        img.onerror = function() {
            this.onerror = null;
            this.src = '{{ asset("images/course-placeholder.jpg") }}';
            if (this.parentElement.classList.contains('course-image')) {
                this.style.opacity = '0.7';
            }
        };
    });
});
</script>
@endsection