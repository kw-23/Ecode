// Course Details JavaScript Functionality

document.addEventListener('DOMContentLoaded', function() {
    initializeStarRating();
    initializeAnimations();
    initializeNotifications();
    initializeInteractiveElements();
    initializeProgressBars();
    autoHideAlerts();
});

// Star Rating System
function initializeStarRating() {
    const starRating = document.getElementById('starRating');
    if (!starRating) return;
    
    const stars = starRating.querySelectorAll('.star-input');
    const ratingValue = document.getElementById('ratingValue');
    let selectedRating = 5;
    
    function updateStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('active');
                star.style.fill = 'var(--warning-400)';
                star.style.stroke = 'var(--warning-500)';
            } else {
                star.classList.remove('active');
                star.style.fill = 'var(--gray-200)';
                star.style.stroke = 'var(--gray-300)';
            }
        });
    }
    
    stars.forEach((star, index) => {
        star.addEventListener('mouseenter', () => updateStars(index + 1));
        star.addEventListener('mouseleave', () => updateStars(selectedRating));
        star.addEventListener('click', () => {
            selectedRating = index + 1;
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

// Animation System
function initializeAnimations() {
    // Intersection Observer for scroll animations
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
    
    // Observe animated elements
    document.querySelectorAll('.content-section, .objective-card, .review-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(40px)';
        el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(el);
    });
    
    // Parallax effect for hero section
    window.addEventListener('scroll', throttle(() => {
        const scrolled = window.pageYOffset;
        const heroSection = document.querySelector('.hero-section');
        
        if (heroSection) {
            const rate = scrolled * -0.2;
            heroSection.style.transform = `translateY(${rate}px)`;
        }
        
        // Floating elements parallax
        document.querySelectorAll('.floating-element').forEach((element, index) => {
            const rate = scrolled * (0.1 + index * 0.05);
            element.style.transform = `translateY(${rate}px) rotate(${rate * 0.1}deg)`;
        });
    }, 16));
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
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Add hover effects to cards
    document.querySelectorAll('.objective-card, .review-item, .info-item').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
}

// Notification System
function initializeNotifications() {
    // Create notification container if it doesn't exist
    if (!document.getElementById('notificationContainer')) {
        const container = document.createElement('div');
        container.id = 'notificationContainer';
        container.className = 'notification-container';
        document.body.appendChild(container);
    }
}

function showNotification(message, type = 'info', title = '') {
    const container = document.getElementById('notificationContainer');
    if (!container) return;
    
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    const icons = {
        success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
        error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
        info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>'
    };
    
    notification.innerHTML = `
        <svg class="notification-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            ${icons[type] || icons.info}
        </svg>
        <div class="notification-content">
            ${title ? `<div class="notification-title">${title}</div>` : ''}
            <div class="notification-message">${message}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    
    container.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    }, 5000);
}

// Course Enrollment Function
function enrollInCourse(courseId) {
    const button = document.getElementById('enrollBtn');
    if (!button) return;
    
    const originalHTML = button.innerHTML;
    
    // Show loading state
    button.innerHTML = `
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Processing...
    `;
    button.disabled = true;
    button.classList.add('loading');
    
    // Simulate enrollment process
    fetch(`/courses/${courseId}/enroll`, {
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
            showNotification(data.message || 'Successfully enrolled in course!', 'success', 'Enrollment Complete');
            
            // Redirect to payment or course page
            setTimeout(() => {
                window.location.href = data.redirect || `/courses/${courseId}`;
            }, 1500);
        } else {
            throw new Error(data.message || 'Failed to enroll in course');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'An error occurred during enrollment', 'error', 'Enrollment Failed');
        button.innerHTML = originalHTML;
        button.disabled = false;
        button.classList.remove('loading');
    });
}

// Add to Cart Function
function addToCart(courseId) {
    const button = document.getElementById('cartBtn');
    if (!button) return;
    
    const originalHTML = button.innerHTML;
    
    // Show loading state
    button.innerHTML = `
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Adding...
    `;
    button.disabled = true;
    button.classList.add('loading');
    
    fetch(`/cart/add/${courseId}`, {
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
            showNotification(data.message || 'Course added to cart successfully!', 'success', 'Added to Cart');
            
            // Update button to show "In Cart"
            button.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                In Cart
            `;
            button.onclick = () => window.location.href = '/cart';
            
            // Update cart count if element exists
            updateCartCount(data.cartCount || 0);
        } else {
            throw new Error(data.message || 'Failed to add course to cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'An error occurred while adding to cart', 'error', 'Cart Error');
        button.innerHTML = originalHTML;
        button.disabled = false;
        button.classList.remove('loading');
    });
}

// Update Cart Count
function updateCartCount(count) {
    document.querySelectorAll('.cart-count').forEach(element => {
        element.textContent = count;
        element.style.display = count > 0 ? 'inline' : 'none';
    });
}

// Auto-hide Alerts
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

// Form Validation
document.addEventListener('submit', function(e) {
    if (e.target.matches('#reviewForm')) {
        const rating = e.target.querySelector('#ratingValue').value;
        const comment = e.target.querySelector('textarea[name="comment"]').value.trim();
        
        if (!rating || rating < 1 || rating > 5) {
            e.preventDefault();
            showNotification('Please select a rating between 1 and 5 stars.', 'error', 'Invalid Rating');
            return;
        }
        
        if (!comment || comment.length < 10) {
            e.preventDefault();
            showNotification('Please write a comment with at least 10 characters.', 'error', 'Comment Too Short');
            return;
        }
        
        // Add loading state to submit button
        const submitBtn = e.target.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        }
    }
});

// Utility Functions
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

// Keyboard Navigation
document.addEventListener('keydown', function(e) {
    // ESC key to close notifications
    if (e.key === 'Escape') {
        document.querySelectorAll('.notification').forEach(notification => {
            notification.remove();
        });
    }
    
    // Enter key on star rating
    if (e.key === 'Enter' && e.target.matches('.star-input')) {
        e.target.click();
    }
});

// Accessibility Improvements
document.addEventListener('focus', function(e) {
    if (e.target.matches('.star-input')) {
        e.target.style.outline = '2px solid var(--primary-500)';
        e.target.style.outlineOffset = '2px';
    }
}, true);

document.addEventListener('blur', function(e) {
    if (e.target.matches('.star-input')) {
        e.target.style.outline = '';
        e.target.style.outlineOffset = '';
    }
}, true);

// CSS Animation Keyframes (added via JavaScript for dynamic control)
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Performance Monitoring
if ('performance' in window) {
    window.addEventListener('load', function() {
        setTimeout(function() {
            const perfData = performance.getEntriesByType('navigation')[0];
            if (perfData.loadEventEnd - perfData.loadEventStart > 3000) {
                console.warn('Page load time is slow:', perfData.loadEventEnd - perfData.loadEventStart, 'ms');
            }
        }, 0);
    });
}

// Error Handling
window.addEventListener('error', function(e) {
    console.error('JavaScript error:', e.error);
    showNotification('An unexpected error occurred. Please refresh the page.', 'error', 'System Error');
});

// Service Worker Registration (if available)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('ServiceWorker registration successful');
            })
            .catch(function(err) {
                console.log('ServiceWorker registration failed');
            });
    });
}
// Edit Review Function (to be called from HTML)
function editReview(reviewId) {
    // Hide review content and show edit form
    const reviewContent = document.querySelector(`.review-content-${reviewId}`);
    const editForm = document.getElementById(`edit-form-${reviewId}`);
    if (reviewContent && editForm) {
        reviewContent.style.display = 'none';
        editForm.style.display = 'block';

        // Initialize star rating for the edit form
        const starContainer = document.getElementById(`edit-star-rating-${reviewId}`);
        const stars = starContainer ? starContainer.querySelectorAll('.star-input') : [];
        const ratingInput = document.getElementById(`edit-rating-value-${reviewId}`);
        let selectedRating = parseInt(ratingInput.value, 10) || 5;

        function updateStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('selected');
                    star.style.fill = 'var(--warning-400)';
                    star.style.stroke = 'var(--warning-500)';
                } else {
                    star.classList.remove('selected');
                    star.style.fill = 'var(--gray-200)';
                    star.style.stroke = 'var(--gray-300)';
                }
            });
        }

        // Remove previous listeners by replacing each star with a clone
        stars.forEach((star, index) => {
            const clone = star.cloneNode(true);
            star.parentNode.replaceChild(clone, star);
        });

        // Re-query stars after cloning
        const freshStars = starContainer ? starContainer.querySelectorAll('.star-input') : [];
        function updateStarsEdit(rating) {
            freshStars.forEach((star, idx) => {
                if (idx < rating) {
                    star.classList.add('active');
                    star.classList.remove('selected');
                    star.style.fill = 'var(--warning-400)';
                    star.style.stroke = 'var(--warning-500)';
                } else {
                    star.classList.remove('active');
                    star.classList.remove('selected');
                    star.style.fill = 'var(--gray-200)';
                    star.style.stroke = 'var(--gray-300)';

                                // Remove focus outline (blue square) if present
                                star.style.outline = 'none';
                                star.style.outlineOffset = '';
                }
            });
        }
        freshStars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => updateStarsEdit(index + 1));
            star.addEventListener('mouseleave', () => updateStarsEdit(selectedRating));
            star.addEventListener('click', () => {
                selectedRating = index + 1;
                ratingInput.value = selectedRating;
                updateStarsEdit(selectedRating);

                // Click animation
                star.style.transform = 'scale(1.3) rotate(10deg)';
                setTimeout(() => {
                    star.style.transform = '';
                }, 200);
            });
            // Keyboard accessibility
            star.tabIndex = 0;
            star.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    star.click();
                }
            });
        });

        updateStarsEdit(selectedRating);
    }
}

// Cancel Edit Function (to be called from HTML)
function cancelEdit(reviewId) {
    // Show review content and hide edit form
    const reviewContent = document.querySelector(`.review-content-${reviewId}`);
    const editForm = document.getElementById(`edit-form-${reviewId}`);
    if (reviewContent && editForm) {
        reviewContent.style.display = '';
        editForm.style.display = 'none';
    }
}