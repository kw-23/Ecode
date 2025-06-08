@extends('layouts.client')

@section('title', 'Payment Successful - Cart Purchase')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Modern Success Page Styles */
:root {
    --primary: #6366f1;
    --primary-hover: #4f46e5;
    --secondary: #f43f5e;
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
}

.success-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

.success-container {
    width: 100%;
    max-width: 800px;
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    animation: slideUp 0.6s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.success-header {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
    color: white;
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.success-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.success-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: checkmark 0.8s ease-in-out 0.3s both;
}

@keyframes checkmark {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.success-icon svg {
    width: 40px;
    height: 40px;
}

.success-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.success-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.success-content {
    padding: 2rem;
}

.purchase-summary {
    background: var(--gray-50);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.summary-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.summary-title svg {
    width: 20px;
    height: 20px;
    color: var(--primary);
}

.courses-list {
    display: grid;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.course-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
}

.course-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--gray-200);
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.course-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
}

.course-details {
    flex: 1;
    min-width: 0;
}

.course-title {
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.course-instructor {
    font-size: 0.875rem;
    color: var(--gray-600);
}

.course-price {
    font-weight: 600;
    color: var(--primary);
    font-size: 1rem;
}

.total-summary {
    border-top: 2px solid var(--gray-200);
    padding-top: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--gray-700);
}

.total-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
}

.payment-details {
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.details-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.details-title svg {
    width: 18px;
    height: 18px;
    color: var(--primary);
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--gray-100);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: var(--gray-600);
    font-size: 0.9rem;
}

.detail-value {
    font-weight: 500;
    color: var(--gray-900);
}

.transaction-id {
    font-family: 'Monaco', 'Menlo', monospace;
    font-size: 0.8rem;
    background: var(--gray-100);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.transaction-id:hover {
    background: var(--gray-200);
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--success);
    color: white;
}

.btn-secondary:hover {
    background: #059669;
    transform: translateY(-1px);
}

.btn-outline {
    background: transparent;
    color: var(--gray-700);
    border: 2px solid var(--gray-300);
}

.btn-outline:hover {
    background: var(--gray-50);
    border-color: var(--gray-400);
}

.btn svg {
    width: 18px;
    height: 18px;
}

.email-notice {
    background: #dbeafe;
    border: 1px solid #93c5fd;
    border-radius: 8px;
    padding: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.email-icon {
    width: 20px;
    height: 20px;
    color: #2563eb;
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.email-content h4 {
    font-weight: 600;
    color: #1e40af;
    margin-bottom: 0.25rem;
}

.email-content p {
    color: #1e40af;
    font-size: 0.9rem;
    line-height: 1.4;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 2rem 0;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--gray-50);
    border-radius: 8px;
    border: 1px solid var(--gray-200);
}

.feature-icon {
    width: 24px;
    height: 24px;
    color: var(--success);
    flex-shrink: 0;
}

.feature-text {
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--gray-700);
}

/* Responsive */
@media (max-width: 768px) {
    .success-page {
        padding: 1rem;
    }
    
    .success-header {
        padding: 1.5rem;
    }
    
    .success-title {
        font-size: 1.5rem;
    }
    
    .success-content {
        padding: 1.5rem;
    }
    
    .course-item {
        flex-direction: column;
        text-align: center;
    }
    
    .course-details {
        text-align: center;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
}

.animate {
    animation: fadeInUp 0.6s ease-out forwards;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection

@section('content')
<div class="success-page">
    <div class="success-container">
        <!-- Success Header -->
        <div class="success-header">
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="success-title">Payment Successful!</h1>
            <p class="success-subtitle">Thank you for your purchase. You now have access to all your courses.</p>
        </div>

        <div class="success-content">
            <!-- Purchase Summary -->
            <div class="purchase-summary">
                <h2 class="summary-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Purchase Summary
                </h2>

                <div class="courses-list">
                    @if(isset($purchases) && $purchases->count() > 0)
                        @foreach($purchases as $purchase)
                            <div class="course-item">
                                <div class="course-image">
                                    @if($purchase->course->thumbnail)
                                        <img src="{{ asset('storage/' . $purchase->course->thumbnail) }}" 
                                             alt="{{ $purchase->course->title }}" 
                                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'course-placeholder\'><svg width=\'24\' height=\'24\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\'></path></svg></div>';">
                                    @else
                                        <div class="course-placeholder">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="course-details">
                                    <h3 class="course-title">{{ $purchase->course->title }}</h3>
                                    @if($purchase->course->instructor)
                                        <p class="course-instructor">By {{ $purchase->course->instructor->name }}</p>
                                    @endif
                                </div>
                                <div class="course-price">${{ number_format($purchase->amount, 2) }}</div>
                            </div>
                        @endforeach

                        <div class="total-summary">
                            <span class="total-label">Total Paid:</span>
                            <span class="total-amount">${{ number_format($purchases->sum('amount'), 2) }}</span>
                        </div>
                    @else
                        <div class="course-item">
                            <div class="course-details">
                                <h3 class="course-title">No purchase details available</h3>
                                <p class="course-instructor">Please contact support if you need assistance</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Course Features -->
            <div class="features-grid">
                <div class="feature-item">
                    <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="feature-text">Lifetime Access</span>
                </div>
                
                <div class="feature-item">
                    <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="feature-text">Certificates Included</span>
                </div>
                
                <div class="feature-item">
                    <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span class="feature-text">Downloadable Content</span>
                </div>
                
                <div class="feature-item">
                    <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 109.75 9.75A9.75 9.75 0 0012 2.25z"></path>
                    </svg>
                    <span class="feature-text">24/7 Support</span>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="payment-details">
                <h3 class="details-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Payment Details
                </h3>
                
                <div class="detail-row">
                    <span class="detail-label">Courses Purchased</span>
                    <span class="detail-value">{{ isset($purchases) ? $purchases->count() : 0 }} Course(s)</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Total Amount</span>
                    <span class="detail-value">${{ isset($purchases) ? number_format($purchases->sum('amount'), 2) : '0.00' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Payment Date</span>
                    <span class="detail-value">{{ now()->format('M d, Y \a\t g:i A') }}</span>
                </div>
                
                @if(isset($paymentIntentId) && $paymentIntentId)
                <div class="detail-row">
                    <span class="detail-label">Transaction ID</span>
                    <span class="detail-value">
                        <span class="transaction-id" title="Click to copy">{{ $paymentIntentId }}</span>
                    </span>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('client.dashboard') }}" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    Go to Dashboard
                </a>
                
                <a href="{{ isset($purchases) && $purchases->count() === 1 ? route('client.course-detail', $purchases->first()->course_id) : route('client.courses') }}" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Course Details
                </a>
                
                <a href="{{ route('client.courses') }}" class="btn btn-outline">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Browse More Courses
                </a>
            </div>

            <!-- Email Confirmation Notice -->
            <div class="email-notice">
                <svg class="email-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <div class="email-content">
                    <h4>Confirmation Email Sent</h4>
                    <p>We've sent a confirmation email with your course access details to {{ auth('client')->user()->email ?? 'your email address' }}. Please check your inbox and spam folder.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on load
    setTimeout(() => {
        document.querySelector('.purchase-summary').classList.add('animate');
    }, 300);
    
    setTimeout(() => {
        document.querySelector('.features-grid').classList.add('animate');
    }, 600);
    
    setTimeout(() => {
        document.querySelector('.payment-details').classList.add('animate');
    }, 900);
    
    // Copy transaction ID functionality
    const transactionId = document.querySelector('.transaction-id');
    if (transactionId) {
        transactionId.addEventListener('click', function() {
            navigator.clipboard.writeText(this.textContent).then(() => {
                const originalText = this.textContent;
                this.textContent = 'Copied!';
                this.style.color = '#10b981';
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.style.color = '';
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        });
    }
    
    // Handle image loading errors
    document.querySelectorAll('img').forEach(img => {
        img.onerror = function() {
            this.onerror = null;
            this.parentElement.innerHTML = `
                <div class="course-placeholder">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            `;
        };
    });
});
</script>
@endsection