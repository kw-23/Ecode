@extends('layouts.client')

@section('title', 'Payment Successful - Cart Purchase')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Ultra Modern Success Page Styles */
:root {
    --primary: #6366f1;
    --primary-hover: #4f46e5;
    --secondary: #f43f5e;
    --success: #10b981;
    --success-light: #34d399;
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
    --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --gradient-card: linear-gradient(145deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
    --shadow-soft: 0 8px 32px rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 16px 64px rgba(0, 0, 0, 0.15);
    --shadow-strong: 0 24px 96px rgba(0, 0, 0, 0.2);
    --blur-glass: blur(16px);
    --border-radius: 24px;
    --border-radius-sm: 16px;
    --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--gradient-primary);
    color: var(--gray-800);
    min-height: 100vh;
    overflow-x: hidden;
}

/* Animated Background */
.success-page {
    min-height: 100vh;
    background: var(--gradient-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    position: relative;
    overflow: hidden;
}

.success-page::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(255,255,255,0.08) 0%, transparent 50%);
    animation: float 20s ease-in-out infinite;
    pointer-events: none;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    33% { transform: translate(-20px, -20px) rotate(1deg); }
    66% { transform: translate(20px, -10px) rotate(-1deg); }
}

/* Glassmorphism Container */
.success-container {
    width: 100%;
    max-width: 900px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: var(--blur-glass);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-strong);
    overflow: hidden;
    animation: slideUpScale 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

@keyframes slideUpScale {
    from {
        opacity: 0;
        transform: translateY(60px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Success Header with Enhanced Animations */
.success-header {
    background: var(--gradient-success);
    color: white;
    padding: 3rem 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.success-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    animation: shimmer 3s ease-in-out infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.success-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: successPulse 1.2s cubic-bezier(0.4, 0, 0.2, 1) 0.3s both;
    position: relative;
    z-index: 2;
}

@keyframes successPulse {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.3);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}
body, .success-page {
                        background: var(--gray-50) !important;
                    }

.success-icon svg {
    width: 48px;
    height: 48px;
    stroke-width: 3;
}

.success-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    position: relative;
    z-index: 2;
    letter-spacing: -0.02em;
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.5s both;
}

.success-subtitle {
    font-size: 1.2rem;
    opacity: 0.95;
    position: relative;
    z-index: 2;
    font-weight: 400;
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.7s both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Content Area */
.success-content {
    padding: 2.5rem;
}

/* Enhanced Purchase Summary */
.purchase-summary {
    background: var(--gradient-card);
    backdrop-filter: var(--blur-glass);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: var(--border-radius-sm);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-soft);
    animation: slideInLeft 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.3s both;
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-40px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.summary-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.summary-title svg {
    width: 24px;
    height: 24px;
    color: var(--primary);
}

.courses-list {
    display: grid;
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.course-item {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(8px);
    border-radius: var(--border-radius-sm);
    box-shadow: var(--shadow-soft);
    border: 1px solid rgba(255, 255, 255, 0.4);
    transition: var(--transition);
    animation: fadeInScale 0.6s cubic-bezier(0.4, 0, 0.2, 1) both;
}

.course-item:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-medium);
    background: rgba(255, 255, 255, 0.95);
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.course-image {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--gray-200);
    position: relative;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.course-item:hover .course-image img {
    transform: scale(1.1);
}

.course-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
}

.course-details {
    flex: 1;
    min-width: 0;
}

.course-title {
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
    line-height: 1.4;
}

.course-instructor {
    font-size: 0.9rem;
    color: var(--gray-600);
    font-weight: 500;
}

.course-price {
    font-weight: 800;
    color: var(--primary);
    font-size: 1.25rem;
    letter-spacing: -0.01em;
}

.total-summary {
    border-top: 2px solid rgba(99, 102, 241, 0.2);
    padding-top: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(99, 102, 241, 0.05);
    margin: 0 -2rem -2rem -2rem;
    padding: 1.5rem 2rem;
    border-radius: 0 0 var(--border-radius-sm) var(--border-radius-sm);
}

.total-label {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--gray-700);
}

.total-amount {
    font-size: 2rem;
    font-weight: 900;
    color: var(--primary);
    letter-spacing: -0.02em;
}

/* Enhanced Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem;
    margin: 2.5rem 0;
    animation: slideInRight 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.5s both;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(40px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(8px);
    border-radius: var(--border-radius-sm);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: var(--shadow-soft);
    transition: var(--transition);
}

.feature-item:hover {
    transform: translateY(-2px);
    background: rgba(255, 255, 255, 0.9);
    box-shadow: var(--shadow-medium);
}

.feature-icon {
    width: 28px;
    height: 28px;
    color: var(--success);
    flex-shrink: 0;
    stroke-width: 2.5;
}

.feature-text {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-700);
}

/* Enhanced Payment Details */
.payment-details {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: var(--border-radius-sm);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-soft);
    animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.7s both;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.details-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.details-title svg {
    width: 22px;
    height: 22px;
    color: var(--primary);
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(203, 213, 225, 0.5);
    transition: var(--transition);
}

.detail-row:hover {
    background: rgba(99, 102, 241, 0.02);
    margin: 0 -2rem;
    padding: 1rem 2rem;
    border-radius: 8px;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: var(--gray-600);
    font-size: 1rem;
    font-weight: 500;
}

.detail-value {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 1rem;
}

.transaction-id {
    font-family: 'Monaco', 'Menlo', monospace;
    font-size: 0.85rem;
    background: rgba(99, 102, 241, 0.1);
    color: var(--primary);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    border: 1px solid rgba(99, 102, 241, 0.2);
}

.transaction-id:hover {
    background: rgba(99, 102, 241, 0.15);
    transform: scale(1.02);
}

/* Enhanced Action Buttons */
.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
    animation: fadeInScale 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.9s both;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1.25rem 2rem;
    border-radius: var(--border-radius-sm);
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    font-size: 1rem;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: var(--primary);
    color: white;
    box-shadow: var(--shadow-soft);
}

.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
}

.btn-secondary {
    background: var(--success);
    color: white;
    box-shadow: var(--shadow-soft);
}

.btn-secondary:hover {
    background: #059669;
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
}

.btn-outline {
    background: rgba(255, 255, 255, 0.8);
    color: var(--gray-700);
    border: 2px solid rgba(203, 213, 225, 0.5);
    backdrop-filter: blur(8px);
}

.btn-outline:hover {
    background: rgba(255, 255, 255, 0.95);
    border-color: var(--gray-400);
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
}

.btn svg {
    width: 20px;
    height: 20px;
    stroke-width: 2;
}

/* Enhanced Email Notice */
.email-notice {
    background: rgba(219, 234, 254, 0.8);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(147, 197, 253, 0.3);
    border-radius: var(--border-radius-sm);
    padding: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    animation: fadeInScale 0.8s cubic-bezier(0.4, 0, 0.2, 1) 1.1s both;
}

.email-icon {
    width: 24px;
    height: 24px;
    color: #2563eb;
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.email-content h4 {
    font-weight: 700;
    color: #1e40af;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.email-content p {
    color: #1e40af;
    font-size: 0.95rem;
    line-height: 1.5;
    font-weight: 500;
}

/* Responsive Enhancements */
@media (max-width: 768px) {
    .success-page {
        padding: 1rem;
    }
    
    .success-header {
        padding: 2rem 1.5rem;
    }
    
    .success-title {
        font-size: 2rem;
    }
    
    .success-content {
        padding: 2rem 1.5rem;
    }
    
    .course-item {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .course-details {
        text-align: center;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .total-summary {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .success-container {
        border-radius: 16px;
        margin: 0.5rem;
    }
    
    .success-icon {
        width: 80px;
        height: 80px;
    }
    
    .success-icon svg {
        width: 36px;
        height: 36px;
    }
    
    .success-title {
        font-size: 1.75rem;
    }
    
    .purchase-summary,
    .payment-details {
        padding: 1.5rem;
    }
}

/* Additional smooth animations */
.course-item:nth-child(1) { animation-delay: 0.1s; }
.course-item:nth-child(2) { animation-delay: 0.2s; }
.course-item:nth-child(3) { animation-delay: 0.3s; }
.course-item:nth-child(4) { animation-delay: 0.4s; }

.feature-item:nth-child(1) { animation-delay: 0.1s; }
.feature-item:nth-child(2) { animation-delay: 0.2s; }
.feature-item:nth-child(3) { animation-delay: 0.3s; }
.feature-item:nth-child(4) { animation-delay: 0.4s; }
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
            <p class="success-subtitle">Thank you for your purchase. You now have lifetime access to all your courses.</p>
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
                    <span class="detail-value">{{ ($purchases ?? collect())->count() }} Course(s)</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Total Amount</span>
                    <span class="detail-value">${{ number_format(($purchases ?? collect())->sum('amount'), 2) }}</span>
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
                
                @if(isset($purchases) && $purchases->count() === 1)
                    <a href="{{ route('client.course-details', ['id' => $purchases->first()->course->id]) }}" class="btn btn-secondary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Course Details
                    </a>
                @elseif(isset($purchases) && $purchases->count() > 1)
                    <a href="{{ route('client.enrolled-courses') }}" class="btn btn-secondary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View My Courses
                    </a>
                @endif

                <a href="{{ route('cart.payment-success') }}" class="btn btn-outline">
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
    // Enhanced animation sequence
    const animateElements = [
        { selector: '.purchase-summary', delay: 300 },
        { selector: '.features-grid', delay: 500 },
        { selector: '.payment-details', delay: 700 },
        { selector: '.action-buttons', delay: 900 },
        { selector: '.email-notice', delay: 1100 }
    ];
    
    animateElements.forEach(({ selector, delay }) => {
        setTimeout(() => {
            const element = document.querySelector(selector);
            if (element) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        }, delay);
    });
    
    // Enhanced copy transaction ID functionality
    const transactionId = document.querySelector('.transaction-id');
    if (transactionId) {
        transactionId.addEventListener('click', function() {
            navigator.clipboard.writeText(this.textContent).then(() => {
                const originalText = this.textContent;
                const originalBg = this.style.background;
                
                this.textContent = '✓ Copied!';
                this.style.background = 'rgba(16, 185, 129, 0.15)';
                this.style.color = '#059669';
                this.style.transform = 'scale(1.05)';
                
                setTimeout(() => {
                    this.textContent = originalText;
                    this.style.background = originalBg;
                    this.style.color = '';
                    this.style.transform = '';
                }, 2500);
            }).catch(err => {
                console.error('Failed to copy: ', err);
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = this.textContent;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                this.textContent = '✓ Copied!';
                setTimeout(() => {
                    this.textContent = originalText;
                }, 2000);
            });
        });
    }
    
    // Enhanced image loading with smooth transitions
    document.querySelectorAll('img').forEach(img => {
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.3s ease';
        
        img.onload = function() {
            this.style.opacity = '1';
        };
        
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
    
    // Add smooth scroll behavior for better UX
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
    
    // Add intersection observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for scroll animations
    document.querySelectorAll('.course-item, .feature-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
</script>
@endsection