@extends('layouts.client')

@section('title', $course->title . ' - Course Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/course-detail.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="course-details-container">
    <!-- Hero Section with Dynamic Background -->
    <section class="hero-section" id="heroSection">
        <div class="hero-background">
            <div class="floating-elements">
                @for($i = 0; $i < 6; $i++)
                    <div class="floating-element floating-element-{{ $i + 1 }}"></div>
                @endfor
            </div>
        </div>
        
        <div class="hero-content">
            <div class="hero-main">
                <div class="course-badge">
                    @if($course->category)
                        <span class="category-tag">{{ $course->category->name }}</span>
                    @endif
                    <span class="difficulty-tag difficulty-{{ strtolower($course->difficulty_level ?? 'intermediate') }}">
                        {{ ucfirst($course->difficulty_level ?? 'Intermediate') }}
                    </span>
                </div>
                
                <h1 class="hero-title">{{ $course->title }}</h1>
                
                <p class="hero-description">
                    {{ $course->short_description ?? 'Embark on a transformative learning journey with our expertly crafted course designed to elevate your skills and unlock new opportunities.' }}
                </p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $course->enrollments_count ?? '2,847' }}</span>
                            <span class="stat-label">Students</span>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ number_format($averageRating ?? 4.9, 1) }}</span>
                            <span class="stat-label">Rating</span>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number">{{ $course->duration ?? '12h' }}</span>
                            <span class="stat-label">Duration</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Course Purchase Card -->
            <div class="course-card">
                <div class="course-card-header">
                    <div class="price-section">
                        @if($course->price)
                            <span class="current-price">${{ number_format($course->price, 2) }}</span>
                            @if($course->original_price && $course->original_price > $course->price)
                                <span class="original-price">${{ number_format($course->original_price, 2) }}</span>
                                <span class="discount-badge">
                                    {{ round((($course->original_price - $course->price) / $course->original_price) * 100) }}% OFF
                                </span>
                            @endif
                        @else
                            <span class="free-badge">FREE</span>
                        @endif
                    </div>
                </div>
                
                <div class="course-features">
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Lifetime Access</span>
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Certificate Included</span>
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>30-Day Money Back</span>
                    </div>
                </div>
                
                <!-- Purchase Actions -->
                <div class="purchase-actions">
                    @guest('client')
                        <div class="auth-required">
                            <p class="auth-message">Please login to enroll in this course</p>
                            <a href="{{ route('client.login') }}" class="btn btn-primary btn-full">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Login to Enroll
                            </a>
                        </div>
                    @else
                        @php
                            $hasPurchased = false;
                            if(auth('client')->check()) {
                                $hasPurchased = \App\Models\Purchase::where('client_id', auth('client')->id())
                                    ->where('course_id', $course->id)
                                    ->where('status', 'pending') // Make sure to check for completed purchases
                                    ->exists();
                            }
                        @endphp
                        @if($hasPurchased)
                            <div class="enrolled-section">
                                <div class="success-message">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>You're enrolled!</span>
                                </div>
                                
                                @if($course->pdf_file_path)
                                    <a href="{{ route('client.download-course', $course->id) }}" class="btn btn-success btn-full">
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
                            </div>
                        @else
                            <div class="purchase-options">
                                
                                
                                @if(class_exists('\App\Models\Cart'))
                                    <button onclick="addToCart({{ $course->id }})" class="btn btn-secondary btn-full" id="cartBtn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"/>
                                        </svg>
                                        Add to Cart
                                    </button>
                                @endif
                            </div>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </section>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content-grid">
            <!-- Course Overview -->
            <section class="content-section overview-section">
                <div class="section-header">
                    <h2 class="section-title">Course Overview</h2>
                    <div class="section-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="content-body">
                    <p class="course-description">{{ $course->description }}</p>
                    
                    @if($course->tags)
                        <div class="tags-section">
                            <h3 class="tags-title">What you'll learn:</h3>
                            <div class="tags-grid">
                                @php
                                    $tags = is_array($course->tags) ? $course->tags : (json_decode($course->tags, true) ?? []);
                                @endphp
                                @foreach($tags as $tag)
                                    <span class="tag-item">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </section>
            
            <!-- Learning Objectives -->
            <section class="content-section objectives-section">
                <div class="section-header">
                    <h2 class="section-title">Learning Objectives</h2>
                    <div class="section-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="objectives-grid">
                    <div class="objective-card">
                        <div class="objective-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3>Master Core Concepts</h3>
                        <p>Gain deep understanding of fundamental principles and advanced techniques.</p>
                    </div>
                    
                    <div class="objective-card">
                        <div class="objective-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                        <h3>Hands-on Projects</h3>
                        <p>Build real-world applications and create an impressive portfolio.</p>
                    </div>
                    
                    <div class="objective-card">
                        <div class="objective-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3>Industry Standards</h3>
                        <p>Learn professional workflows and best practices used by industry leaders.</p>
                    </div>
                    
                    <div class="objective-card">
                        <div class="objective-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3>Problem Solving</h3>
                        <p>Develop critical thinking skills to tackle complex challenges effectively.</p>
                    </div>
                </div>
            </section>
            
            <!-- Reviews Section -->
            <section class="content-section reviews-section">
                <div class="section-header">
                    <h2 class="section-title">Student Reviews</h2>
                    <div class="section-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Rating Overview -->
                <div class="rating-overview">
                    <div class="rating-summary">
                        <div class="rating-number">{{ number_format($averageRating ?? 4.8, 1) }}</div>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="star {{ $i <= round($averageRating ?? 4.8) ? 'filled' : 'empty' }}" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="rating-text">Based on {{ isset($reviews) ? $reviews->count() : 0 }} reviews</p>
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
                                <span class="rating-label">{{ $i }} star</span>
                                <div class="rating-bar">
                                    <div class="rating-fill" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="rating-percentage">{{ round($percentage) }}%</span>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <!-- Add Review Form -->
                @auth('client')
                    @if(!isset($userReview) || !$userReview)
                        <div class="review-form">
                            <h3 class="form-title">Share Your Experience</h3>
                            <form action="{{ route('course.reviews.store', $course->id) }}" method="POST" id="reviewForm">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Your Rating</label>
                                    <div class="star-rating" id="starRating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="star-input" data-rating="{{ $i }}" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="ratingValue" value="5" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Your Review</label>
                                    <textarea name="comment" class="form-textarea" placeholder="Share your thoughts about this course..." required>{{ old('comment') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="login-prompt">
                        <p>Please log in to leave a review</p>
                        <a href="{{ route('client.login') }}" class="btn btn-outline">Login to Review</a>
                    </div>
                @endauth
                
                <!-- Reviews List -->
                <!-- Reviews List -->
<div class="reviews-list">
    @forelse($reviews ?? [] as $review)
        <div class="review-item" id="review-{{ $review->id }}">
            <div class="review-header">
                <div class="reviewer-info">
                    <div class="reviewer-avatar">
                        {{ strtoupper(substr($review->client->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="reviewer-details">
                        <h4 class="reviewer-name">{{ $review->client->name ?? 'Anonymous' }}</h4>
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="star {{ $i <= ($review->rating ?? 0) ? 'filled' : 'empty' }}" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                
                @auth('client')
                    @if($review->client_id === auth('client')->id())
                        <div class="review-actions">
                            <button onclick="editReview({{ $review->id }})" class="btn btn-secondary btn-icon" title="Edit Review">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form action="{{ route('course.reviews.destroy', [$course->id, $review->id]) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-icon" style="color: var(--error-600); border-color: var(--error-300);" title="Delete Review">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
            
            <!-- Review Content -->
            <div class="review-content-{{ $review->id }}">
                <p class="review-content">{{ $review->comment }}</p>
            </div>
            
            <!-- Edit Form (Hidden by default) -->
            @auth('client')
                @if($review->client_id === auth('client')->id())
                    <div class="edit-form" id="edit-form-{{ $review->id }}">
                        <form action="{{ route('course.reviews.update', [$course->id, $review->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label class="form-label">Update Your Rating</label>
                                <div class="edit-star-rating" id="edit-star-rating-{{ $review->id }}">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="star-input {{ $i <= ($review->rating ?? 0) ? 'selected' : '' }}" 
                                             data-rating="{{ $i }}" 
                                             data-review-id="{{ $review->id }}"
                                             viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="edit-rating-value-{{ $review->id }}" value="{{ $review->rating ?? 5 }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Update Your Review</label>
                                <textarea name="comment" class="form-textarea" required>{{ $review->comment }}</textarea>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Update Review
                                </button>
                                <button type="button" onclick="cancelEdit({{ $review->id }})" class="btn btn-secondary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    @empty
        <div class="no-reviews">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h3>No reviews yet</h3>
            <p>Be the first to share your experience with this course!</p>
        </div>
    @endforelse
</div>
            </section>
        </div>
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-card">
                <h3 class="sidebar-title">Course Information</h3>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Price</span>
                            <span class="info-value">${{ number_format($course->price ?? 0, 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Downloads</span>
                            <span class="info-value">{{ $course->downloads_count ?? '1,247' }}</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">{{ $course->updated_at ? $course->updated_at->format('M d, Y') : 'Dec 15, 2024' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<!-- Notification Container -->
<div id="notificationContainer" class="notification-container"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/course-detail.js') }}"></script>
@endsection