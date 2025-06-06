document.addEventListener('DOMContentLoaded', function() {
    // Star Rating System
    function initializeStarRating(containerId, inputId, initialRating = 5) {
        const container = document.getElementById(containerId);
        const input = document.getElementById(inputId);
        
        if (!container || !input) return;
        
        const stars = container.querySelectorAll('.star');
        let currentRating = initialRating;
        
        // Set initial rating
        updateStars(stars, currentRating);
        input.value = currentRating;
        
        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                currentRating = index + 1;
                updateStars(stars, currentRating);
                input.value = currentRating;
            });
            
            star.addEventListener('mouseenter', () => {
                updateStars(stars, index + 1);
            });
        });
        
        container.addEventListener('mouseleave', () => {
            updateStars(stars, currentRating);
        });
    }
    
    function updateStars(stars, rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('empty');
                star.classList.add('filled');
            } else {
                star.classList.remove('filled');
                star.classList.add('empty');
            }
        });
    }
    
    // Initialize main rating input
    initializeStarRating('rating-input', 'rating-value', 5);
    
    // Initialize edit rating inputs
    document.querySelectorAll('[id^="edit-rating-"]').forEach(container => {
        const reviewId = container.id.split('-')[2];
        const inputId = `edit-rating-value-${reviewId}`;
        const currentRating = parseInt(document.getElementById(inputId)?.value || 5);
        initializeStarRating(container.id, inputId, currentRating);
    });
    
    // Advanced Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0) scale(1)';
            }
        });
    }, observerOptions);
    
    // Observe cards for animation
    document.querySelectorAll('.card').forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(40px)';
        el.style.transition = `opacity 0.6s ease-out ${index * 0.1}s, transform 0.6s ease-out ${index * 0.1}s`;
        observer.observe(el);
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Add scroll effect to action bar
    const actionBar = document.querySelector('.action-bar');
    if (actionBar) {
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                actionBar.style.transform = 'translateY(-100%)';
            } else {
                actionBar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        });
    }
    
    // Progress bar animations
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBars = entry.target.querySelectorAll('.progress-bar');
                progressBars.forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 200);
                });
            }
        });
    }, { threshold: 0.3 });
    
    document.querySelectorAll('.card').forEach(card => {
        progressObserver.observe(card);
    });
    
    // Enhanced hover effects
    document.querySelectorAll('.hover-lift').forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Form validation
    const reviewForm = document.querySelector('form[action*="reviews"]');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const rating = document.getElementById('rating-value').value;
            const comment = document.querySelector('textarea[name="comment"]').value.trim();
            
            if (!rating || rating < 1 || rating > 5) {
                e.preventDefault();
                alert('Please select a rating between 1 and 5 stars.');
                return;
            }
            
            if (!comment || comment.length < 10) {
                e.preventDefault();
                alert('Please write a comment with at least 10 characters.');
                return;
            }
        });
    }
    
    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Edit Review Functions
function editReview(reviewId) {
    const contentDiv = document.querySelector(`.review-content-${reviewId}`);
    const editDiv = document.querySelector(`.edit-form-${reviewId}`);
    
    if (contentDiv && editDiv) {
        contentDiv.classList.add('hidden');
        editDiv.classList.remove('hidden');
        
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
        contentDiv.classList.remove('hidden');
        editDiv.classList.add('hidden');
    }
}

// Utility function to show notifications
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} fixed top-4 right-4 z-50 max-w-sm`;
    notification.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${type === 'success' ? 
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
            }
        </svg>
        ${message}
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}