@extends('layouts.client')

@section('title', 'Dashboard - E0coding Platform')

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
    
    .font-mono {
        font-family: 'JetBrains Mono', monospace;
    }
    
    /* Full Width Dashboard Layout */
    .dashboard-container {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        background: var(--gradient-mesh), linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        min-height: calc(100vh - 5rem);
    }
    
    .dashboard-content {
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
    
    @keyframes pulse-glow {
        0%, 100% { box-shadow: var(--shadow-lg); }
        50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.3); }
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
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: center;
    }
    
    .hero-text h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, var(--gray-900) 0%, var(--primary-600) 50%, var(--accent-violet) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .hero-text p {
        font-size: 1.25rem;
        color: var(--gray-600);
        margin-bottom: 2rem;
        line-height: 1.7;
    }
    
    /* Stats Grid */
    .stats-section {
        margin-bottom: 4rem;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-lg);
        transition: var(--transition-normal);
        position: relative;
        overflow: hidden;
        animation: fade-in-up 0.6s ease-out;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }
    
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-2xl);
        animation: pulse-glow 2s infinite;
    }
    
    .stat-icon {
        width: 4rem;
        height: 4rem;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        transition: var(--transition-bounce);
    }
    
    .stat-card:hover .stat-icon {
        transform: rotate(10deg) scale(1.1);
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        font-family: 'Space Grotesk', sans-serif;
    }
    
    .stat-label {
        color: var(--gray-600);
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .stat-change {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--accent-emerald);
    }
    
    /* Quick Actions Section */
    .quick-actions {
        margin-bottom: 4rem;
    }
    
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .action-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.6s;
    }
    
    .action-card:hover::before {
        left: 100%;
    }
    
    .action-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: var(--shadow-xl);
    }
    
    .action-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
    }
    
    /* Recent Activity Section */
    .recent-activity {
        margin-bottom: 4rem;
    }
    
    .activity-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }
    
    .activity-card {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-lg);
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: var(--transition-fast);
    }
    
    .activity-item:hover {
        background: var(--gray-50);
    }
    
    .activity-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
    }
    
    /* Progress Section */
    .progress-section {
        margin-bottom: 4rem;
    }
    
    .progress-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }
    
    .progress-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-lg);
        transition: var(--transition-normal);
    }
    
    .progress-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }
    
    .progress-bar-container {
        background: var(--gray-200);
        border-radius: 10px;
        height: 8px;
        overflow: hidden;
        position: relative;
        margin: 1rem 0;
    }
    
    .progress-bar {
        height: 100%;
        background: var(--gradient-primary);
        border-radius: 10px;
        position: relative;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 2s infinite;
    }
    
    /* Modern Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.875rem 2rem;
        border-radius: 12px;
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
    
    /* Responsive Design */
    @media (max-width: 1200px) {
        .dashboard-content {
            padding: 1.5rem;
        }
        
        .hero-content {
            grid-template-columns: 1fr;
            gap: 2rem;
            text-align: center;
        }
        
        .activity-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .dashboard-content {
            padding: 1rem;
        }
        
        .hero-section {
            padding: 2rem;
        }
        
        .stats-grid,
        .actions-grid,
        .progress-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .hero-text h1 {
            font-size: 2.5rem;
        }
    }
    
    /* Utility Classes */
    .animate-fade-up { animation: fade-in-up 0.8s ease-out; }
    .animate-scale { animation: scale-in 0.6s ease-out; }
    .animate-float { animation: float-gentle 6s ease-in-out infinite; }
    
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Color Utilities */
    .bg-primary { background: var(--gradient-primary); }
    .bg-secondary { background: var(--gradient-secondary); }
    .bg-success { background: var(--gradient-success); }
    .bg-warning { background: var(--gradient-warning); }
    
    .text-primary { color: var(--primary-600); }
    .text-secondary { color: var(--accent-violet); }
    .text-success { color: var(--accent-emerald); }
    .text-warning { color: var(--accent-amber); }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="dashboard-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="font-display">
                        Welcome back, <span class="text-gradient">{{ $client->name ?? 'Developer' }}</span>!
                    </h1>
                    <p>
                        Ready to continue your coding journey? Explore new courses, track your progress, 
                        and unlock your potential with our comprehensive learning platform.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('client.courses') }}" class="btn btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Browse Courses
                        </a>
                        <a href="{{ route('client.profile') }}" class="btn btn-secondary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            View Profile
                        </a>
                    </div>
                </div>
                
                <div class="hero-visual">
                    <div class="stat-card animate-float">
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-primary flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Your Progress</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-primary">{{ $completedCourses ?? 12 }}</div>
                                    <div class="text-gray-500">Completed</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-secondary">{{ $totalLearningHours ?? 48 }}h</div>
                                    <div class="text-gray-500">Learning Time</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="stats-grid">
                <div class="stat-card animate-fade-up">
                    <div class="stat-icon bg-primary">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="stat-number text-gray-800">{{ $totalCourses ?? 150 }}</div>
                    <div class="stat-label">Total Courses</div>
                    <div class="stat-change">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +{{ $newCoursesThisWeek ?? 3 }} this week
                    </div>
                </div>

                <div class="stat-card animate-fade-up" style="animation-delay: 0.1s;">
                    <div class="stat-icon bg-success">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-number text-success">{{ $completedCourses ?? 12 }}</div>
                    <div class="stat-label">Completed</div>
                    <div class="stat-change">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        {{ $completionRate ?? 85 }}% success rate
                    </div>
                </div>

                <div class="stat-card animate-fade-up" style="animation-delay: 0.2s;">
                    <div class="stat-icon bg-warning">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-number text-warning">{{ $totalLearningHours ?? 48 }}h</div>
                    <div class="stat-label">Learning Time</div>
                    <div class="stat-change">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +{{ $learningHoursThisWeek ?? 12 }}h this week
                    </div>
                </div>

                <div class="stat-card animate-fade-up" style="animation-delay: 0.3s;">
                    <div class="stat-icon bg-secondary">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div class="stat-number text-secondary">{{ number_format($averageRating ?? 4.8, 1) }}</div>
                    <div class="stat-label">Average Rating</div>
                    <div class="stat-change">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Outstanding feedback
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="quick-actions">
            <h2 class="section-title">Quick Actions</h2>
            <p class="section-subtitle">Jump into your learning journey with these popular actions</p>
            
            <div class="actions-grid">
                <div class="action-card animate-scale">
                    <div class="action-icon bg-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Browse Courses</h3>
                    <p class="text-gray-600 text-sm mb-4">Discover new programming courses and technologies</p>
                    <a href="{{ route('client.courses') }}" class="btn btn-primary">Explore</a>
                </div>
                
                <div class="action-card animate-scale" style="animation-delay: 0.1s;">
                    <div class="action-icon bg-success">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Continue Learning</h3>
                    <p class="text-gray-600 text-sm mb-4">Resume your current courses and projects</p>
                    <a href="#" class="btn btn-primary">Continue</a>
                </div>
                
                <div class="action-card animate-scale" style="animation-delay: 0.2s;">
                    <div class="action-icon bg-warning">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Update Profile</h3>
                    <p class="text-gray-600 text-sm mb-4">Manage your account settings and preferences</p>
                    <a href="{{ route('client.profile') }}" class="btn btn-primary">Settings</a>
                </div>
                
                <div class="action-card animate-scale" style="animation-delay: 0.3s;">
                    <div class="action-icon bg-secondary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 8h8a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Download Resources</h3>
                    <p class="text-gray-600 text-sm mb-4">Access course materials and certificates</p>
                    <a href="#" class="btn btn-primary">Download</a>
                </div>
            </div>
        </section>

        <!-- Recent Activity & Progress -->
        <section class="recent-activity">
            <h2 class="section-title">Recent Activity & Progress</h2>
            <p class="section-subtitle">Track your learning journey and recent achievements</p>
            
            <div class="activity-grid">
                <div class="activity-card">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Activity</h3>
                    <div class="space-y-2">
                        <div class="activity-item">
                            <div class="activity-icon bg-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Completed JavaScript Fundamentals</div>
                                <div class="text-sm text-gray-500">2 hours ago</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon bg-success">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Started React Advanced Course</div>
                                <div class="text-sm text-gray-500">1 day ago</div>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon bg-warning">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-4-4m4 4l4-4m-6 8h8a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Downloaded Python Certificate</div>
                                <div class="text-sm text-gray-500">3 days ago</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="activity-card">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Learning Streak</h3>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary mb-2">{{ $learningStreak ?? 7 }}</div>
                        <div class="text-gray-600 mb-4">Days in a row</div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: {{ min(100, ($learningStreak ?? 7) * 10) }}%"></div>
                        </div>
                        <div class="text-sm text-gray-500 mt-2">Keep it up! You're doing great!</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Course Progress -->
        <section class="progress-section">
            <h2 class="section-title">Course Progress</h2>
            <p class="section-subtitle">Continue where you left off</p>
            
            <div class="progress-grid">
                @forelse($currentCourses ?? [] as $course)
                    <div class="progress-card">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $course->title ?? 'JavaScript Fundamentals' }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $course->description ?? 'Learn the basics of JavaScript programming' }}</p>
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Progress</span>
                            <span class="text-sm font-medium text-primary">{{ $course->progress ?? 75 }}%</span>
                        </div>
                        
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: {{ $course->progress ?? 75 }}%"></div>
                        </div>
                        
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-xs text-gray-500">{{ $course->lessons_completed ?? 8 }}/{{ $course->total_lessons ?? 12 }} lessons</span>
                            <a href="#" class="btn btn-primary">Continue</a>
                        </div>
                    </div>
                @empty
                    @for($i = 1; $i <= 3; $i++)
                        <div class="progress-card">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ ['JavaScript Fundamentals', 'React Advanced', 'Python for Data Science'][$i-1] }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ ['Learn the basics of JavaScript', 'Master React development', 'Data analysis with Python'][$i-1] }}</p>
                            
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Progress</span>
                                <span class="text-sm font-medium text-primary">{{ [75, 45, 90][$i-1] }}%</span>
                            </div>
                            
                            <div class="progress-bar-container">
                                <div class="progress-bar" style="width: {{ [75, 45, 90][$i-1] }}%"></div>
                            </div>
                            
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-xs text-gray-500">{{ [8, 5, 18][$i-1] }}/{{ [12, 10, 20][$i-1] }} lessons</span>
                                <a href="#" class="btn btn-primary">Continue</a>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </section>
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
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);
        
        // Observe all animated elements
        document.querySelectorAll('[class*="animate-"]').forEach((el, index) => {
            if (!el.style.animationName) {
                el.style.opacity = '0';
                el.style.transition = `opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1) ${index * 0.1}s, transform 0.8s cubic-bezier(0.4, 0, 0.2, 1) ${index * 0.1}s`;
                observer.observe(el);
            }
        });
        
        // Enhanced card hover effects
        document.querySelectorAll('.stat-card, .action-card, .progress-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
                this.style.boxShadow = 'var(--shadow-2xl)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = 'var(--shadow-lg)';
            });
        });
        
        // Animated counter for stats
        function animateCounter(element, target, duration = 2000) {
            let start = 0;
            const increment = target / (duration / 16);
            
            function updateCounter() {
                start += increment;
                if (start < target) {
                    element.textContent = Math.floor(start);
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            }
            
            updateCounter();
        }
        
        // Trigger counter animations when stats come into view
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const numberElement = entry.target.querySelector('.stat-number');
                    if (numberElement && !numberElement.classList.contains('animated')) {
                        const text = numberElement.textContent;
                        const target = parseInt(text.replace(/\D/g, ''));
                        numberElement.classList.add('animated');
                        
                        if (text.includes('.')) {
                            let current = 0;
                            const timer = setInterval(() => {
                                current += 0.1;
                                numberElement.textContent = current.toFixed(1);
                                if (current >= target) {
                                    clearInterval(timer);
                                    numberElement.textContent = target.toFixed(1);
                                }
                            }, 50);
                        } else {
                            animateCounter(numberElement, target);
                        }
                    }
                }
            });
        }, { threshold: 0.5 });
        
        document.querySelectorAll('.stat-card').forEach(card => {
            statsObserver.observe(card);
        });
        
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
        
        document.querySelectorAll('.progress-card, .activity-card').forEach(card => {
            progressObserver.observe(card);
        });
        
        // Add loading animation to buttons
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.href && !this.href.includes('#')) {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                }
            });
        });
    });
</script>
@endsection