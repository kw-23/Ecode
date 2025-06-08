@extends('layouts.client')

@section('title', $course->title)

@section('styles')
<style>
/* Course Detail Styles */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    --error-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
}

* {
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.6;
    color: var(--gray-800);
    background-color: var(--gray-50);
}

.course-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 2rem 0;
    overflow: hidden;
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
}

/* Random Backgrounds */
.random-bg-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.random-bg-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.random-bg-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.random-bg-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.random-bg-5 { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
.random-bg-6 { background: linear-gradient(135deg, #30cfd0 0%, #91a7ff 100%); }
.random-bg-7 { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }
.random-bg-8 { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); }
.random-bg-9 { background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); }
.random-bg-10 { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }

/* Animated Background Particles */
.bg-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.particle {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
.particle:nth-child(2) { width: 60px; height: 60px; left: 20%; animation-delay: 1s; }
.particle:nth-child(3) { width: 100px; height: 100px; left: 30%; animation-delay: 2s; }
.particle:nth-child(4) { width: 40px; height: 40px; left: 40%; animation-delay: 3s; }
.particle:nth-child(5) { width: 120px; height: 120px; left: 50%; animation-delay: 4s; }
.particle:nth-child(6) { width: 70px; height: 70px; left: 60%; animation-delay: 5s; }
.particle:nth-child(7) { width: 90px; height: 90px; left: 70%; animation-delay: 0.5s; }
.particle:nth-child(8) { width: 50px; height: 50px; left: 80%; animation-delay: 1.5s; }
.particle:nth-child(9) { width: 110px; height: 110px; left: 90%; animation-delay: 2.5s; }

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
    50% { transform: translateY(-100px) rotate(180deg); opacity: 1; }
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 3rem;
    align-items: center;
}

@media (max-width: 1024px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }
}

.hero-text {
    color: white;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.1;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    line-height: 1.6;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.hero-features {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2rem;
}

.feature-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.feature-badge:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* Course Card */
.course-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.course-card-header {
    margin-bottom: 1.5rem;
}

.course-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
}

.course-details-grid {
    display: grid;
    gap: 1rem;
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--gray-50);
    border-radius: 0.75rem;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.detail-item:hover {
    background: white;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--gray-700);
}

.detail-value {
    font-weight: 700;
    color: var(--gray-900);
}

/* Course Actions */
.course-actions {
    margin-bottom: 1.5rem;
}

/* Authentication Required Section */
.auth-required-section {
    text-align: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    border-radius: 0.75rem;
    border: 1px solid #d1d5db;
}

.auth-message {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    color: #6b7280;
    font-weight: 500;
}

.login-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px -3px rgba(59, 130, 246, 0.4);
    color: white;
    text-decoration: none;
}

/* Purchased Course Section */
.purchased-course-section {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: 1px solid #10b981;
    border-radius: 0.75rem;
    padding: 1.5rem;
}

.purchased-course-info {
    margin-bottom: 1.5rem;
}

.success-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #065f46;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.purchase-date {
    color: #047857;
    font-size: 0.875rem;
    margin: 0;
    opacity: 0.8;
}

.download-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
    width: 100%;
    justify-content: center;
}

.download-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px -3px rgba(16, 185, 129, 0.4);
    color: white;
    text-decoration: none;
}

.no-content-message {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem;
    background: #fef3c7;
    border: 1px solid #f59e0b;
    border-radius: 0.5rem;
    color: #92400e;
    font-weight: 500;
}

/* Pending Purchase Section */
.pending-purchase-section {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 1px solid #f59e0b;
    border-radius: 0.75rem;
    padding: 1.5rem;
    text-align: center;
}

.pending-message {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: #92400e;
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 1.1rem;
}

.pending-description {
    color: #78350f;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.check-status-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.check-status-btn:hover {
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

/* Purchase Options */
.purchase-options {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.buy-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.75rem;
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.3);
    font-size: 1.1rem;
}

.buy-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px -3px rgba(139, 92, 246, 0.4);
    color: white;
    text-decoration: none;
}

.cart-btn, .add-cart-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 1rem;
}

.cart-btn:hover, .add-cart-btn:hover {
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
}

.add-cart-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Course Features */
.course-features {
    display: grid;
    gap: 0.75rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--gray-50);
    border-radius: 0.5rem;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    font-weight: 500;
    color: var(--gray-700);
}

.feature-item:hover {
    background: white;
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.feature-icon {
    width: 1.25rem;
    height: 1.25rem;
    color: var(--gray-500);
}

/* Content Section */
.content-section {
    background: white;
    min-height: 100vh;
    padding: 4rem 0;
}

.main-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
}

@media (max-width: 1024px) {
    .main-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

.content-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--gray-200);
    margin-bottom: 2rem;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--gray-900);
}

.section-icon {
    padding: 0.5rem;
    background: var(--primary-gradient);
    border-radius: 0.5rem;
    color: white;
}

.text-gradient {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Sidebar */
.sidebar {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.sidebar-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--gray-200);
}

/* Responsive Design */
@media (min-width: 640px) {
    .purchase-options {
        flex-direction: row;
    }
    
    .buy-btn {
        flex: 2;
    }
    
    .cart-btn, .add-cart-btn {
        flex: 1;
    }
}

/* Animation Classes */
.animate-fade-in {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.animate-fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}

.animate-delay-1 { transition-delay: 0.2s; }
.animate-delay-2 { transition-delay: 0.4s; }
.animate-delay-3 { transition-delay: 0.6s; }

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Notification Toast */
.notification-toast {
    border-radius: 0.5rem;
    padding: 1rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border: 1px solid #10b981;
    color: #065f46;
}

.alert-error {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 1px solid #ef4444;
    color: #991b1b;
}

.alert-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: 1px solid #3b82f6;
    color: #1e40af;
}

.alert-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 1px solid #f59e0b;
    color: #92400e;
}

/* Interactive Elements */
.interactive {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.interactive:hover {
    transform: translateY(-1px);
}

/* Ripple Effect */
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}

/* Reviews Section Styles */
.rating-overview {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 0.75rem;
    border: 1px solid var(--gray-200);
}

.rating-summary {
    text-align: center;
}

.rating-number {
    font-size: 3rem;
    font-weight: 800;
    color: var(--gray-900);
    line-height: 1;
}

.rating-stars {
    display: flex;
    gap: 0.25rem;
    justify-content: center;
    margin: 0.5rem 0;
}

.star {
    width: 1.5rem;
    height: 1.5rem;
    fill: #fbbf24;
    stroke: #f59e0b;
}

.star.empty {
    fill: #e5e7eb;
    stroke: #cbd5e1;
}

.rating-count {
    font-size: 0.875rem;
    color: var(--gray-600);
}

.rating-breakdown {
    display: grid;
    gap: 0.5rem;
}

.rating-row {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 1rem;
    align-items: center;
}

.rating-label {
    font-size: 0.875rem;
    color: var(--gray-600);
    white-space: nowrap;
}

.rating-bar {
    height: 0.5rem;
    background: var(--gray-200);
    border-radius: 0.25rem;
    overflow: hidden;
}

.rating-fill {
    height: 100%;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    border-radius: 0.25rem;
    transition: width 1s ease-out;
    width: 0%;
}

.rating-percentage {
    font-size: 0.875rem;
    color: var(--gray-600);
    font-weight: 600;
}

/* Review Form */
.review-form {
    background: var(--gray-50);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid var(--gray-200);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.star-rating {
    display: flex;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
}

.star-input {
    width: 2rem;
    height: 2rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.star-input:hover {
    transform: scale(1.1);
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--gray-300);
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.textarea {
    min-height: 120px;
    resize: vertical;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary {
    background: var(--primary-gradient);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px -3px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.btn-outline {
    background: transparent;
    border: 1px solid var(--gray-300);
    color: var(--gray-700);
}

.btn-outline:hover {
    background: var(--gray-50);
    color: var(--gray-700);
    text-decoration: none;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Review Items */
.review-item {
    background: white;
    border-radius: 0.75rem;
    padding: 1.5rem;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.review-item:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.reviewer-info {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.reviewer-avatar {
    width: 3rem;
    height: 3rem;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.25rem;
}

.reviewer-details h4 {
    font-weight: 600;
    color: var(--gray-900);
    margin: 0 0 0.25rem 0;
}

.review-date {
    font-size: 0.875rem;
    color: var(--gray-500);
}

.review-actions {
    display: flex;
    gap: 0.5rem;
}

.review-content {
    color: var(--gray-700);
    line-height: 1.6;
    margin: 0;
}

/* Objectives Grid */
.objectives-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.objective-item {
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 0.75rem;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.objective-item:hover {
    background: white;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.objective-icon {
    width: 3rem;
    height: 3rem;
    background: var(--primary-gradient);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-bottom: 1rem;
}

/* Prose Styles */
.prose {
    color: var(--gray-700);
    line-height: 1.7;
}

.prose p {
    margin-bottom: 1rem;
}

.prose-lg {
    font-size: 1.125rem;
}

/* Alert Styles */
.alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    font-weight: 500;
}

.alert svg {
    flex-shrink: 0;
}
</style>
@endsection

@section('content')
<div class="course-container">
    <!-- Hero Section with Random Background -->
    <section class="hero-section random-bg-1" id="heroSection">
        <!-- Animated Background Particles -->
        <div class="bg-particles">
            @for($i = 0; $i < 9; $i++)
                <div class="particle"></div>
            @endfor
        </div>

        <div class="hero-content">
            <div class="hero-text animate-fade-in">
                <h1 class="hero-title">{{ $course->title }}</h1>
                <p class="hero-subtitle">
                    {{ $course->short_description ?? 'Master the art of digital design with our comprehensive course. Learn from industry experts and transform your creative vision.' }}
                </p>
                
                <div class="hero-features">
                    @if($course->category)
                        <div class="feature-badge interactive">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ $course->category->name }}
                        </div>
                    @endif
                    
                    <div class="feature-badge interactive">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Certificate Included
                    </div>
                    
                    <div class="feature-badge interactive">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                        </svg>
                        100% Online
                    </div>
                    
                    <div class="feature-badge interactive">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Lifetime Access
                    </div>
                </div>
            </div>
            
            <!-- Enhanced Course Details Card -->
            <div class="course-card animate-fade-in animate-delay-1">
                <div class="course-card-header">
                    <h3 class="course-card-title">Course Details</h3>
                </div>
                
                <div class="course-details-grid">
                    <div class="detail-item interactive">
                        <div class="detail-label">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Difficulty
                        </div>
                        <div class="detail-value">{{ ucfirst($course->difficulty_level ?? 'Intermediate') }}</div>
                    </div>
                    
                    @if($course->price)
                    <div class="detail-item interactive">
                        <div class="detail-label">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Price
                        </div>
                        <div class="detail-value">${{ number_format($course->price, 2) }}</div>
                    </div>
                    @endif
                </div>
                
                <!-- Action Buttons -->
                <div class="course-actions">
                    @php
                        // Ensure $purchaseStatus is always defined to avoid undefined variable errors
                        if (!isset($purchaseStatus)) {
                            $purchaseStatus = [
                                'status' => null,
                                'is_in_cart' => false,
                                'purchase_date' => null,
                            ];
                        }
                    @endphp
                    @if(!auth('client')->check())
                        <!-- User not logged in -->
                        <div class="auth-required-section">
                            <div class="auth-message">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Please login to purchase this course</span>
                            </div>
                            <a href="{{ route('client.login') }}" class="login-btn interactive">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Login to Purchase
                            </a>
                        </div>
                    @elseif($purchaseStatus['status'] === 'purchased')
                        <!-- User has purchased the course -->
                        <div class="purchased-course-section">
                            <div class="purchased-course-info">
                                <div class="success-message">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Course Purchased Successfully!</span>
                                </div>
                                @if(isset($purchaseStatus['purchase_date']))
                                    <p class="purchase-date">
                                        Purchased on {{ $purchaseStatus['purchase_date']->format('M d, Y \a\t H:i') }}
                                    </p>
                                @endif
                            </div>
                            
                            @if($course->pdf_file_path && file_exists(public_path($course->pdf_file_path)))
                                <a href="{{ route('client.download-course', $course->id) }}" 
                                   class="download-btn interactive" 
                                   id="downloadBtn">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 8h8a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Download Course Material
                                </a>
                            @else
                                <div class="no-content-message">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Course materials will be available soon</span>
                                </div>
                            @endif
                        </div>
                    @elseif($purchaseStatus['status'] === 'pending')
                        <!-- Purchase is pending -->
                        <div class="pending-purchase-section">
                            <div class="pending-message">
                                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span>Payment Processing...</span>
                            </div>
                            <p class="pending-description">
                                Your payment is being processed. You'll receive access once payment is confirmed.
                            </p>
                            <a href="{{ route('payment.history') }}" class="check-status-btn interactive">
                                Check Payment Status
                            </a>
                        </div>
                    @else
                        <!-- User can purchase the course -->
                        <div class="purchase-options">
                            <!-- Direct Purchase Button -->
                            <a href="{{ route('payment.checkout', $course->id) }}" 
                               class="buy-btn interactive" 
                               id="buyBtn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Buy Now - ${{ number_format($course->price ?? 99, 2) }}
                            </a>
                            
                            <!-- Add to Cart Button -->
                            @if(class_exists('\App\Models\Cart'))
                                @if($purchaseStatus['is_in_cart'])
                                    <a href="{{ route('cart.index') }}" class="cart-btn interactive">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        In Cart - View Cart
                                    </a>
                                @else
                                    <button onclick="addToCart({{ $course->id }})" 
                                            class="add-cart-btn interactive"
                                            id="addToCartBtn">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
                
                <div class="course-features">
                    <div class="feature-item interactive">
                        <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Certificate Included
                    </div>
                    <div class="feature-item interactive">
                        <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                        </svg>
                        100% Online
                    </div>
                    <div class="feature-item interactive">
                        <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Lifetime Access
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <div class="content-section">
        <div class="main-content">
            <!-- Course Overview -->
            <div class="content-card animate-fade-in">
                <h2 class="section-title">
                    <div class="section-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-gradient">{{ $course->title }}</span>
                </h2>
                
                <div class="prose prose-lg">
                    <p>{{ $course->description }}</p>
                </div>
                
                @if($course->tags)
                    <div style="margin-top: 2rem;">
                        <h3 style="margin-bottom: 1rem; font-weight: 600; color: var(--gray-700);">Topics Covered:</h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            @php
                                $tags = is_array($course->tags) ? $course->tags : (json_decode($course->tags, true) ?? []);
                            @endphp
                            @foreach($tags as $tag)
                                <span class="feature-badge interactive" style="background: var(--primary-gradient); color: white; border: none;">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- What You'll Learn -->
            <div class="content-card animate-fade-in animate-delay-1">
                <h2 class="section-title">
                    <div class="section-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <span class="text-gradient">What You'll Learn</span>
                </h2>
                
                <div class="objectives-grid">
                    <div class="objective-item">
                        <div class="objective-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--gray-900);">Master Core Concepts</h4>
                        <p style="color: var(--gray-600); line-height: 1.6;">Understand fundamental principles and advanced techniques in your field of study.</p>
                    </div>
                    
                    <div class="objective-item">
                        <div class="objective-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--gray-900);">Hands-on Projects</h4>
                        <p style="color: var(--gray-600); line-height: 1.6;">Build real-world applications and create a portfolio that showcases your skills.</p>
                    </div>
                    
                    <div class="objective-item">
                        <div class="objective-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--gray-900);">Industry Best Practices</h4>
                        <p style="color: var(--gray-600); line-height: 1.6;">Learn professional workflows and standards used by industry leaders.</p>
                    </div>
                    
                    <div class="objective-item">
                        <div class="objective-icon">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--gray-900);">Problem Solving</h4>
                        <p style="color: var(--gray-600); line-height: 1.6;">Develop critical thinking skills to tackle complex challenges and find innovative solutions.</p>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="content-card animate-fade-in animate-delay-2">
                <h2 class="section-title">
                    <div class="section-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <span class="text-gradient">Student Reviews</span>
                </h2>

                <!-- Rating Overview -->
                <div class="rating-overview">
                    <div class="rating-summary">
                        <div class="rating-number">{{ number_format($averageRating ?? 0, 1) }}</div>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="star {{ $i <= round($averageRating ?? 0) ? '' : 'empty' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <div class="rating-count">
                            Based on {{ isset($reviews) ? $reviews->count() : 0 }} review{{ (isset($reviews) && $reviews->count() != 1) ? 's' : '' }}
                        </div>
                    </div>

                    <div class="rating-breakdown">
                        @php
                            $reviews = $reviews ?? collect();
                            $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                            foreach ($reviews as $review) {
                                $rating = (int) $review->rating;
                                if (isset($ratingCounts[$rating])) {
                                    $ratingCounts[$rating]++;
                                }
                            }
                            $totalReviews = $reviews->count();
                        @endphp

                        @for($i = 5; $i >= 1; $i--)
                            @php
                                $count = $ratingCounts[$i];
                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            @endphp
                            <div class="rating-row">
                                <div class="rating-label">{{ $i }} star{{ $i > 1 ? 's' : '' }}</div>
                                <div class="rating-bar">
                                    <div class="rating-fill" style="width: {{ $percentage }}%" data-percentage="{{ $percentage }}"></div>
                                </div>
                                <div class="rating-percentage">{{ round($percentage) }}%</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Add Review Form -->
                @auth('client')
                    @if(!isset($userReview) || !$userReview)
                        <div class="review-form">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; color: var(--gray-900);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Share Your Experience
                            </h3>

                            <form action="{{ route('course.reviews.store', $course->id) }}" method="POST" id="reviewForm">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Your Rating</label>
                                    <div class="star-rating" id="rating-input">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="star-input" data-rating="{{ $i }}" fill="#e5e7eb" stroke="#cbd5e1" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-value" value="5" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Your Comment</label>
                                    <textarea name="comment" class="form-control textarea" placeholder="Share your thoughts about this course..." required>{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <span style="color: var(--error); font-size: 0.875rem; margin-top: 0.5rem; display: block;">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary interactive">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Post Review
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="review-form" style="text-align: center;">
                        <p style="color: var(--gray-600); margin-bottom: 1rem; font-size: 1.125rem;">Please log in to leave a review</p>
                        <a href="{{ route('client.login') }}" class="btn btn-primary interactive">Login to Review</a>
                    </div>
                @endauth

                <!-- Reviews List -->
                <div style="display: grid; gap: 1.5rem;">
                    @forelse($reviews ?? [] as $review)
                        <div class="review-item" id="review-{{ $review->id }}">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar">
                                        {{ strtoupper(substr($review->client->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="reviewer-details">
                                        <h4>{{ $review->client->name ?? 'Anonymous' }}</h4>
                                        <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>

                                @auth('client')
                                    @if($review->client_id === auth('client')->id())
                                        <div class="review-actions">
                                            <button onclick="editReview({{ $review->id }})" class="btn btn-sm btn-outline interactive">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <form action="{{ route('course.reviews.destroy', [$course->id, $review->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm interactive" style="background: var(--secondary-gradient); color: white;">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>

                            <div class="rating-stars" style="margin-bottom: 1rem;">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="star {{ $i <= ($review->rating ?? 0) ? '' : 'empty' }}" style="width: 1.25rem; height: 1.25rem;" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            <div class="review-content-{{ $review->id }}">
                                <p class="review-content">{{ $review->comment }}</p>
                            </div>

                            <!-- Edit Form (Hidden by default) -->
                            <div class="edit-form-{{ $review->id }}" style="display: none;">
                                <form action="{{ route('course.reviews.update', [$course->id, $review->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="form-label">Rating</label>
                                        <div class="star-rating" id="edit-rating-{{ $review->id }}">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="star-input {{ $i <= ($review->rating ?? 0) ? '' : 'empty' }}" data-rating="{{ $i }}" fill="#fbbf24" stroke="#f59e0b" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="edit-rating-value-{{ $review->id }}" value="{{ $review->rating ?? 5 }}">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="comment" class="form-control textarea" required>{{ $review->comment }}</textarea>
                                    </div>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button type="submit" class="btn btn-sm interactive" style="background: var(--success-gradient); color: white;">Save</button>
                                        <button type="button" onclick="cancelEdit({{ $review->id }})" class="btn btn-sm btn-outline interactive">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 4rem 0;">
                            <svg style="width: 5rem; height: 5rem; color: var(--gray-300); margin: 0 auto 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 style="color: var(--gray-500); font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem;">No reviews yet</h3>
                            <p style="color: var(--gray-400); font-size: 1.125rem;">Be the first to review this course!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-card animate-fade-in animate-delay-3">
                <h3 class="section-title" style="font-size: 1.5rem;">
                    <div class="section-icon">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="text-gradient">Course Stats</span>
                </h3>
                
                <div style="display: grid; gap: 1rem;">
                    @if($course->price)
                    <div class="detail-item interactive">
                        <div class="detail-label">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Price
                        </div>
                        <div class="detail-value">${{ number_format($course->price, 2) }}</div>
                    </div>
                    @endif
                    
                    <div class="detail-item interactive">
                        <div class="detail-label">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Downloads
                        </div>
                        <div class="detail-value">{{ $course->downloads_count ?? 1247 }}</div>
                    </div>
                    
                    <div class="detail-item interactive">
                        <div class="detail-label">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            Rating
                        </div>
                        <div class="detail-value">{{ number_format($averageRating ?? 4.8, 1) }}/5.0</div>
                    </div>
                    
                    <div class="detail-item interactive">
                        <div class="detail-label">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Reviews
                        </div>
                        <div class="detail-value">{{ isset($reviews) ? $reviews->count() : 247 }}</div>
                    </div>
                    
                    <div class="detail-item interactive">
                        <div class="detail-label">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Last Updated
                        </div>
                        <div class="detail-value">{{ $course->updated_at ? $course->updated_at->format('M d, Y') : 'Dec 15, 2024' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all interactive features
    initializeScrollAnimations();
    initializeStarRating();
    initializeEditForms();
    initializeProgressBars();
    initializeRandomBackground();
    initializeInteractiveElements();
    autoHideAlerts();
    
    // Check purchase status periodically if pending
    @if(isset($purchaseStatus) && $purchaseStatus['status'] === 'pending')
        checkPurchaseStatus();
        setInterval(checkPurchaseStatus, 30000); // Check every 30 seconds
    @endif
});

// Enhanced add to cart function with better error handling
function addToCart(courseId) {
    const button = document.getElementById('addToCartBtn');
    if (!button) return;
    
    const originalHTML = button.innerHTML;
    
    // Show loading state
    button.innerHTML = `
        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
        Adding to cart...
    `;
    button.disabled = true;
    
    fetch(`{{ route('cart.add', ['course' => 'COURSE_ID']) }}`.replace('COURSE_ID', courseId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message || 'Course added to cart successfully!', 'success');
            
            // Update button to show "In Cart"
            button.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                In Cart - View Cart
            `;
            button.onclick = () => window.location.href = '{{ route("cart.index") }}';
            
            // Update cart count if element exists
            updateCartCount(data.cartCount || 0);
        } else {
            throw new Error(data.message || 'Failed to add course to cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'An error occurred while adding to cart', 'error');
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

// Check purchase status for pending payments
function checkPurchaseStatus() {
    fetch(`{{ route('ajax.courses.check-enrollment', $course->id) }}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.purchased) {
            // Reload page to show download button
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error checking purchase status:', error);
    });
}

// Random Background System
function initializeRandomBackground() {
    // Set initial random background
    changeBackground();
    
    // Auto-change background every 30 seconds
    setInterval(changeBackground, 30000);
}

function changeBackground() {
    const heroSection = document.getElementById('heroSection');
    const backgroundClasses = [
        'random-bg-1', 'random-bg-2', 'random-bg-3', 'random-bg-4', 'random-bg-5',
        'random-bg-6', 'random-bg-7', 'random-bg-8', 'random-bg-9', 'random-bg-10'
    ];
    
    // Remove all background classes
    backgroundClasses.forEach(cls => heroSection.classList.remove(cls));
    
    // Add random background class
    const randomIndex = Math.floor(Math.random() * backgroundClasses.length);
    const newBgClass = backgroundClasses[randomIndex];
    
    // Add transition effect
    heroSection.style.transition = 'all 1s ease-in-out';
    heroSection.classList.add(newBgClass);
    
    // Show notification
    showNotification(`Background changed to theme ${randomIndex + 1}`, 'info');
}

// Scroll Reveal Animations
function initializeScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, index * 100);
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('.animate-fade-in').forEach((el) => {
        observer.observe(el);
    });
}

// Star Rating System
function initializeStarRating() {
    const ratingInput = document.getElementById('rating-input');
    if (ratingInput) {
        let selectedRating = 5;
        const stars = ratingInput.querySelectorAll('.star-input');
        const ratingValue = document.getElementById('rating-value');
        
        function updateStars(rating) {
            stars.forEach((star, idx) => {
                if (idx < rating) {
                    star.style.fill = '#fbbf24';
                    star.style.stroke = '#f59e0b';
                } else {
                    star.style.fill = '#e5e7eb';
                    star.style.stroke = '#cbd5e1';
                }
            });
        }
        
        stars.forEach((star, idx) => {
            star.addEventListener('mouseenter', () => updateStars(idx + 1));
            star.addEventListener('mouseleave', () => updateStars(selectedRating));
            star.addEventListener('click', () => {
                selectedRating = idx + 1;
                ratingValue.value = selectedRating;
                updateStars(selectedRating);
                
                // Add click animation
                star.style.transform = 'scale(1.3) rotate(10deg)';
                setTimeout(() => {
                    star.style.transform = '';
                }, 200);
            });
        });
        
        updateStars(selectedRating);
    }
}

// Edit Forms for Reviews
function initializeEditForms() {
    document.querySelectorAll('[id^="edit-rating-"]').forEach(function(editRatingDiv) {
        const stars = editRatingDiv.querySelectorAll('.star-input');
        const reviewId = editRatingDiv.id.replace('edit-rating-', '');
        const ratingInput = document.getElementById('edit-rating-value-' + reviewId);
        let selectedRating = parseInt(ratingInput.value, 10) || 5;
        
        function updateStars(rating) {
            stars.forEach((star, idx) => {
                if (idx < rating) {
                    star.style.fill = '#fbbf24';
                    star.style.stroke = '#f59e0b';
                } else {
                    star.style.fill = '#e5e7eb';
                    star.style.stroke = '#cbd5e1';
                }
            });
        }
        
        stars.forEach((star, idx) => {
            star.addEventListener('mouseenter', () => updateStars(idx + 1));
            star.addEventListener('mouseleave', () => updateStars(selectedRating));
            star.addEventListener('click', () => {
                selectedRating = idx + 1;
                ratingInput.value = selectedRating;
                updateStars(selectedRating);
            });
        });
        
        updateStars(selectedRating);
    });
}

// Progress Bar Animations
function initializeProgressBars() {
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBars = entry.target.querySelectorAll('.rating-fill');
                progressBars.forEach((bar, index) => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 300 + (index * 100));
                });
            }
        });
    }, { threshold: 0.3 });
    
    document.querySelectorAll('.rating-overview').forEach(overview => {
        progressObserver.observe(overview);
    });
}

// Interactive Elements
function initializeInteractiveElements() {
    // Add ripple effect to buttons
    document.querySelectorAll('.btn, .interactive').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const heroSection = document.querySelector('.hero-section');
        
        if (heroSection) {
            const rate = scrolled * -0.3;
            heroSection.style.transform = `translateY(${rate}px)`;
        }
    });
}

// Auto-hide alerts
function autoHideAlerts() {
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
}

// Edit Review Functions
function editReview(reviewId) {
    const contentDiv = document.querySelector(`.review-content-${reviewId}`);
    const editDiv = document.querySelector(`.edit-form-${reviewId}`);
    
    if (contentDiv && editDiv) {
        contentDiv.style.display = 'none';
        editDiv.style.display = 'block';
        
        // Add smooth transition
        editDiv.style.opacity = '0';
        editDiv.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            editDiv.style.transition = 'all 0.3s ease';
            editDiv.style.opacity = '1';
            editDiv.style.transform = 'translateY(0)';
        }, 10);
        
        // Focus on the textarea
        const textarea = editDiv.querySelector('textarea');
        if (textarea) {
            textarea.focus();
        }
    }
}

function cancelEdit(reviewId) {
    const contentDiv = document.querySelector(`.review-content-${reviewId}`);
    const editDiv = document.querySelector(`.edit-form-${reviewId}`);
    
    if (contentDiv && editDiv) {
        editDiv.style.opacity = '0';
        editDiv.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            contentDiv.style.display = 'block';
            editDiv.style.display = 'none';
            editDiv.style.transform = 'translateY(0)';
        }, 300);
    }
}

// Enhanced button interactions
document.addEventListener('click', function(e) {
    // Buy button
    if (e.target.matches('#buyBtn') || e.target.closest('#buyBtn')) {
        e.preventDefault();
        const btn = e.target.matches('#buyBtn') ? e.target : e.target.closest('#buyBtn');
        const originalHTML = btn.innerHTML;
        
        btn.innerHTML = `
            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Redirecting to checkout...
        `;
        
        btn.style.pointerEvents = 'none';
        
        setTimeout(() => {
            window.location.href = btn.href;
        }, 800);
        
        return false;
    }
    
    // Download button
    if (e.target.matches('#downloadBtn') || e.target.closest('#downloadBtn')) {
        const btn = e.target.matches('#downloadBtn') ? e.target : e.target.closest('#downloadBtn');
        const originalHTML = btn.innerHTML;
        
        btn.innerHTML = `
            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Preparing download...
        `;
        
        btn.style.pointerEvents = 'none';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.pointerEvents = 'auto';
            showNotification('Download started successfully!', 'success');
        }, 2000);
    }
});

// Enhanced notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    document.querySelectorAll('.notification-toast').forEach(n => n.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification-toast alert alert-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 500px;
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
    `;
    
    const icons = {
        success: 'M5 13l4 4L19 7',
        error: 'M6 18L18 6M6 6l12 12',
        info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z'
    };
    
    notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icons[type] || icons.info}"></path>
            </svg>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: inherit; cursor: pointer;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

// Update cart count
function updateCartCount(count) {
    document.querySelectorAll('.cart-count-badge').forEach(element => {
        element.textContent = count;
        element.style.display = count > 0 ? 'block' : 'none';
    });
}

// Form validation with enhanced UX
document.addEventListener('submit', function(e) {
    if (e.target.matches('form[action*="reviews"]')) {
        const rating = e.target.querySelector('input[name="rating"]').value;
        const comment = e.target.querySelector('textarea[name="comment"]').value.trim();
        
        if (!rating || rating < 1 || rating > 5) {
            e.preventDefault();
            showNotification('Please select a rating between 1 and 5 stars.', 'error');
            return;
        }
        
        if (!comment || comment.length < 10) {
            e.preventDefault();
            showNotification('Please write a comment with at least 10 characters.', 'error');
            return;
        }
        
        // Add loading state
        const submitBtn = e.target.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        }
    }
});
</script>

@endsection