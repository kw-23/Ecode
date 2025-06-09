@extends('layouts.client')

@section('title', $course->title . ' - Course Details')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Utilise les mêmes variables CSS que la vue précédente */
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
    --shadow-soft: 0 8px 32px rgba(0, 0, 0, 0.1);
    --shadow-medium: 0 16px 64px rgba(0, 0, 0, 0.15);
    --border-radius-sm: 16px;
    --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--gray-50);
    color: var(--gray-800);
    line-height: 1.6;
}

.course-detail-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.breadcrumb {
    margin-bottom: 2rem;
    font-size: 0.9rem;
    color: var(--gray-600);
}

.breadcrumb a {
    color: var(--primary);
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.course-header {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 3rem;
    margin-bottom: 3rem;
}

.course-info {
    background: var(--light);
    padding: 2rem;
    border-radius: var(--border-radius-sm);
    box-shadow: var(--shadow-soft);
}

.course-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--gray-900);
    margin-bottom: 1rem;
    line-height: 1.2;
}

.course-meta {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-600);
    font-size: 0.9rem;
}

.meta-item svg {
    width: 18px;
    height: 18px;
}

.course-description {
    color: var(--gray-700);
    font-size: 1.1rem;
    line-height: 1.7;
    margin-bottom: 2rem;
}

.course-sidebar {
    background: var(--light);
    padding: 2rem;
    border-radius: var(--border-radius-sm);
    box-shadow: var(--shadow-soft);
    height: fit-content;
}

.course-image {
    width: 100%;
    height: 200px;
    border-radius: var(--border-radius-sm);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.purchase-info {
    background: var(--gray-50);
    padding: 1.5rem;
    border-radius: var(--border-radius-sm);
    margin-bottom: 1.5rem;
}

.purchase-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--success);
    font-weight: 600;
    margin-bottom: 1rem;
}

.purchase-status svg {
    width: 20px;
    height: 20px;
}

.purchase-details {
    font-size: 0.9rem;
    color: var(--gray-600);
}

.purchase-details div {
    margin-bottom: 0.5rem;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius-sm);
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
    width: 100%;
    margin-bottom: 1rem;
}

.btn-success {
    background: var(--success);
    color: white;
}

.btn-success:hover {
    background: #059669;
    transform: translateY(-2px);
}

.btn-outline {
    background: transparent;
    color: var(--gray-700);
    border: 2px solid var(--gray-300);
}

.btn-outline:hover {
    background: var(--gray-100);
    border-color: var(--gray-400);
}

.btn svg {
    width: 18px;
    height: 18px;
}

.no-materials {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--gray-100);
    border: 1px dashed var(--gray-300);
    border-radius: var(--border-radius-sm);
    color: var(--gray-500);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.course-content-section {
    background: var(--light);
    padding: 2rem;
    border-radius: var(--border-radius-sm);
    box-shadow: var(--shadow-soft);
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 1.5rem;
}

.reviews-section {
    background: var(--light);
    padding: 2rem;
    border-radius: var(--border-radius-sm);
    box-shadow: var(--shadow-soft);
}

.review-item {
    border-bottom: 1px solid var(--gray-200);
    padding-bottom: 1.5rem;
    margin-bottom: 1.5rem;
}

.review-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.reviewer-name {
    font-weight: 600;
    color: var(--gray-900);
}

.review-rating {
    display: flex;
    gap: 0.25rem;
}

.review-rating svg {
    width: 16px;
    height: 16px;
    fill: #fbbf24;
}

.review-date {
    font-size: 0.8rem;
    color: var(--gray-500);
    margin-bottom: 0.5rem;
}

.review-text {
    color: var(--gray-700);
    line-height: 1.6;
}

@media (max-width: 768px) {
    .course-header {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .course-title {
        font-size: 2rem;
    }
    
    .course-meta {
        gap: 1rem;
    }
}
</style>
@endsection

@section('content')
<div class="course-detail-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('client.dashboard') }}">Dashboard</a> / 
        <a href="{{ route('client.purchased-courses') }}">My Courses</a> / 
        {{ $course->title }}
    </div>
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Course Header -->
    <div class="course-header">
        <div class="course-info">
            <h1 class="course-title">{{ $course->title }}</h1>
            
            <div class="course-meta">
                @if($course->instructor)
                    <div class="meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $course->instructor->name }}
                    </div>
                @endif
                
                @if($course->category)
                    <div class="meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        {{ $course->category->name }}
                    </div>
                @endif
                
                <div class="meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $course->estimated_hours ?? 'N/A' }} hours
                </div>
                
                <div class="meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ ucfirst($course->difficulty_level) }}
                </div>
                
                @if($course->rating > 0)
                    <div class="meta-item">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        {{ number_format($course->rating, 1) }} ({{ $course->reviews_count }} reviews)
                    </div>
                @endif
            </div>
            
            <div class="course-description">
                {{ $course->description }}
            </div>
        </div>
        
        <div class="course-sidebar">
            @if($course->cover_image)
                <div class="course-image">
                    <img src="{{ asset($course->cover_image) }}" alt="{{ $course->title }}">
                </div>
            @endif
            
            <div class="purchase-info">
                <div class="purchase-status">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Course Purchased
                </div>
                
                <div class="purchase-details">
                    <div><strong>Purchase Date:</strong> {{ $purchase->purchased_at ? $purchase->purchased_at->format('M d, Y') : 'N/A' }}</div>
                    <div><strong>Amount Paid:</strong> ${{ number_format($purchase->amount, 2) }}</div>
                </div>
            </div>
            
            <!-- Download Materials -->
            @if($course->pdf_file_path)
                <a href="{{ route('client.download-course', $course->id) }}" 
                   class="btn btn-success download-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 8h8a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Download Course Materials
                </a>
            @else
                <div class="no-materials">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Course materials coming soon</span>
                </div>
            @endif
            
            <a href="{{ route('client.purchased-courses') }}" class="btn btn-outline">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to My Courses
            </a>
        </div>
    </div>
    
    <!-- Course Content -->
    @if($course->short_description)
        <div class="course-content-section">
            <h2 class="section-title">Course Overview</h2>
            <p>{{ $course->short_description }}</p>
        </div>
    @endif
    
    <!-- Course Tags -->
    @if($course->tags && count($course->tags) > 0)
        <div class="course-content-section">
            <h2 class="section-title">What You'll Learn</h2>
            <div class="tags-container">
                @foreach($course->tags as $tag)
                    <span class="tag">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
    @endif
    
    <!-- Reviews Section -->
    @if($reviews->count() > 0)
        <div class="reviews-section">
            <h2 class="section-title">Student Reviews ({{ $reviews->count() }})</h2>
            
            @if($averageRating > 0)
                <div class="average-rating">
                    <div class="rating-display">
                        <span class="rating-number">{{ number_format($averageRating, 1) }}</span>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="star {{ $i <= $averageRating ? 'filled' : '' }}" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="rating-text">Based on {{ $reviews->count() }} reviews</span>
                    </div>
                </div>
            @endif
            
            <div class="reviews-list">
                @foreach($reviews->take(5) as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <span class="reviewer-name">{{ $review->client->name ?? 'Anonymous' }}</span>
                            <div class="review-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="{{ $i <= $review->rating ? 'filled' : '' }}" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                        <div class="review-text">{{ $review->comment }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
.tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag {
    background: var(--primary);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
}

.average-rating {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: var(--border-radius-sm);
}

.rating-display {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.rating-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
}

.rating-stars {
    display: flex;
    gap: 0.25rem;
}

.star {
    width: 20px;
    height: 20px;
    fill: var(--gray-300);
}

.star.filled {
    fill: #fbbf24;
}

.rating-text {
    color: var(--gray-600);
    font-size: 0.9rem;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius-sm);
    margin-bottom: 2rem;
    font-weight: 500;
}

.alert-danger {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.alert-success {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add download button click tracking with loading state
    const downloadBtn = document.querySelector('.download-btn');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function(e) {
            const originalContent = this.innerHTML;
            
            this.innerHTML = `
                <svg class="animate-spin" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Preparing Download...
            `;
            
            this.style.opacity = '0.6';
            this.style.pointerEvents = 'none';
            
            // Reset after 3 seconds
            setTimeout(() => {
                this.innerHTML = originalContent;
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
            }, 3000);
        });
    }
    
    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        });
    }, 5000);
});

// Add CSS for spinning animation
const style = document.createElement('style');
style.textContent = `
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection