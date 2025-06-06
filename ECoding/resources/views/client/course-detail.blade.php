@extends('layouts.client')

@section('title', $course->title)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/course-detail.css') }}">
@endsection

@section('content')
<div class="course-container">
    <!-- Hero Section with Random Background -->
    <section class="hero-section random-bg-1" id="heroSection">
        <!-- Animated Background Particles -->
        <div class="bg-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
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
                
                @php
                    // Initialize variables
                    $hasPurchased = false;
                    $isInCart = false;
                    $purchaseDetails = null;
                    
                    if (auth('client')->check()) {
                        $clientId = auth('client')->id();
                        $courseId = $course->id;
                        
                        // Debug: Get all purchases for this client
                        $allPurchases = \App\Models\Purchase::where('client_id', $clientId)->get();
                        
                        // Check if user has purchased THIS SPECIFIC course
                        $purchaseDetails = \App\Models\Purchase::where('client_id', $clientId)
                            ->where('course_id', $courseId)
                            ->where('status', 'completed')
                            ->first();
                            
                        $hasPurchased = $purchaseDetails !== null;
                        
                        // Check if course is in cart (if you have cart functionality)
                        if (class_exists('\App\Models\Cart')) {
                            $isInCart = \App\Models\Cart::where('client_id', $clientId)
                                ->where('course_id', $courseId)
                                ->exists();
                        }
                    }
                @endphp
                
               
                
                <!-- Action Buttons -->
                <div class="course-actions" style="margin-bottom: 1.5rem;">
                    @if(!auth('client')->check())
                        <!-- User not logged in -->
                        <a href="{{ route('client.login') }}" class="login-btn interactive">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login to Purchase
                        </a>
                    @elseif($hasPurchased)
                        <!-- User has purchased THIS SPECIFIC course - show download button -->
                        <div class="purchased-course-info" style="background: #d1fae5; border: 1px solid #10b981; border-radius: 0.5rem; padding: 1rem; margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; color: #065f46; font-weight: 600; margin-bottom: 0.5rem;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Course Purchased Successfully!
                            </div>
                            @if($purchaseDetails)
                                <p style="color: #047857; font-size: 0.875rem; margin: 0;">
                                    Purchased on {{ $purchaseDetails->created_at->format('M d, Y \a\t H:i') }}
                                </p>
                            @endif
                        </div>
                        
                        @if($course->pdf_file_path)
                            <a href="{{ route('client.download-course', $course->id) }}" class="download-btn interactive" id="downloadBtn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 8h8a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Download Course
                            </a>
                        @else
                            <div class="alert alert-info">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Course content will be available soon.
                            </div>
                        @endif
                    @else
                        <!-- User hasn't purchased THIS course - show buy buttons -->
                        <div class="purchase-options">
                            <!-- Direct Purchase Button -->
                            <a href="{{ route('payment.checkout', $course->id) }}" class="buy-btn interactive" id="buyBtn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Buy Now - ${{ number_format($course->price ?? 99, 2) }}
                            </a>
                            
                            <!-- Add to Cart Button (if cart functionality exists) -->
                            @if(class_exists('\App\Models\Cart'))
                                @if($isInCart)
                                    <a href="{{ route('cart.index') }}" class="cart-btn interactive">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        In Cart - View Cart
                                    </a>
                                @else
                                    <button onclick="addToCart({{ $course->id }})" class="add-cart-btn interactive">
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
});

// Add to cart function
function addToCart(courseId) {
    const button = event.target;
    const originalHTML = button.innerHTML;
    
    // Show loading state
    button.innerHTML = `
        <svg class="w-5 h-5" style="animation: spin 1s linear infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
        Adding to cart...
    `;
    button.disabled = true;
    
    fetch(`/cart/add/${courseId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            
            // Update button to show "In Cart"
            button.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                In Cart - View Cart
            `;
            button.onclick = () => window.location.href = '/cart';
            
            // Update cart count if element exists
            updateCartCount(data.cartCount);
        } else {
            showNotification(data.message, 'error');
            button.innerHTML = originalHTML;
            button.disabled = false;
            
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while adding to cart', 'error');
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count-badge');
    cartCountElements.forEach(element => {
        element.textContent = count;
        element.style.display = count > 0 ? 'block' : 'none';
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
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('.animate-fade-in').forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(40px)';
        el.style.transition = `opacity 0.8s ease-out ${index * 0.2}s, transform 0.8s ease-out ${index * 0.2}s`;
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

// Enhanced button interactions
document.addEventListener('click', function(e) {
    // Buy button
    if (e.target.matches('#buyBtn') || e.target.closest('#buyBtn')) {
        const btn = e.target.matches('#buyBtn') ? e.target : e.target.closest('#buyBtn');
        const originalHTML = btn.innerHTML;
        
        btn.innerHTML = `
            <svg class="w-5 h-5" style="animation: spin 1s linear infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Redirecting to checkout...
        `;
        
        btn.style.pointerEvents = 'none';
        
        // Allow the redirect to proceed after showing loading state
        setTimeout(() => {
            window.location.href = btn.href;
        }, 500);
        
        return false; // Prevent immediate redirect
    }
    
    // Download button
    if (e.target.matches('#downloadBtn') || e.target.closest('#downloadBtn')) {
        const btn = e.target.matches('#downloadBtn') ? e.target : e.target.closest('#downloadBtn');
        const originalHTML = btn.innerHTML;
        
        btn.innerHTML = `
            <svg class="w-5 h-5" style="animation: spin 1s linear infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Downloading...
        `;
        
        btn.style.pointerEvents = 'none';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.pointerEvents = 'auto';
            showNotification('Download started successfully!', 'success');
        }, 2000);
    }
});

// Notification system
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    notification.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        ${message}
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 4000);
}
</script>
@endsection