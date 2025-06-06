@extends('layouts.client')

@section('title', 'Shopping Cart')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')
<div class="cart-page">
    <!-- Hero Section -->
    <div class="cart-hero">
        <div class="hero-content">
            <div class="hero-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                </svg>
            </div>
            <h1 class="hero-title">Your Learning Cart</h1>
            <p class="hero-subtitle">{{ $cartCount }} {{ $cartCount === 1 ? 'course' : 'courses' }} ready for checkout</p>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number">{{ $cartCount }}</span>
                <span class="stat-label">Courses</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-number">${{ number_format($cartTotal, 0) }}</span>
                <span class="stat-label">Total Value</span>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <div class="alert-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="alert-content">
                <h4>Success!</h4>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <div class="alert-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div class="alert-content">
                <h4>Error!</h4>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="cart-container">
        @if($cartItems->isEmpty())
            <!-- Empty Cart State -->
            <div class="empty-state">
                <div class="empty-illustration">
                    <div class="empty-circle">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="empty-title">Your cart is waiting</h2>
                <p class="empty-description">Discover our premium courses and start your learning journey today. Invest in your future with world-class education.</p>
                <div class="empty-actions">
                    <a href="{{ route('client.courses') }}" class="btn btn-primary btn-large">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Explore Courses
                    </a>
                    <a href="{{ route('client.dashboard') }}" class="btn btn-ghost">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        @else
            <!-- Cart Content -->
            <div class="cart-layout">
                <!-- Cart Items -->
                <div class="cart-items-section">
                    <div class="section-header">
                        <h2>Course Selection</h2>
                        <span class="item-count">{{ $cartCount }} items</span>
                    </div>
                    
                    <div class="cart-items">
                        @foreach($cartItems as $index => $item)
                            <div class="cart-item" data-course-id="{{ $item->course->id }}" style="animation-delay: {{ $index * 0.1 }}s">
                                <div class="item-media">
                                    @if($item->course->cover_image && file_exists(public_path($item->course->cover_image)))
                                        <img src="{{ asset($item->course->cover_image) }}" alt="{{ $item->course->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-center relative z-10">
                                            <svg class="w-20 h-20 text-white/90 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                            </svg>
                                            <div class="text-white/80 font-mono text-lg font-bold">{{ strtoupper(substr($item->course->title, 0, 3)) }}</div>
                                        </div>
                                    @endif
                                    
                                    @if(in_array($item->course->id, $purchasedCourseIds))
                                        <div class="ownership-badge">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Owned
                                        </div>
                                    @endif
                                </div>

                                <div class="item-content">
                                    <div class="item-header">
                                        <h3 class="item-title">{{ $item->course->title }}</h3>
                                        @if($item->course->category)
                                            <span class="item-category">{{ $item->course->category->name }}</span>
                                        @endif
                                    </div>
                                    
                                    <p class="item-description">{{ Str::limit($item->course->description, 120) }}</p>
                                    
                                    <div class="item-meta">
                                        <div class="meta-item">
                                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Lifetime Access</span>
                                        </div>
                                        <div class="meta-item">
                                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Certificate</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-actions">
                                    <div class="price-section">
                                        <div class="current-price">${{ number_format($item->price, 2) }}</div>
                                        <div class="price-label">Course Price</div>
                                    </div>
                                    
                                    <div class="action-buttons">
                                        <button class="btn-icon-only btn-remove" data-course-id="{{ $item->course->id }}" title="Remove from cart">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="cart-summary-section">
                    <div class="summary-card">
                        <div class="summary-header">
                            <h3>Order Summary</h3>
                            <div class="summary-badge">{{ $cartCount }} courses</div>
                        </div>
                        
                        <div class="summary-body">
                            <div class="summary-line">
                                <span class="line-label">Subtotal</span>
                                <span class="line-value cart-subtotal">${{ number_format($cartTotal, 2) }}</span>
                            </div>
                            
                            <div class="summary-line">
                                <span class="line-label">Platform Fee</span>
                                <span class="line-value">$0.00</span>
                            </div>
                            
                            <div class="summary-line discount">
                                <span class="line-label">
                                    <svg class="discount-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Student Discount
                                </span>
                                <span class="line-value">-$0.00</span>
                            </div>
                            
                            <div class="summary-divider"></div>
                            
                            <div class="summary-total">
                                <span class="total-label">Total</span>
                                <span class="total-value cart-total">${{ number_format($cartTotal, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="summary-actions">
                            <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-large btn-checkout">
                                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Secure Checkout
                            </a>
                            
                            <div class="secondary-actions">
                                <a href="{{ route('client.courses') }}" class="btn btn-ghost">
                                    <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Continue Shopping
                                </a>
                                
                                <form action="{{ route('cart.clear') }}" method="POST" class="clear-form" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost btn-danger">
                                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Clear Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="security-info">
                            <div class="security-item">
                                <svg class="security-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <span>Secure Payment</span>
                            </div>
                            <div class="security-item">
                                <svg class="security-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>30-Day Guarantee</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove item from cart with enhanced animation
    document.querySelectorAll('.btn-remove').forEach(button => {
        button.addEventListener('click', function() {
            const courseId = this.dataset.courseId;
            const cartItem = this.closest('.cart-item');
            
            if (confirm('Remove this course from your cart?')) {
                // Add removing state
                cartItem.classList.add('removing');
                
                fetch(`/cart/remove/${courseId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cartItem.style.animation = 'slideOutLeft 0.4s ease-out forwards';
                        setTimeout(() => {
                            cartItem.remove();
                            updateCartDisplay(data);
                            
                            if (document.querySelectorAll('.cart-item').length === 0) {
                                location.reload();
                            }
                        }, 400);
                        
                        showNotification(data.message, 'success');
                    } else {
                        cartItem.classList.remove('removing');
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    cartItem.classList.remove('removing');
                    console.error('Error:', error);
                    showNotification('An error occurred', 'error');
                });
            }
        });
    });

    function updateCartDisplay(data) {
        if (data.cartCount !== undefined) {
            const heroSubtitle = document.querySelector('.hero-subtitle');
            if (heroSubtitle) {
                heroSubtitle.textContent = `${data.cartCount} ${data.cartCount === 1 ? 'course' : 'courses'} ready for checkout`;
            }
            
            const itemCount = document.querySelector('.item-count');
            if (itemCount) {
                itemCount.textContent = `${data.cartCount} items`;
            }
        }
        
        if (data.cartTotal !== undefined) {
            document.querySelector('.cart-total').textContent = '$' + data.cartTotal;
            document.querySelector('.cart-subtotal').textContent = '$' + data.cartTotal;
            
            const heroStatNumber = document.querySelector('.stat-number:last-child');
            if (heroStatNumber) {
                heroStatNumber.textContent = '$' + Math.round(data.cartTotal);
            }
        }
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"></path>
                </svg>
            </div>
            <div class="notification-content">
                <h4>${type === 'success' ? 'Success!' : 'Error!'}</h4>
                <p>${message}</p>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 100);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }
});
</script>
@endsection