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
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    /* Clean Background */
    .profile-background {
        background: #f8fafc;
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Enhanced Cards */
    .profile-card {
        background: white;
        border-radius: 2rem;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e5e7eb;
        position: relative;
        margin-bottom: 2rem;
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
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
    }

    /* Enhanced Avatar Section */
    .avatar-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 3rem;
        padding: 3rem 2rem;
        background: #f9fafb;
        border-radius: 2rem;
        border: 1px solid #e5e7eb;
        position: relative;
    }

    .avatar-container {
        position: relative;
        margin-bottom: 2rem;
    }

    .avatar {
        width: 10rem;
        height: 10rem;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.2);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 4px solid white;
    }

    .avatar:hover {
        transform: scale(1.02);
        box-shadow: 0 15px 35px rgba(99, 102, 241, 0.3);
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .avatar-placeholder {
        font-size: 3rem;
        font-weight: 700;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    /* Image Control Icons */
    .image-controls {
        position: absolute;
        bottom: 0;
        right: 0;
        display: flex;
        gap: 0.5rem;
    }

    .control-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .edit-icon {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .edit-icon:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    .delete-icon {
        background: linear-gradient(135deg, var(--error), #dc2626);
        color: white;
    }

    .delete-icon:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .control-icon svg {
        width: 1rem;
        height: 1rem;
    }

    /* Hidden file input */
    .hidden-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
        overflow: hidden;
    }

    /* Enhanced Form Inputs */
    .form-input {
        background: white;
        border: 2px solid var(--gray-light);
        border-radius: 1.5rem;
        padding: 1.25rem 1.5rem;
        color: var(--dark);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
        font-size: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        font-weight: 500;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1), 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
        background: #fefefe;
    }

    .form-input:hover {
        border-color: var(--primary);
        box-shadow: 0 6px 12px -2px rgba(0, 0, 0, 0.1);
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
        padding: 1.25rem 2rem;
        border-radius: 1.5rem;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.5);
        color: white;
    }

    .btn-secondary {
        background: linear-gradient(135deg, var(--secondary), var(--accent));
        color: white;
        box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);
    }

    .btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(139, 92, 246, 0.5);
        color: white;
    }

    /* Enhanced Success Messages */
    .success-message {
        background: linear-gradient(135deg, var(--success), #16a34a);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        animation: slideInDown 0.5s ease-out;
    }

    /* Enhanced Section Headers */
    .card-title {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 2.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .gradient-text {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Enhanced Security Info */
    .security-info {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(6, 182, 212, 0.05));
        border: 2px solid rgba(16, 185, 129, 0.2);
        border-radius: 1.5rem;
        padding: 2rem;
        margin-top: 2rem;
        position: relative;
        overflow: hidden;
    }

    .security-info::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--success), var(--info));
    }

    /* Error Messages */
    .error-message {
        color: var(--error);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
    }

    /* Animations */
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .profile-card {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-title {
            font-size: 1.75rem;
        }
        
        .avatar {
            width: 8rem;
            height: 8rem;
        }
        
        .btn {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
        }
        
        .control-icon {
            width: 2rem;
            height: 2rem;
        }
        
        .control-icon svg {
            width: 0.875rem;
            height: 0.875rem;
        }
    }
</style>
@endsection

@section('content')
<div class="profile-background">
    <div class="w-full px-6 lg:px-12 py-12">
        <div class="max-w-6xl mx-auto space-y-8">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="success-message">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="font-medium">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Information Card -->
            <div class="profile-card p-10">
                <h2 class="card-title">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="gradient-text">Personal Information</span>
                </h2>

                <!-- Enhanced Avatar Section -->
                <div class="avatar-section">
                    <div class="avatar-container">
                        <div class="avatar">
                            @php
                                $imagePath = null;
                                $imageExists = false;
                                
                                if($client && $client->image) {
                                    // Try different possible paths
                                    $possiblePaths = [
                                        'images/' . $client->image,
                                        $client->image,
                                        'storage/' . $client->image,
                                        'storage/images/' . $client->image
                                    ];
                                    
                                    foreach($possiblePaths as $path) {
                                        if(file_exists(public_path($path))) {
                                            $imagePath = asset($path);
                                            $imageExists = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            @if($imageExists && $imagePath)
                                <img src="{{ $imagePath }}" 
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

                        <!-- Image Control Icons -->
                        <div class="image-controls">
                            <!-- Edit Icon -->
                            <label for="image-upload" class="control-icon edit-icon" title="Change Photo">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </label>

                            <!-- Delete Icon (only show if image exists) -->
                            @if($imageExists && $imagePath)
                                <button type="button" class="control-icon delete-icon" title="Remove Photo" onclick="confirmDelete()">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    @if($client)
                        <h3 class="text-3xl font-bold text-gray-800 mb-3">{{ $client->name }}</h3>
                        <p class="text-gray-600 font-semibold text-lg">{{ $client->email }}</p>
                        <p class="text-sm text-gray-500 mt-2">Click the camera icon to update your profile picture</p>
                    @else
                        <h3 class="text-3xl font-bold text-gray-800 mb-3">Guest</h3>
                        <p class="text-gray-600 font-semibold text-lg">Not logged in</p>
                    @endif
                </div>

                <!-- Hidden Forms -->
                <!-- Image Upload Form -->
                <form action="{{ route('client.profile.image.update') }}" method="POST" enctype="multipart/form-data" id="image-upload-form">
                    @csrf
                    @method('POST')
                    <input type="file" id="image-upload" name="image" accept="image/*" class="hidden-input" onchange="this.form.submit()">
                </form>

                <!-- Image Delete Form -->
                <form action="{{ route('client.profile.image.delete') }}" method="POST" id="image-delete-form">
                    @csrf
                    @method('DELETE')
                </form>
                
                <!-- Profile Update Form -->
                <form action="{{ route('client.profile.update') }}" method="POST" id="profile-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Name -->
                        <div>
                            <label for="name" class="form-label">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Full Name
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name', $client->name ?? '') }}" required autofocus class="form-input">
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
                            <input id="email" type="email" name="email" value="{{ old('email', $client->email ?? '') }}" required class="form-input">
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
                            <input id="address" type="text" name="address" value="{{ old('address', $client->address ?? '') }}" class="form-input">
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
                            <input id="city" type="text" name="city" value="{{ old('city', $client->city ?? '') }}" class="form-input">
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
                            <input id="state" type="text" name="state" value="{{ old('state', $client->state ?? '') }}" class="form-input">
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
                            <input id="zip_code" type="text" name="zip_code" value="{{ old('zip_code', $client->zip_code ?? '') }}" class="form-input">
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

                    <div class="flex justify-end mt-10">
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Card -->
            <div class="profile-card p-10">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="card-title">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="gradient-text">Security Settings</span>
                    </h2>
                    
                    <a href="{{ route('client.password') }}" class="btn btn-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z"></path>
                        </svg>
                        Change Password
                    </a>
                </div>
                
                <div class="security-info">
                    <div class="flex items-start gap-6">
                        <div class="w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Account Security</h3>
                            <p class="text-gray-600 mb-4 text-lg">Ensure your account is using a long, random password to stay secure.</p>
                            <p class="text-sm text-gray-500">
                                <span class="font-semibold">Password last updated:</span> 
                                <span class="text-gray-700 font-bold">
                                    @if($client)
                                        {{ $client->updated_at->diffForHumans() }}
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
@endsection

@section('scripts')
<script>
    // Confirm delete function
    function confirmDelete() {
        if (confirm('Are you sure you want to remove your profile picture?')) {
            document.getElementById('image-delete-form').submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced form validation feedback
        const inputs = document.querySelectorAll('.form-input');
        
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '' && this.hasAttribute('required')) {
                    this.style.borderColor = 'var(--error)';
                    this.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.1)';
                } else if (this.value.trim() !== '') {
                    this.style.borderColor = 'var(--success)';
                    this.style.boxShadow = '0 0 0 4px rgba(16, 185, 129, 0.1)';
                }
            });
            
            input.addEventListener('focus', function() {
                this.style.borderColor = 'var(--primary)';
                this.style.boxShadow = '0 0 0 4px rgba(99, 102, 241, 0.1)';
            });
        });
        
        // Success message auto-hide with enhanced animation
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.opacity = '0';
                successMessage.style.transform = 'translateY(-30px)';
                setTimeout(() => {
                    successMessage.remove();
                }, 500);
            }, 5000);
        }
        
        // Enhanced form submission handling
        const form = document.getElementById('profile-form');
        const submitBtn = document.getElementById('submit-btn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                // Show loading state
                submitBtn.innerHTML = `
                    <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Saving...
                `;
                submitBtn.disabled = true;
            });
        }
    });
</script>
@endsection