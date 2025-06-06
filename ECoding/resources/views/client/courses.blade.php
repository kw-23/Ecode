@extends('layouts.client')

@section('title', 'Programming Courses')

@section('styles')
<style>
    :root {
        /* Modern Color System */
        --primary-50: #eff6ff;
        --primary-100: #dbeafe;
        --primary-200: #bfdbfe;
        --primary-300: #93c5fd;
        --primary-400: #60a5fa;
        --primary-500: #3b82f6;
        --primary-600: #2563eb;
        --primary-700: #1d4ed8;
        --primary-800: #1e40af;
        --primary-900: #1e3a8a;
        
        --accent-violet: #8b5cf6;
        --accent-emerald: #10b981;
        --accent-amber: #f59e0b;
        --accent-rose: #f43f5e;
        --accent-cyan: #06b6d4;
        
        --gray-50: #fafafa;
        --gray-100: #f4f4f5;
        --gray-200: #e4e4e7;
        --gray-300: #d4d4d8;
        --gray-400: #a1a1aa;
        --gray-500: #71717a;
        --gray-600: #52525b;
        --gray-700: #3f3f46;
        --gray-800: #27272a;
        --gray-900: #18181b;
        
        /* Advanced Shadows */
        --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        
        /* Premium Gradients */
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --gradient-warning: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --gradient-mesh: 
            radial-gradient(at 40% 20%, hsla(28,100%,74%,0.1) 0px, transparent 50%),
            radial-gradient(at 80% 0%, hsla(189,100%,56%,0.1) 0px, transparent 50%),
            radial-gradient(at 0% 50%, hsla(355,100%,93%,0.1) 0px, transparent 50%),
            radial-gradient(at 80% 50%, hsla(340,100%,76%,0.1) 0px, transparent 50%),
            radial-gradient(at 0% 100%, hsla(22,100%,77%,0.1) 0px, transparent 50%),
            radial-gradient(at 80% 100%, hsla(242,100%,70%,0.1) 0px, transparent 50%);
        
        /* Smooth Transitions */
        --transition-fast: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-normal: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-bounce: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        box-sizing: border-box;
    }
    
    .font-display {
        font-family: 'Space Grotesk', sans-serif;
    }
    
    /* Full Width Layout */
    .courses-container {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        background: var(--gradient-mesh), linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        min-height: calc(100vh - 5rem);
    }
    
    .courses-content {
        max-width: 1600px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    /* Advanced Animations */
    @keyframes float-gentle {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-8px) rotate(1deg); }
    }
    
    @keyframes fade-in-up {
        from { 
            opacity: 0; 
            transform: translateY(40px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    @keyframes scale-in {
        from { 
            opacity: 0; 
            transform: scale(0.9); 
        }
        to { 
            opacity: 1; 
            transform: scale(1); 
        }
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%) skewX(-15deg); }
        100% { transform: translateX(200%) skewX(-15deg); }
    }
    
    /* Hero Section */
    .hero-section {
        background: var(--gradient-mesh);
        border-radius: 32px;
        padding: 3rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(59, 130, 246, 0.1);
        animation: fade-in-up 0.8s ease-out;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        animation: float-gentle 8s ease-in-out infinite;
    }
    
    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -20%;
        width: 80%;
        height: 150%;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 70%);
        animation: float-gentle 12s ease-in-out infinite reverse;
    }
    
    .hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
    }
    
    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--gray-900) 0%, var(--primary-600) 50%, var(--accent-violet) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-family: 'Space Grotesk', sans-serif;
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--gray-600);
        margin-bottom: 2rem;
        line-height: 1.7;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }
    
    /* Search Container */
    .search-container {
        position: relative;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .search-input {
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 20px;
        padding: 1.25rem 1.75rem 1.25rem 4rem;
        color: var(--gray-900);
        transition: var(--transition-normal);
        width: 100%;
        font-size: 1.125rem;
        box-shadow: var(--shadow-lg);
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--primary-500);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), var(--shadow-xl);
        transform: translateY(-2px);
    }
    
    .search-icon {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        z-index: 10;
    }
    
    /* Filter Sidebar */
    .filter-sidebar {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-lg);
        position: sticky;
        top: 2rem;
        transition: var(--transition-normal);
    }
    
    .filter-sidebar:hover {
        box-shadow: var(--shadow-xl);
    }
    
    .filter-select {
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 16px;
        padding: 1rem 1.25rem;
        color: var(--gray-900);
        transition: var(--transition-normal);
        width: 100%;
        font-weight: 500;
        box-shadow: var(--shadow-sm);
    }
    
    .filter-select:focus {
        outline: none;
        border-color: var(--primary-500);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), var(--shadow-md);
        transform: translateY(-1px);
    }
    
    /* Course Cards */
    .course-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-lg);
        transition: var(--transition-normal);
        position: relative;
        animation: fade-in-up 0.6s ease-out;
    }
    
    .course-card:hover {
        box-shadow: var(--shadow-2xl);
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(59, 130, 246, 0.3);
    }
    
    .course-image {
        height: 240px;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .course-image::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--gradient-primary);
    }
    
    /* Modern Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.875rem 2rem;
        border-radius: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition-normal);
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
        position: relative;
        overflow: hidden;
        gap: 0.5rem;
    }
    
    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s;
    }
    
    .btn:hover::before {
        left: 100%;
    }
    
    .btn-primary {
        background: var(--gradient-primary);
        color: white;
        box-shadow: var(--shadow-md);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 40px rgba(59, 130, 246, 0.3);
        color: white;
    }
    
    .btn-secondary {
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-300);
        box-shadow: var(--shadow-sm);
    }
    
    .btn-secondary:hover {
        background: var(--gray-50);
        border-color: var(--primary-300);
        transform: translateY(-2px);
        color: var(--gray-800);
    }
    
    /* Badges */
    .badge {
        padding: 0.5rem 1.25rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-fast);
    }
    
    .badge:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }
    
    .difficulty-beginner {
        background: var(--gradient-success);
        color: white;
    }
    
    .difficulty-intermediate {
        background: var(--gradient-warning);
        color: white;
    }
    
    .difficulty-advanced {
        background: var(--gradient-secondary);
        color: white;
    }
    
    /* Results Header */
    .results-header {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-lg);
        animation: fade-in-up 0.6s ease-out;
    }
    
    /* Empty State */
    .empty-state {
        background: white;
        border-radius: 24px;
        padding: 4rem 2rem;
        text-align: center;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-lg);
        animation: scale-in 0.6s ease-out;
    }
    
    .empty-icon {
        width: 8rem;
        height: 8rem;
        background: var(--gradient-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        box-shadow: var(--shadow-xl);
        animation: float-gentle 6s ease-in-out infinite;
    }
    
    /* Section Headers */
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1rem;
        font-family: 'Space Grotesk', sans-serif;
    }
    
    .section-subtitle {
        font-size: 1.125rem;
        color: var(--gray-600);
        margin-bottom: 2rem;
    }
    
    /* Utility Classes */
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .hover-lift {
        transition: var(--transition-normal);
    }
    
    .hover-lift:hover {
        transform: translateY(-4px);
    }
    
    /* Responsive Design */
    @media (max-width: 1200px) {
        .courses-content {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .courses-content {
            padding: 1rem;
        }
        
        .hero-section {
            padding: 2rem;
        }
        
        .hero-title {
            font-size: 2.5rem;
        }
        
        .filter-sidebar {
            position: static;
            margin-bottom: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div class="courses-container">
    <div class="courses-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">
                    Discover Courses
                </h1>
                <p class="hero-subtitle">
                    Explore our comprehensive collection of programming courses designed to accelerate your development journey and unlock your potential.
                </p>
                
                <!-- Search Bar -->
                <div class="search-container">
                    <form method="GET" action="{{ route('client.courses') }}">
                        <div class="relative">
                            <svg class="search-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Search courses, technologies, or topics..." 
                                class="search-input"
                            >
                        </div>
                        
                        @foreach(request()->except('search') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                    </form>
                </div>
            </div>
        </section>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="filter-sidebar">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                            </svg>
                        </div>
                        <span class="text-gradient">Filters</span>
                    </h3>
                    
                    <form method="GET" action="{{ route('client.courses') }}" id="filterForm">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <!-- Category Filter -->
                        <div class="mb-6">
                            <label class="block text-lg font-bold text-gray-700 mb-3">Category</label>
                            <select name="category" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Difficulty Filter -->
                        <div class="mb-6">
                            <label class="block text-lg font-bold text-gray-700 mb-3">Difficulty</label>
                            <select name="difficulty" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Levels</option>
                                <option value="beginner" {{ request('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ request('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>
                        
                        <!-- Price Filter -->
                        <div class="mb-6">
                            <label class="block text-lg font-bold text-gray-700 mb-3">Price</label>
                            <select name="price_type" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Courses</option>
                                <option value="free" {{ request('price_type') == 'free' ? 'selected' : '' }}>Free Courses</option>
                                <option value="paid" {{ request('price_type') == 'paid' ? 'selected' : '' }}>Paid Courses</option>
                            </select>
                        </div>
                        
                        <!-- Sort Filter -->
                        <div class="mb-6">
                            <label class="block text-lg font-bold text-gray-700 mb-3">Sort By</label>
                            <select name="sort" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                        
                        <!-- Clear Filters -->
                        <a href="{{ route('client.courses') }}" class="btn btn-secondary w-full text-center block">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Clear All Filters
                        </a>
                    </form>
                </div>
            </div>
            
            <!-- Courses Grid -->
            <div class="lg:w-3/4">
                <!-- Results Header -->
                <div class="results-header">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="section-title">
                                @if(request('search'))
                                    <span class="text-gray-600">Search Results for</span>
                                    <span class="text-gradient">"{{ request('search') }}"</span>
                                @else
                                    <span class="text-gradient">All Courses</span>
                                @endif
                            </h2>
                            <p class="text-gray-600 flex items-center text-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                {{ $courses->total() }} courses found
                            </p>
                        </div>
                        
                        @if(request()->hasAny(['search', 'category', 'difficulty', 'price_type']))
                            <div class="flex items-center gap-2 text-gray-500 font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                                </svg>
                                Filters applied
                            </div>
                        @endif
                    </div>
                </div>
                
                @if($courses->count() > 0)
                    <!-- Courses Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                        @foreach($courses as $course)
                            <div class="course-card hover-lift">
                                <div class="course-image">
                                    @if($course->cover_image && file_exists(public_path($course->cover_image)))
                                        <img src="{{ asset($course->cover_image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-center relative z-10">
                                            <svg class="w-20 h-20 text-white/90 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                            </svg>
                                            <div class="text-white/80 font-mono text-lg font-bold">{{ strtoupper(substr($course->title, 0, 3)) }}</div>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute top-4 right-4">
                                        <span class="badge difficulty-{{ $course->difficulty_level }}">
                                            {{ ucfirst($course->difficulty_level) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-800 mb-3 leading-tight">
                                        {{ $course->title }}
                                    </h3>
                                    
                                    <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                                        {{ $course->short_description ?? Str::limit($course->description, 120) }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center text-gray-500 font-medium text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            {{ $course->downloads_count ?? 0 }} downloads
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-3">
                                        <a href="{{ route('client.course-detail', $course->slug) }}" class="btn btn-primary flex-1 text-center">
                                            View Course
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $courses->links() }}
                    </div>
                @else
                    <!-- No Courses Found -->
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">No Courses Found</h3>
                        <p class="text-gray-600 mb-8 max-w-lg mx-auto text-lg leading-relaxed">
                            @if(request()->hasAny(['search', 'category', 'difficulty', 'price_type']))
                                We couldn't find any courses matching your criteria. Try adjusting your filters or search terms.
                            @else
                                We're curating amazing programming courses for you. Check back soon for exciting new content!
                            @endif
                        </p>
                        
                        @if(request()->hasAny(['search', 'category', 'difficulty', 'price_type']))
                            <a href="{{ route('client.courses') }}" class="btn btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Clear All Filters
                            </a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="btn btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // Observe course cards for animation
        document.querySelectorAll('.course-card').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = `opacity 0.6s ease-out ${index * 0.1}s, transform 0.6s ease-out ${index * 0.1}s`;
            observer.observe(el);
        });
        
        // Auto-submit search form with debounce
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.form.submit();
                }, 500);
            });
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                searchInput?.focus();
            }
        });
        
        // Enhanced hover effects
        document.querySelectorAll('.course-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    });
</script>
@endsection