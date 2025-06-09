@extends('layouts.client')

@section('title', 'Complete Your Purchase' . (isset($course) ? ' - ' . $course->title : ''))

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://js.stripe.com/v3/"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
:root {
    --primary: #4F46E5;
    --primary-light: #6366F1;
    --primary-dark: #4338CA;
    --secondary: #10B981;
    --danger: #EF4444;
    --warning: #F59E0B;
    --dark: #111827;
    --dark-gray: #1F2937;
    --medium-gray: #374151;
    --light-gray: #6B7280;
    --lighter-gray: #9CA3AF;
    --lightest-gray: #E5E7EB;
    --white: #FFFFFF;
    --background: #F9FAFB;
    --success: #10B981;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: var(--background);
    color: var(--dark-gray);
    line-height: 1.5;
    -webkit-font-smoothing: antialiased;
}

.checkout-container {
    max-width: 1200px;
    margin: 2rem auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    background: var(--white);
    border-radius: 12px;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
}

/* Left Side - Order Summary */
.order-summary {
    padding: 2.5rem;
    background: var(--white);
    border-right: 1px solid var(--lightest-gray);
}

.summary-header {
    margin-bottom: 2rem;
}

.summary-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.summary-subtitle {
    font-size: 0.875rem;
    color: var(--light-gray);
}

.course-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    margin-bottom: 1rem;
    background: var(--white);
    border-radius: 8px;
    border: 1px solid var(--lightest-gray);
    transition: all 0.2s ease;
}

.course-item:hover {
    border-color: var(--primary-light);
    box-shadow: var(--shadow-sm);
}

.course-image {
    width: 80px;
    height: 80px;
    border-radius: 6px;
    overflow: hidden;
    flex-shrink: 0;
    background-color: var(--lightest-gray);
    position: relative;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.course-item:hover .course-image img {
    transform: scale(1.05);
}

.course-image-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--lightest-gray), var(--white));
    color: var(--light-gray);
}

.course-details {
    flex: 1;
    min-width: 0;
}

.course-title {
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
    color: var(--dark);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.course-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.8rem;
    color: var(--light-gray);
}

.course-price {
    font-weight: 700;
    color: var(--primary);
    font-size: 1rem;
}

.price-summary {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--lightest-gray);
}

.price-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.9rem;
}

.price-row:not(:last-child) {
    border-bottom: 1px solid var(--lightest-gray);
}

.price-label {
    color: var(--light-gray);
}

.price-value {
    font-weight: 500;
    color: var(--dark-gray);
}

.price-total {
    font-weight: 700;
    color: var(--primary);
    font-size: 1.1rem;
    margin-top: 0.5rem;
    padding-top: 0.5rem;
    border-top: 1px solid var(--lightest-gray);
}

/* Right Side - Payment Form */
.payment-form {
    padding: 2.5rem;
    background: var(--white);
}

.payment-header {
    margin-bottom: 2rem;
}

.payment-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.payment-title svg {
    width: 24px;
    height: 24px;
    color: var(--primary);
}

.payment-subtitle {
    font-size: 0.875rem;
    color: var(--light-gray);
}

.form-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark-gray);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title svg {
    width: 18px;
    height: 18px;
    color: var(--primary);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    margin-bottom: 1.25rem;
}

.form-group {
    margin-bottom: 1.25rem;
    position: relative;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--medium-gray);
    margin-bottom: 0.5rem;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: 16px;
    color: var(--lighter-gray);
    pointer-events: none;
    transition: color 0.2s ease;
}

.form-input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 2.5rem;
    border: 1px solid var(--lightest-gray);
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    background: var(--white);
    color: var(--dark-gray);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-light);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-input:focus + .input-icon {
    color: var(--primary);
}

/* Card Element Styling */
.card-container {
    border: 1px solid var(--lightest-gray);
    border-radius: 8px;
    padding: 1rem;
    background: var(--white);
    transition: all 0.2s ease;
}

.card-container:focus-within {
    border-color: var(--primary-light);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.card-brands {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    margin-top: 0.75rem;
}

.card-brand {
    width: 36px;
    height: 24px;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.card-brand:hover {
    opacity: 1;
}

#card-errors {
    color: var(--danger);
    font-size: 0.8rem;
    margin-top: 0.5rem;
    min-height: 1rem;
}

/* Payment Button */
.payment-button {
    width: 100%;
    background: var(--primary);
    color: var(--white);
    border: none;
    padding: 1rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

.payment-button:hover {
    background: var(--primary-dark);
    box-shadow: var(--shadow-md);
}

.payment-button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.payment-button svg {
    width: 18px;
    height: 18px;
}

/* Security Badges */
.security-badges {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1.5rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--lightest-gray);
}

.security-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.security-badge svg {
    width: 16px;
    height: 16px;
    color: var(--success);
}

.security-badge span {
    font-size: 0.75rem;
    color: var(--light-gray);
    white-space: nowrap;
}

/* Messages */
.payment-messages {
    margin-bottom: 1.5rem;
}

.message {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.message svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
}

.error-message {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.success-message {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

/* Loading State */
.loading-spinner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.spinner {
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid var(--white);
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
@media (max-width: 1024px) {
    .checkout-container {
        grid-template-columns: 1fr;
        max-width: 600px;
    }
    
    .order-summary {
        border-right: none;
        border-bottom: 1px solid var(--lightest-gray);
    }
}

@media (max-width: 640px) {
    .checkout-container {
        margin: 0;
        border-radius: 0;
    }
    
    .order-summary, 
    .payment-form {
        padding: 1.5rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .security-badges {
        flex-wrap: wrap;
        gap: 1rem;
    }
}
</style>
@endsection

@section('content')
<div class="checkout-container">
    <!-- Left Side - Order Summary -->
    <div class="order-summary">
        <div class="summary-header">
            <h1 class="summary-title">Order Summary</h1>
            <p class="summary-subtitle">Review your items before payment</p>
        </div>
        
        @if(isset($course))
            <!-- Single Course -->
            <div class="course-item">
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
                            <span>By {{ $course->instructor->name }}</span>
                        @endif
                    </div>
                    <div class="course-price">${{ number_format($course->price ?? 99, 2) }}</div>
                </div>
            </div>
        @else
            <!-- Cart Items -->
            @if(isset($cartItems) && $cartItems->count() > 0)
                @foreach($cartItems as $item)
                    <div class="course-item">
                        <div class="course-image">
                            @if($item->course->cover_image && file_exists(public_path($item->course->cover_image)))
                                <img src="{{ asset($item->course->cover_image) }}" alt="{{ $item->course->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                            @else
                                <div class="course-image-placeholder">
                                    <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                    <span style="font-weight: bold; color: #6B7280; margin-left: 0.5rem;">{{ strtoupper(substr($item->course->title, 0, 3)) }}</span>
                                </div>
                            @endif
                            @if(isset($purchasedCourseIds) && in_array($item->course->id, $purchasedCourseIds))
                                <div class="ownership-badge" style="position: absolute; bottom: 8px; right: 8px; background: #10B981; color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; display: flex; align-items: center; gap: 0.25rem;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Owned
                                </div>
                            @endif
                        </div>
                        <div class="course-details">
                            <h3 class="course-title">{{ $item->course->title }}</h3>
                            <div class="course-meta">
                                <span>By {{ $item->course->instructor->name ?? 'Unknown' }}</span>
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
                <span class="price-label">Total</span>
                <span class="price-total">${{ number_format($finalTotal ?? (($course->price ?? 99) - ($discount ?? 0)), 2) }}</span>
            </div>
        </div>
    </div>
    
    <!-- Right Side - Payment Form -->
    <div class="payment-form">
        <div class="payment-header">
            <h2 class="payment-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Payment Details
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
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
                    Payment Method
                </h3>
                
                <div class="form-group">
                    <label class="form-label" for="card-element">Credit or Debit Card</label>
                    <div class="card-container">
                        <div id="card-element"></div>
                    </div>
                    <div id="card-errors" role="alert"></div>
                </div>
                
            </div>
            
            <button type="submit" id="submit-payment" class="payment-button">
                <span id="button-content">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
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
                    <span>Secure Payment</span>
                </div>
                
                <div class="security-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span>Encrypted</span>
                </div>
                
                <div class="security-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>SSL Certified</span>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe with modern appearance
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements({
        fonts: [
            {
                cssSrc: 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap'
            }
        ],
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#4F46E5',
                colorBackground: '#FFFFFF',
                colorText: '#1F2937',
                colorDanger: '#EF4444',
                fontFamily: 'Inter, system-ui, sans-serif',
                borderRadius: '8px',
                spacingUnit: '4px',
            },
            rules: {
                '.Input': {
                    padding: '12px',
                    backgroundColor: 'transparent',
                    border: '1px solid #E5E7EB',
                    boxShadow: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                },
                '.Input:focus': {
                    boxShadow: '0 0 0 3px rgba(79, 70, 229, 0.1)',
                },
                '.Input--invalid': {
                    color: '#EF4444',
                },
                '.Tab': {
                    border: '1px solid #E5E7EB',
                },
                '.Tab:hover': {
                    color: '#4F46E5',
                },
                '.Tab--selected': {
                    borderColor: '#4F46E5',
                }
            }
        }
    });
    
    // Create and mount card element
    const cardElement = elements.create('card', {
        hidePostalCode: true,
        style: {
            base: {
                iconColor: '#4F46E5',
                color: '#1F2937',
                fontWeight: '500',
                fontFamily: 'Inter, system-ui, sans-serif',
                fontSize: '16px',
                fontSmoothing: 'antialiased',
                '::placeholder': {
                    color: '#9CA3AF',
                },
                ':-webkit-autofill': {
                    color: '#1F2937',
                },
            },
            invalid: {
                iconColor: '#EF4444',
                color: '#EF4444',
            }
        }
    });
    
    cardElement.mount('#card-element');
    
    // Handle real-time validation errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
            displayError.style.display = 'block';
        } else {
            displayError.textContent = '';
            displayError.style.display = 'none';
        }
    });
    
    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        const submitButton = document.getElementById('submit-payment');
        const buttonContent = document.getElementById('button-content');
        const loadingSpinner = document.getElementById('loading-spinner');
        const messagesDiv = document.getElementById('payment-messages');
        
        // Show loading state
        submitButton.disabled = true;
        buttonContent.classList.add('hidden');
        loadingSpinner.classList.remove('hidden');
        messagesDiv.innerHTML = '';
        
        try {
            const amount = document.getElementById('amount').value;
            const email = document.getElementById('email').value;
            const name = document.getElementById('name').value;
            const checkoutType = document.getElementById('checkout-type').value;
            
            // Validate form fields
            if (!email || !name) {
                throw new Error('Please fill in all required fields');
            }
            
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
                throw methodError;
            }
            
            // Determine endpoint and request data
            let endpoint, requestData;
            
            if (checkoutType === 'single') {
                endpoint = '{{ route("payment.process") }}';
                requestData = {
                    course_id: document.getElementById('course-id').value,
                    amount: parseFloat(amount) * 100, // Convert to cents
                    payment_method: paymentMethod.id,
                    email: email,
                    name: name
                };
            } else {
                endpoint = '{{ route("cart.process-payment") }}';
                requestData = {
                    amount: parseFloat(amount) * 100, // Convert to cents
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
                throw new Error(paymentData.error.message || 'Payment failed. Please try again.');
            }
            
            // Confirm payment
            const {error: confirmError, paymentIntent} = await stripe.confirmCardPayment(
                paymentData.client_secret,
                {
                    payment_method: paymentMethod.id
                }
            );
            
            if (confirmError) {
                throw confirmError;
            }
            
            // Handle successful payment
            if (paymentIntent.status === 'succeeded') {
                showSuccess('Payment successful! Redirecting to your course...');
                
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
            showError(error.message || 'An unexpected error occurred. Please try again.');
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
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
    
    // Fix image loading errors with fallback
    document.querySelectorAll('img').forEach(img => {
        img.onerror = function() {
            this.onerror = null;
            this.src = '{{ asset("images/course-placeholder.jpg") }}';
        };
    });
    
    // Add smooth scrolling for better UX
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Auto-focus on first input for better accessibility
    const firstInput = document.querySelector('.form-input');
    if (firstInput && !firstInput.value) {
        firstInput.focus();
    }
    
    // Add keyboard navigation support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.classList.contains('form-input')) {
            const inputs = Array.from(document.querySelectorAll('.form-input'));
            const currentIndex = inputs.indexOf(e.target);
            const nextInput = inputs[currentIndex + 1];
            
            if (nextInput) {
                e.preventDefault();
                nextInput.focus();
            }
        }
    });
});
</script>
@endsection