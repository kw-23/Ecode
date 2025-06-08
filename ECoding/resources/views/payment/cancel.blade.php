@extends('layouts.client')

@section('title', 'Payment Cancelled')

@section('head')
<meta name="robots" content="noindex, nofollow">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('styles')
<style>
:root {
    --primary: #6366f1;
    --secondary: #f43f5e;
    --warning: #f59e0b;
    --error: #ef4444;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
}

body {
    font-family: 'Inter', sans-serif;
    background: var(--gray-50);
    color: var(--gray-800);
}

.cancel-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

.cancel-container {
    max-width: 600px;
    background: white;
    border-radius: 24px;
    box-shadow: var(--shadow-lg);
    padding: 3rem;
    text-align: center;
}

.cancel-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 2rem;
    color: var(--error);
}

.cancel-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--gray-900);
    margin-bottom: 1rem;
}

.cancel-message {
    font-size: 1.1rem;
    color: var(--gray-600);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: #4f46e5;
    transform: translateY(-2px);
}

.btn-outline {
    background: white;
    color: var(--gray-700);
    border: 2px solid var(--gray-300);
}

.btn-outline:hover {
    background: var(--gray-50);
    border-color: var(--gray-400);
}
</style>
@endsection

@section('content')
<div class="cancel-page">
    <div class="cancel-container">
        <svg class="cancel-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        
        <h1 class="cancel-title">Payment Cancelled</h1>
        <p class="cancel-message">
            Your payment was cancelled and no charges were made. 
            You can try again or contact our support team if you need assistance.
        </p>
        
        <div class="action-buttons">
            <a href="{{ route('payment.checkout', $course) }}" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Try Again
            </a>
            
            <a href="{{ route('courses.public.show', $course->slug) }}" class="btn btn-outline">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Course
            </a>
        </div>
    </div>
</div>
@endsection
