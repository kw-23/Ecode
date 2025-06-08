@extends('layouts.client')

@section('title', 'Payment Successful')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/payment-success.css') }}">
@endsection

@section('content')
<div class="success-container">
    <div class="success-content">
        <!-- Success Animation -->
        <div class="success-animation">
            <div class="checkmark-circle">
                <svg class="checkmark" viewBox="0 0 52 52">
                    <circle class="checkmark-circle-bg" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="m14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>
        </div>
        
        <!-- Success Message -->
        <div class="success-message">
            <h1>Payment Successful!</h1>
            <p class="success-subtitle">Thank you for your purchase. You now have access to the course.</p>
        </div>
        
        <!-- Course Information -->
        <div class="course-card">
            <div class="course-header">
                <h2>{{ $course->title }}</h2>
                @if($course->category)
                    <span class="course-category">{{ $course->category->name }}</span>
                @endif
            </div>
            
            <div class="course-details">
                <div class="detail-item">
                    <svg class="detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Lifetime Access</span>
                </div>
                
                <div class="detail-item">
                    <svg class="detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Certificate Included</span>
                </div>
                
                <div class="detail-item">
                    <svg class="detail-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span>Downloadable Content</span>
                </div>
            </div>
        </div>
        
        <!-- Payment Details -->
        <div class="payment-details">
            <h3>Payment Details</h3>
            <div class="payment-info">
                <div class="payment-row">
                    <span>Course</span>
                    <span>{{ $course->title }}</span>
                </div>
                <div class="payment-row">
                    <span>Amount Paid</span>
                    <span class="amount">${{ number_format($course->price ?? 99, 2) }}</span>
                </div>
                <div class="payment-row">
                    <span>Payment Date</span>
                    <span>{{ now()->format('M d, Y \a\t g:i A') }}</span>
                </div>
                @if(request('payment_intent'))
                <div class="payment-row">
                    <span>Transaction ID</span>
                    <span class="transaction-id">{{ request('payment_intent') }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('client.course.show', $course->slug) }}" class="btn btn-primary">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View Course
            </a>
            
            @if($course->pdf_file_path)
            <a href="{{ route('client.download-course', $course->id) }}" class="btn btn-secondary">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 8h8a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Download Course
            </a>
            @endif
            
            <a href="{{ route('client.dashboard') }}" class="btn btn-outline">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                </svg>
                Go to Dashboard
            </a>
        </div>
        
        <!-- Email Confirmation Notice -->
        <div class="email-notice">
            <svg class="email-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <div>
                <h4>Confirmation Email Sent</h4>
                <p>We've sent a confirmation email with your course access details to {{ auth('client')->user()->email ?? 'your email address' }}.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate success elements
    setTimeout(() => {
        document.querySelector('.success-animation').classList.add('animate');
    }, 300);
    
    setTimeout(() => {
        document.querySelector('.success-message').classList.add('animate');
    }, 800);
    
    setTimeout(() => {
        document.querySelector('.course-card').classList.add('animate');
    }, 1200);
    
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
            });
        });
    }
    
    // Auto-redirect to course after 30 seconds (optional)
    let countdown = 30;
    const redirectTimer = setInterval(() => {
        countdown--;
        if (countdown <= 0) {
            clearInterval(redirectTimer);
            window.location.href = "{{ route('client.course.show', $course->id) }}";
        }
    }, 1000);
});
</script>
@endsection






























































































