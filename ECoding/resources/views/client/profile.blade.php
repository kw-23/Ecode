@extends('layouts.client')

@section('styles')
<style>
/* Enhanced Modern Design System */
:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --secondary: #8b5cf6;
    --accent: #ec4899;
    --success: #10b981;
    --warning: #f59e0b;
    --error: #ef4444;
    --info: #06b6d4;
    --dark: #0f172a;
    --light: #f8fafc;
    --gray: #64748b;
    --gray-light: #e2e8f0;
    --gray-dark: #334155;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* Clean Background */
.profile-background {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

/* Enhanced Cards */
.profile-card {
    background: white;
    border-radius: 2rem;
    overflow: hidden;
    box-shadow: var(--shadow-xl);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(226, 232, 240, 0.8);
    position: relative;
    margin-bottom: 2rem;
    backdrop-filter: blur(10px);
}

.profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
    border-radius: 2rem 2rem 0 0;
}

.profile-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Enhanced Avatar Section */
.avatar-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 3rem;
    padding: 3rem 2rem;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-radius: 2rem;
    border: 1px solid rgba(229, 231, 235, 0.8);
    position: relative;
    overflow: hidden;
}

.avatar-section::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.05) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.avatar-container {
    position: relative;
    margin-bottom: 2rem;
    z-index: 1;
}

.avatar {
    width: 12rem;
    height: 12rem;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 6px solid white;
}

.avatar:hover {
    transform: scale(1.05) rotate(5deg);
    box-shadow: 0 25px 50px rgba(99, 102, 241, 0.4);
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.avatar:hover img {
    transform: scale(1.1);
}

.avatar-placeholder {
    font-size: 4rem;
    font-weight: 800;
    color: white;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
}

/* Image Upload Area */
.image-upload-section {
    margin-top: 2rem;
    width: 100%;
    max-width: 600px;
    z-index: 1;
    position: relative;
}

.upload-area {
    border: 3px dashed var(--gray-light);
    border-radius: 2rem;
    padding: 3rem 2rem;
    text-align: center;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.upload-area:hover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.05);
    transform: translateY(-2px);
}

.upload-area.dragover {
    border-color: var(--primary);
    background: rgba(99, 102, 241, 0.1);
    transform: scale(1.02);
    box-shadow: 0 10px 25px rgba(99, 102, 241, 0.2);
}

.upload-icon {
    width: 4rem;
    height: 4rem;
    margin: 0 auto 1.5rem;
    color: var(--gray);
    transition: all 0.3s ease;
}

.upload-area:hover .upload-icon {
    color: var(--primary);
    transform: scale(1.1);
}

.upload-text {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-dark);
    margin-bottom: 0.5rem;
}

.upload-subtext {
    font-size: 0.875rem;
    color: var(--gray);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    z-index: 10;
}

.upload-controls {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 2rem;
}

/* Enhanced Form Inputs */
.form-input {
    background: white;
    border: 2px solid var(--gray-light);
    border-radius: 1.5rem;
    padding: 1.5rem 2rem;
    color: var(--dark);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    width: 100%;
    font-size: 1.1rem;
    box-shadow: var(--shadow-sm);
    font-weight: 500;
    position: relative;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), var(--shadow-lg);
    transform: translateY(-2px);
    background: #fefefe;
}

.form-input:hover:not(:focus) {
    border-color: rgba(99, 102, 241, 0.5);
    box-shadow: var(--shadow-md);
}

/* Enhanced Form Labels */
.form-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 700;
    color: var(--gray-dark);
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.875rem;
}

/* Enhanced Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 2.5rem;
    border-radius: 1.5rem;
    font-weight: 700;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow-lg);
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
}

.btn-primary:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(99, 102, 241, 0.5);
    color: white;
}

.btn-secondary {
    background: linear-gradient(135deg, var(--secondary), var(--accent));
    color: white;
    box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);
}

.btn-secondary:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(139, 92, 246, 0.5);
    color: white;
}

.btn-upload {
    background: linear-gradient(135deg, var(--info), #0891b2);
    color: white;
    box-shadow: 0 8px 20px rgba(6, 182, 212, 0.4);
    padding: 1rem 2rem;
    font-size: 0.9rem;
}

.btn-upload:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(6, 182, 212, 0.5);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, var(--error), #dc2626);
    color: white;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    padding: 1rem 2rem;
    font-size: 0.9rem;
}

.btn-danger:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(239, 68, 68, 0.5);
    color: white;
}

/* Enhanced Success Messages */
.success-message {
    background: linear-gradient(135deg, var(--success), #16a34a);
    color: white;
    padding: 2rem 2.5rem;
    border-radius: 2rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
    animation: slideInDown 0.6s ease-out;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.error-message-card {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border: 2px solid #fecaca;
    color: #991b1b;
    padding: 2rem 2.5rem;
    border-radius: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
}

/* Enhanced Section Headers */
.card-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 3rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.gradient-text {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.icon-container {
    width: 4rem;
    height: 4rem;
    border-radius: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-lg);
    transition: all 0.3s ease;
}

.icon-container:hover {
    transform: scale(1.1) rotate(5deg);
}

/* Security Info */
.security-info {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border-radius: 2rem;
    padding: 2.5rem;
    border: 2px solid #bbf7d0;
}

/* Error Messages */
.error-message {
    color: var(--error);
    font-size: 0.875rem;
    margin-top: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    background: rgba(239, 68, 68, 0.1);
    padding: 0.75rem 1rem;
    border-radius: 1rem;
    border-left: 4px solid var(--error);
}

/* Animations */
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.profile-card {
    animation: fadeInUp 0.8s ease-out;
}

.profile-card:nth-child(2) {
    animation-delay: 0.2s;
}

/* Loading States */
.btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none !important;
}

.btn:disabled:hover {
    transform: none !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-background {
        padding: 1rem 0;
    }
    
    .card-title {
        font-size: 2rem;
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .avatar {
        width: 10rem;
        height: 10rem;
    }
    
    .btn {
        padding: 1.25rem 2rem;
        font-size: 0.9rem;
    }
    
    .form-input {
        padding: 1.25rem 1.5rem;
        font-size: 1rem;
    }
    
    .upload-controls {
        flex-direction: column;
        align-items: center;
    }
    
    .security-info {
        padding: 2rem;
    }
    
    .icon-container {
        width: 3rem;
        height: 3rem;
    }
    
    .upload-area {
        padding: 2rem 1rem;
    }
}

@media (max-width: 480px) {
    .profile-card {
        margin: 0 1rem 2rem;
        padding: 2rem 1.5rem !important;
    }
    
    .avatar-section {
        padding: 2rem 1rem;
    }
    
    .avatar {
        width: 8rem;
        height: 8rem;
    }
    
    .avatar-placeholder {
        font-size: 3rem;
    }
}

/* Focus styles for accessibility */
.btn:focus-visible,
.form-input:focus-visible {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .profile-card {
        border: 2px solid var(--dark);
    }
    
    .btn {
        border: 2px solid currentColor;
    }
}

/* Reduced motion support */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
</style>
@endsection

@section('content')
<div class="profile-background">
    <div class="w-full px-4 lg:px-8 py-8">
        <div class="max-w-6xl mx-auto space-y-8">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="success-message">
                    <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-lg">Success!</h4>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Error Messages --}}
            @if(session('error'))
                <div class="error-message-card">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-bold text-lg mb-1">Error</h4>
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="error-message-card">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-bold text-lg mb-2">Please fix the following errors:</h4>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="font-medium">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Profile Information Card -->
            <div class="profile-card p-8 lg:p-12">
                <h2 class="card-title">
                    <div class="icon-container bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="gradient-text">Personal Information</span>
                </h2>

                <!-- Enhanced Avatar Section -->
                <div class="avatar-section">
                    <div class="avatar-container">
                        <div class="avatar">
                            @if($client && $client->image && $client->image !== '' && file_exists(public_path($client->image)))
                                <img src="{{ asset($client->image) }}" 
                                     alt="User Avatar" 
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="avatar-placeholder" style="display: none;">
                                    {{ strtoupper(substr($client->name ?? 'G', 0, 1)) }}
                                </div>
                            @else
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($client->name ?? 'G', 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($client)
                        <h3 class="text-4xl font-bold text-gray-800 mb-4">{{ $client->name }}</h3>
                        <p class="text-gray-600 font-semibold text-xl mb-2">{{ $client->email }}</p>
                        <p class="text-gray-500 text-center max-w-md">
                            Manage your profile information and upload a new profile image
                        </p>
                    @else
                        <h3 class="text-4xl font-bold text-gray-800 mb-4">Guest</h3>
                        <p class="text-gray-600 font-semibold text-xl">Not logged in</p>
                    @endif

                    <!-- Image Upload Section -->
                    <div class="image-upload-section">
                        <!-- Drag and Drop Upload Area -->
                        <form action="{{ route('client.profile.image.upload') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                            @csrf
                            <div class="upload-area" id="upload-area">
                                <input type="file" name="image" class="file-input" id="image-upload" accept="image/*" required>
                                
                                <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                
                                <div class="upload-text">Click to upload or drag and drop</div>
                                <div class="upload-subtext">PNG, JPG, GIF up to 5MB</div>
                            </div>
                        </form>

                        <!-- Alternative Upload Button -->
                        <div class="upload-controls">
                           

                            @if($client && $client->image && $client->image !== '')
                                <form action="{{ route('client.profile.image.remove') }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to remove your profile image?');">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Remove Image
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Profile Update Form -->
                <form action="{{ route('client.profile.update') }}" method="POST" id="profile-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Name -->
                        <div>
                            <label for="name" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Full Name
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name', $client->name ?? '') }}" required autofocus class="form-input" autocomplete="name">
                            @error('name')
                                <p class="error-message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Email Address
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email', $client->email ?? '') }}" required class="form-input" autocomplete="email">
                            @error('email')
                                <p class="error-message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Phone Number
                            </label>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone', $client->phone ?? '') }}" class="form-input" autocomplete="tel">
                            @error('phone')
                                <p class="error-message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Address
                            </label>
                            <input id="address" type="text" name="address" value="{{ old('address', $client->address ?? '') }}" class="form-input" autocomplete="street-address">
                            @error('address')
                                <p class="error-message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                City
                            </label>
                            <input id="city" type="text" name="city" value="{{ old('city', $client->city ?? '') }}" class="form-input" autocomplete="address-level2">
                            @error('city')
                                <p class="error-message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- State -->
                        <div>
                            <label for="state" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                                State
                            </label>
                            <input id="state" type="text" name="state" value="{{ old('state', $client->state ?? '') }}" class="form-input" autocomplete="address-level1">
                            @error('state')
                                <p class="error-message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- ZIP Code -->
                        <div>
                            <label for="zip_code" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 4v10a2 2 0 002 2h6a2 2 0 002-2V8M7 8H5a2 2 0 00-2 2v8a2 2 0 002 2h2m0-12h10m-5 4v4"></path>
                                </svg>
                                ZIP Code
                            </label>
                            <input id="zip_code" type="text" name="zip_code" value="{{ old('zip_code', $client->zip_code ?? '') }}" class="form-input" autocomplete="postal-code">
                            @error('zip_code')
                                <p class="error-message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end mt-12">
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Card -->
            <div class="profile-card p-8 lg:p-12">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-6">
                    <h2 class="card-title mb-0">
                        <div class="icon-container bg-gradient-to-br from-green-500 to-emerald-600">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="gradient-text">Security Settings</span>
                    </h2>
                    
                    <a href="{{ route('client.password') }}" class="btn btn-secondary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"></path>
                        </svg>
                        Change Password
                    </a>
                </div>
                
                <div class="security-info">
                    <div class="flex items-start gap-6">
                        <div class="w-16 h-16 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Account Security</h3>
                            <p class="text-gray-600 mb-6 text-lg leading-relaxed">
                                Your account is protected with industry-standard security measures. 
                                We recommend using a strong, unique password and updating it regularly.
                            </p>
                            <div class="space-y-3">
                                <p class="text-sm text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="font-semibold">Password last updated:</span> 
                                    <span class="text-gray-700 font-bold">
                                        @if($client)
                                            {{ $client->updated_at->diffForHumans() }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </p>
                                <p class="text-sm text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="font-semibold">Account created:</span> 
                                    <span class="text-gray-700 font-bold">
                                        @if($client)
                                            {{ $client->created_at->format('M d, Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </p>
                            </div>
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
document.addEventListener('DOMContentLoaded', function() {
    // Get upload elements
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('image-upload');
    const uploadForm = document.getElementById('upload-form');
    
    // File input change handler
    fileInput.addEventListener('change', function(e) {
        const file = this.files[0];
        if (file) {
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, GIF, or WebP)');
                this.value = '';
                return;
            }
            
            // Validate file size (max 5MB)
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            if (file.size > maxSize) {
                alert('Please select an image smaller than 5MB');
                this.value = '';
                return;
            }
            
            // Show loading state
            showUploadLoading();
            
            // Submit the form
            uploadForm.submit();
        }
    });
    
    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, GIF, or WebP)');
                return;
            }
            
            // Validate file size (max 5MB)
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            if (file.size > maxSize) {
                alert('Please select an image smaller than 5MB');
                return;
            }
            
            // Set the file to the input
            fileInput.files = files;
            
            // Show loading state
            showUploadLoading();
            
            // Submit the form
            uploadForm.submit();
        }
    });
    
    // Click to upload
    uploadArea.addEventListener('click', function(e) {
        if (e.target === this || e.target.closest('.upload-icon, .upload-text, .upload-subtext')) {
            fileInput.click();
        }
    });
    
    function showUploadLoading() {
        const uploadIcon = uploadArea.querySelector('.upload-icon');
        const uploadText = uploadArea.querySelector('.upload-text');
        const uploadSubtext = uploadArea.querySelector('.upload-subtext');
        
        if (uploadIcon) {
            uploadIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            `;
            uploadIcon.classList.add('animate-spin');
        }
        
        if (uploadText) {
            uploadText.textContent = 'Uploading...';
        }
        
        if (uploadSubtext) {
            uploadSubtext.textContent = 'Please wait while we process your image';
        }
        
        uploadArea.style.pointerEvents = 'none';
        uploadArea.style.opacity = '0.7';
    }
    
    // Enhanced form validation with visual feedback
    const inputs = document.querySelectorAll('.form-input');
    
    inputs.forEach(input => {
        // Real-time validation feedback
        input.addEventListener('input', function() {
            clearTimeout(this.validationTimeout);
            this.validationTimeout = setTimeout(() => {
                validateField(this);
            }, 300);
        });
        
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('focus', function() {
            resetFieldStyle(this);
        });
    });
    
    function validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        const fieldType = field.type;
        
        // Reset styles
        resetFieldStyle(field);
        
        // Check if required field is empty
        if (isRequired && value === '') {
            setFieldError(field, 'This field is required');
            return false;
        }
        
        // Email validation
        if (fieldType === 'email' && value !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                setFieldError(field, 'Please enter a valid email address');
                return false;
            }
        }
        
        // Phone validation (basic)
        if (field.name === 'phone' && value !== '') {
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            if (!phoneRegex.test(value.replace(/[\s\-()]/g, ''))) {
                setFieldError(field, 'Please enter a valid phone number');
                return false;
            }
        }
        
        // If we get here, field is valid
        if (value !== '') {
            setFieldSuccess(field);
        }
        
        return true;
    }
    
    function setFieldError(field, message) {
        field.style.borderColor = 'var(--error)';
        field.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.1)';
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.validation-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'validation-error text-red-600 text-sm mt-2 flex items-center gap-2';
        errorDiv.innerHTML = `
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            ${message}
        `;
        field.parentNode.appendChild(errorDiv);
    }
    
    function setFieldSuccess(field) {
        field.style.borderColor = 'var(--success)';
        field.style.boxShadow = '0 0 0 4px rgba(16, 185, 129, 0.1)';
        
        // Remove any existing validation messages
        const existingError = field.parentNode.querySelector('.validation-error');
        if (existingError) {
            existingError.remove();
        }
    }
    
    function resetFieldStyle(field) {
        field.style.borderColor = 'var(--primary)';
        field.style.boxShadow = '0 0 0 4px rgba(99, 102, 241, 0.1), var(--shadow-lg)';
        
        // Remove any existing validation messages
        const existingError = field.parentNode.querySelector('.validation-error');
        if (existingError) {
            existingError.remove();
        }
    }
    
    // Enhanced form submission
    const form = document.getElementById('profile-form');
    const submitBtn = document.getElementById('submit-btn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Validate all fields before submission
            let isValid = true;
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = document.querySelector('.validation-error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
            
            // Show loading state
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Saving Changes...
            `;
            submitBtn.disabled = true;
            
            // Re-enable button after 10 seconds as fallback
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }
            }, 10000);
        });
    }
    
    // Auto-hide success messages
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.opacity = '0';
            successMessage.style.transform = 'translateY(-50px)';
            setTimeout(() => {
                successMessage.remove();
            }, 500);
        }, 6000);
    }
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Utility function for showing toast notifications
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-2xl text-white font-semibold shadow-xl transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 
        type === 'error' ? 'bg-gradient-to-r from-red-500 to-red-600' : 
        'bg-gradient-to-r from-blue-500 to-blue-600'
    }`;
    
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' ? 
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                }
            </svg>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 100);
    
    // Animate out and remove
    setTimeout(() => {
        toast.style.transform = 'translateX(full)';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 4000);
}
</script>
@endsection