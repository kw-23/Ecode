@extends('layouts.client')

@section('title', 'Change Password')

@section('styles')
<style>
    /* Modern Design System */
    :root {
        --primary: #667eea;
        --primary-dark: #5a67d8;
        --secondary: #764ba2;
        --accent: #f093fb;
        --success: #10b981;
        --warning: #f59e0b;
        --error: #ef4444;
        --info: #06b6d4;
        --dark: #1e293b;
        --light: #f8fafc;
        --gray: #64748b;
        --gray-light: #e2e8f0;
        --gray-dark: #334155;
    }

    /* Glass Effects */
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Hero Section */
    .password-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        position: relative;
        overflow: hidden;
        min-height: 40vh;
        display: flex;
        align-items: center;
        border-radius: 0 0 3rem 3rem;
    }

    .password-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    .password-hero::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -20%;
        width: 80%;
        height: 150%;
        background: radial-gradient(circle, rgba(240, 147, 251, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    /* Cards */
    .password-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 2rem;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .password-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* Form Inputs */
    .form-input {
        background: white;
        border: 2px solid var(--gray-light);
        border-radius: 1.25rem;
        padding: 1rem 1.25rem;
        color: var(--dark);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
        font-size: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .form-input:invalid {
        border-color: var(--error);
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    /* Password Input Container */
    .password-input-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--gray);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .password-toggle:hover {
        color: var(--primary);
        background: rgba(102, 126, 234, 0.1);
    }

    /* Form Labels */
    .form-label {
        display: block;
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-dark);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 1rem 2rem;
        border-radius: 1.25rem;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-outline {
        background: white;
        border: 2px solid var(--gray-light);
        color: var(--dark);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .btn-outline:hover {
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Error Messages */
    .error-message {
        color: var(--error);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Success Messages */
    .success-message {
        background: linear-gradient(135deg, var(--success), #16a34a);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 1.25rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
    }

    /* Section Headers */
    .section-title {
        font-size: 2.5rem;
        font-weight: 900;
        color: white;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, white, rgba(240, 147, 251, 0.8));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .section-subtitle {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.9);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .card-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .gradient-text {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Password Strength Indicator */
    .password-strength {
        margin-top: 1rem;
        padding: 1rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(240, 147, 251, 0.05));
        border-radius: 1rem;
        border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .strength-bar {
        height: 6px;
        border-radius: 3px;
        background: var(--gray-light);
        overflow: hidden;
        margin: 0.5rem 0;
    }

    .strength-fill {
        height: 100%;
        border-radius: 3px;
        transition: all 0.3s ease;
        width: 0%;
    }

    .strength-weak .strength-fill {
        background: var(--error);
        width: 25%;
    }

    .strength-fair .strength-fill {
        background: var(--warning);
        width: 50%;
    }

    .strength-good .strength-fill {
        background: var(--info);
        width: 75%;
    }

    .strength-strong .strength-fill {
        background: var(--success);
        width: 100%;
    }

    /* Security Tips */
    .security-tips {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(6, 182, 212, 0.05));
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 1.5rem;
        padding: 2rem;
        margin-top: 2rem;
    }

    .tip-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .tip-item:last-child {
        margin-bottom: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .password-hero {
            min-height: 30vh;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .card-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Password Hero -->
    

    <div class="w-full px-6 lg:px-12 py-12">
        <div class="max-w-4xl mx-auto">
            @if(session('success'))
                <div class="success-message">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Change Password Card -->
            <div class="password-card p-8">
                <h2 class="card-title">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 via-pink-500 to-purple-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <span class="gradient-text">Update Password</span>
                </h2>
                
                <form action="{{ route('client.password.update') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-8">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Current Password
                            </label>
                            <div class="password-input-container">
                                <input id="current_password" type="password" name="current_password" required class="form-input pr-12">
                                <button type="button" class="password-toggle" onclick="togglePassword('current_password')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="error-message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                New Password
                            </label>
                            <div class="password-input-container">
                                <input id="password" type="password" name="password" required class="form-input pr-12" onkeyup="checkPasswordStrength(this.value)">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Password Strength Indicator -->
                            <div class="password-strength" id="passwordStrength" style="display: none;">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Password Strength:</span>
                                    <span class="text-sm font-semibold" id="strengthText">Weak</span>
                                </div>
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                            </div>
                            
                            @error('password')
                                <p class="error-message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Confirm New Password
                            </label>
                            <div class="password-input-container">
                                <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input pr-12">
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between gap-4 mt-8">
                        <a href="{{ route('client.profile') }}" class="btn btn-outline">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Profile
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Update Password
                        </button>
                    </div>
                </form>

                <!-- Security Tips -->
                <div class="security-tips">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="gradient-text">Password Security Tips</span>
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="tip-item">
                            <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-medium">Use at least 8 characters with a mix of letters, numbers, and symbols</p>
                        </div>
                        
                        <div class="tip-item">
                            <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-medium">Avoid using personal information like names, birthdays, or addresses</p>
                        </div>
                        
                        <div class="tip-item">
                            <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-medium">Don't reuse passwords from other accounts</p>
                        </div>
                        
                        <div class="tip-item">
                            <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-medium">Consider using a password manager to generate and store strong passwords</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling;
        const icon = button.querySelector('svg');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
            `;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            `;
        }
    }
    
    function checkPasswordStrength(password) {
        const strengthIndicator = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('strengthText');
        const strengthFill = document.getElementById('strengthFill');
        
        if (password.length === 0) {
            strengthIndicator.style.display = 'none';
            return;
        }
        
        strengthIndicator.style.display = 'block';
        
        let score = 0;
        let feedback = '';
        
        // Length check
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        
        // Character variety checks
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        
        // Remove previous strength classes
        strengthIndicator.className = 'password-strength';
        
        if (score < 3) {
            strengthIndicator.classList.add('strength-weak');
            strengthText.textContent = 'Weak';
            strengthText.style.color = 'var(--error)';
        } else if (score < 4) {
            strengthIndicator.classList.add('strength-fair');
            strengthText.textContent = 'Fair';
            strengthText.style.color = 'var(--warning)';
        } else if (score < 5) {
            strengthIndicator.classList.add('strength-good');
            strengthText.textContent = 'Good';
            strengthText.style.color = 'var(--info)';
        } else {
            strengthIndicator.classList.add('strength-strong');
            strengthText.textContent = 'Strong';
            strengthText.style.color = 'var(--success)';
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation feedback
        const inputs = document.querySelectorAll('.form-input');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.style.borderColor = 'var(--error)';
                } else {
                    this.style.borderColor = 'var(--success)';
                }
            });
            
            input.addEventListener('focus', function() {
                this.style.borderColor = 'var(--primary)';
            });
        });
        
        // Password confirmation validation
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        
        function validatePasswordMatch() {
            if (confirmInput.value && passwordInput.value !== confirmInput.value) {
                confirmInput.style.borderColor = 'var(--error)';
            } else if (confirmInput.value) {
                confirmInput.style.borderColor = 'var(--success)';
            }
        }
        
        passwordInput.addEventListener('input', validatePasswordMatch);
        confirmInput.addEventListener('input', validatePasswordMatch);
        
        // Success message auto-hide
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                successMessage.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    successMessage.remove();
                }, 300);
            }, 5000);
        }
    });
</script>
@endsection