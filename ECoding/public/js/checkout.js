// Professional Checkout JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializeCheckout();
});

function initializeCheckout() {
    // Initialize Stripe
    const stripe = Stripe(getStripeKey());
    const elements = stripe.elements({
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#2563eb',
                colorBackground: '#ffffff',
                colorText: '#111827',
                colorDanger: '#dc2626',
                fontFamily: 'Inter, system-ui, sans-serif',
                borderRadius: '0px',
                spacingUnit: '4px',
                fontSizeBase: '14px',
            },
            rules: {
                '.Input': {
                    border: '2px solid #e5e7eb',
                    padding: '16px',
                    transition: 'border-color 0.3s ease',
                },
                '.Input:focus': {
                    border: '2px solid #2563eb',
                    boxShadow: '0 0 0 3px rgba(37, 99, 235, 0.1)',
                },
                '.Input--invalid': {
                    border: '2px solid #dc2626',
                    boxShadow: '0 0 0 3px rgba(220, 38, 38, 0.1)',
                },
            }
        }
    });
    
    // Create card element
    const cardElement = elements.create('card', {
        hidePostalCode: true,
        style: {
            base: {
                fontSize: '14px',
                color: '#111827',
                fontWeight: '500',
                '::placeholder': {
                    color: '#9ca3af',
                    fontWeight: '400',
                },
            },
            invalid: {
                color: '#dc2626',
                iconColor: '#dc2626',
            },
            complete: {
                color: '#059669',
                iconColor: '#059669',
            },
        },
    });
    
    cardElement.mount('#card-element');
    
    // Handle card validation
    cardElement.on('change', function(event) {
        handleCardValidation(event);
    });
    
    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        handleFormSubmission(event, stripe, cardElement);
    });
    
    // Initialize form enhancements
    initializeFormEnhancements();
    
    // Initialize animations
    initializeAnimations();
    
    // Handle image loading errors
    handleImageErrors();
}

function getStripeKey() {
    // Get Stripe key from Laravel config
    const metaTag = document.querySelector('meta[name="stripe-key"]');
    if (metaTag) {
        return metaTag.getAttribute('content');
    }
    
    // Fallback - you should set this in your Laravel config
    return window.stripeKey || 'pk_test_your_stripe_key_here';
}

function handleCardValidation(event) {
    const cardContainer = document.querySelector('.card-input-container');
    const cardErrors = document.getElementById('card-errors');
    
    // Remove previous states
    cardContainer.classList.remove('error', 'success');
    
    if (event.error) {
        // Show error state
        cardContainer.classList.add('error');
        cardErrors.textContent = event.error.message;
        showFieldError(cardErrors, event.error.message);
    } else if (event.complete) {
        // Show success state
        cardContainer.classList.add('success');
        cardErrors.textContent = '';
        hideFieldError(cardErrors);
    } else {
        // Clear errors
        cardErrors.textContent = '';
        hideFieldError(cardErrors);
    }
}

async function handleFormSubmission(event, stripe, cardElement) {
    event.preventDefault();
    
    const submitButton = document.getElementById('submit-payment');
    const form = event.target;
    
    // Validate form
    if (!validateForm(form)) {
        return;
    }
    
    // Show loading state
    setLoadingState(submitButton, true);
    
    try {
        // Get form data
        const formData = getFormData(form);
        
        // Create payment method
        const {error: methodError, paymentMethod} = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: formData.name,
                email: formData.email,
            },
        });
        
        if (methodError) {
            throw new Error(methodError.message);
        }
        
        // Process payment
        await processPayment(formData, paymentMethod, stripe);
        
    } catch (error) {
        console.error('Payment error:', error);
        showErrorMessage(error.message || 'An unexpected error occurred. Please try again.');
        setLoadingState(submitButton, false);
    }
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    // Clear previous errors
    clearFormErrors();
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'This field is required');
            isValid = false;
        } else if (field.type === 'email' && !isValidEmail(field.value)) {
            showFieldError(field, 'Please enter a valid email address');
            isValid = false;
        }
    });
    
    return isValid;
}

function getFormData(form) {
    return {
        email: form.querySelector('#email').value.trim(),
        name: form.querySelector('#name').value.trim(),
        amount: parseFloat(form.querySelector('#amount').value),
        checkoutType: form.querySelector('#checkout-type').value,
        courseId: form.querySelector('#course-id')?.value,
    };
}

async function processPayment(formData, paymentMethod, stripe) {
    // Determine endpoint
    let endpoint, requestData;
    
    if (formData.checkoutType === 'single') {
        endpoint = getRoute('payment.process');
        requestData = {
            course_id: formData.courseId,
            amount: formData.amount,
            payment_method: paymentMethod.id,
            email: formData.email,
            name: formData.name
        };
    } else {
        endpoint = getRoute('cart.process-payment');
        requestData = {
            amount: formData.amount,
            payment_method: paymentMethod.id,
            email: formData.email,
            name: formData.name
        };
    }
    
    // Create payment intent
    const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCSRFToken(),
            'Accept': 'application/json',
        },
        body: JSON.stringify(requestData),
    });
    
    if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
    }
    
    const paymentData = await response.json();
    
    if (paymentData.error) {
        throw new Error(paymentData.error.message || 'Payment failed. Please try again.');
    }
    
    // Confirm payment
    const {error: confirmError, paymentIntent} = await stripe.confirmCardPayment(
        paymentData.client_secret,
        {
            payment_method: paymentMethod.id
        }
    );
    
    if (confirmError) {
        throw new Error(confirmError.message);
    }
    
    if (paymentIntent.status === 'succeeded') {
        handlePaymentSuccess(paymentIntent, formData.checkoutType, formData.courseId);
    } else {
        throw new Error('Payment was not completed successfully');
    }
}

function handlePaymentSuccess(paymentIntent, checkoutType, courseId) {
    showSuccessMessage('Payment successful! Redirecting...');
    
    // Add success animation
    const container = document.querySelector('.checkout-container');
    container.style.transform = 'scale(1.02)';
    container.style.transition = 'transform 0.3s ease';
    
    setTimeout(() => {
        container.style.transform = 'scale(1)';
    }, 300);
    
    // Redirect after delay
    setTimeout(() => {
        if (checkoutType === 'single') {
            window.location.href = getRoute('payment.success', {course: courseId}) + `?payment_intent=${paymentIntent.id}`;
        } else {
            window.location.href = getRoute('cart.payment-success') + `?payment_intent=${paymentIntent.id}`;
        }
    }, 2000);
}

function initializeFormEnhancements() {
    // Enhanced input focus effects
    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
            if (this.value.trim()) {
                this.parentElement.classList.add('filled');
            } else {
                this.parentElement.classList.remove('filled');
            }
        });
        
        // Check if already filled
        if (input.value.trim()) {
            input.parentElement.classList.add('filled');
        }
    });
    
    // Real-time validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('input', debounce(function() {
            validateEmailField(this);
        }, 300));
    }
    
    const nameInput = document.getElementById('name');
    if (nameInput) {
        nameInput.addEventListener('input', debounce(function() {
            validateNameField(this);
        }, 300));
    }
}

function initializeAnimations() {
    // Stagger animation for course items
    const courseItems = document.querySelectorAll('.course-item');
    courseItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Intersection Observer for scroll animations
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
    
    // Observe elements
    document.querySelectorAll('.price-breakdown, .trust-section, .form-section').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

function handleImageErrors() {
    const images = document.querySelectorAll('.course-image img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            const placeholder = this.parentElement.querySelector('.image-placeholder');
            if (placeholder) {
                this.style.display = 'none';
                placeholder.style.display = 'flex';
            } else {
                // Create placeholder
                const newPlaceholder = document.createElement('div');
                newPlaceholder.className = 'image-placeholder';
                newPlaceholder.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                `;
                this.parentElement.appendChild(newPlaceholder);
                this.style.display = 'none';
            }
        });
    });
}

// Validation Functions
function validateEmailField(field) {
    const container = field.parentElement;
    container.classList.remove('error', 'success');
    
    if (field.value.trim() && isValidEmail(field.value)) {
        container.classList.add('success');
        hideFieldError(field);
    } else if (field.value.trim()) {
        container.classList.add('error');
        showFieldError(field, 'Please enter a valid email address');
    } else {
        hideFieldError(field);
    }
}

function validateNameField(field) {
    const container = field.parentElement;
    container.classList.remove('error', 'success');
    
    if (field.value.trim().length >= 2) {
        container.classList.add('success');
        hideFieldError(field);
    } else if (field.value.trim()) {
        container.classList.add('error');
        showFieldError(field, 'Name must be at least 2 characters');
    } else {
        hideFieldError(field);
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Error Handling Functions
function showFieldError(field, message) {
    let errorElement = field.parentElement.querySelector('.field-error');
    
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'field-error';
        errorElement.style.cssText = `
            color: #dc2626;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        `;
        field.parentElement.appendChild(errorElement);
    }
    
    errorElement.innerHTML = `
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>${message}</span>
    `;
    
    // Add error class to input
    if (field.classList) {
        field.classList.add('error');
    }
}

function hideFieldError(field) {
    const errorElement = field.parentElement.querySelector('.field-error');
    if (errorElement) {
        errorElement.remove();
    }
    
    // Remove error class from input
    if (field.classList) {
        field.classList.remove('error');
    }
}

function clearFormErrors() {
    const errorElements = document.querySelectorAll('.field-error');
    errorElements.forEach(el => el.remove());
    
    const errorInputs = document.querySelectorAll('.form-input.error');
    errorInputs.forEach(input => input.classList.remove('error'));
    
    const errorContainers = document.querySelectorAll('.input-container.error');
    errorContainers.forEach(container => container.classList.remove('error'));
}

function showErrorMessage(message) {
    const messagesDiv = document.getElementById('payment-messages');
    messagesDiv.innerHTML = `
        <div class="message error-message">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>${message}</span>
        </div>
    `;
    
    // Scroll to message
    messagesDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function showSuccessMessage(message) {
    const messagesDiv = document.getElementById('payment-messages');
    messagesDiv.innerHTML = `
        <div class="message success-message">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>${message}</span>
        </div>
    `;
}

// UI State Functions
function setLoadingState(button, isLoading) {
    if (isLoading) {
        button.disabled = true;
        button.classList.add('loading');
    } else {
        button.disabled = false;
        button.classList.remove('loading');
    }
}

// Utility Functions
function getCSRFToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.getAttribute('content') : '';
}

function getRoute(routeName, params = {}) {
    // This should be replaced with your Laravel route helper
    const routes = {
        'payment.process': '/payment/process',
        'cart.process-payment': '/cart/process-payment',
        'payment.success': '/payment/success',
        'cart.payment-success': '/cart/payment-success',
    };
    
    let url = routes[routeName] || '/';
    
    // Replace route parameters
    Object.keys(params).forEach(key => {
        url = url.replace(`{${key}}`, params[key]);
    });
    
    return url;
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Keyboard Navigation
document.addEventListener('keydown', function(e) {
    // ESC to clear messages
    if (e.key === 'Escape') {
        const messages = document.getElementById('payment-messages');
        if (messages) {
            messages.innerHTML = '';
        }
    }
    
    // Enter to submit form (if not in textarea)
    if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-payment');
        
        if (form && submitButton && !submitButton.disabled) {
            e.preventDefault();
            submitButton.click();
        }
    }
});

// Prevent form resubmission on page refresh
window.addEventListener('beforeunload', function(e) {
    const submitButton = document.getElementById('submit-payment');
    if (submitButton && submitButton.classList.contains('loading')) {
        e.preventDefault();
        e.returnValue = 'Your payment is being processed. Are you sure you want to leave?';
        return e.returnValue;
    }
});

// Auto-save form data (optional)
function saveFormData() {
    const formData = {
        email: document.getElementById('email')?.value || '',
        name: document.getElementById('name')?.value || '',
        timestamp: Date.now()
    };
    
    try {
        localStorage.setItem('checkout_form_data', JSON.stringify(formData));
    } catch (e) {
        console.warn('Could not save form data to localStorage:', e);
    }
}

function loadFormData() {
    try {
        const savedData = localStorage.getItem('checkout_form_data');
        if (savedData) {
            const data = JSON.parse(savedData);
            
            // Only load if data is less than 1 hour old
            if (Date.now() - data.timestamp < 3600000) {
                const emailField = document.getElementById('email');
                const nameField = document.getElementById('name');
                
                if (emailField && !emailField.value) {
                    emailField.value = data.email;
                }
                
                if (nameField && !nameField.value) {
                    nameField.value = data.name;
                }
            } else {
                localStorage.removeItem('checkout_form_data');
            }
        }
    } catch (e) {
        console.warn('Could not load form data from localStorage:', e);
    }
}

// Initialize form data loading
document.addEventListener('DOMContentLoaded', function() {
    loadFormData();
    
    // Save form data on input
    const emailField = document.getElementById('email');
    const nameField = document.getElementById('name');
    
    if (emailField) {
        emailField.addEventListener('input', debounce(saveFormData, 1000));
    }
    
    if (nameField) {
        nameField.addEventListener('input', debounce(saveFormData, 1000));
    }
});