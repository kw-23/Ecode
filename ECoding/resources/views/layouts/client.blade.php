<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="E0coding - Professional programming courses and tutorials for developers of all levels">
    <meta name="keywords" content="programming, coding, courses, tutorials, web development, software engineering">
    <meta name="author" content="E0coding">

    <title>
        @hasSection('title')
            @yield('title') - E0coding
        @else
            E0coding - Professional Programming Education
        @endif
    </title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- CSS -->
    <link href="{{ asset('css/client.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @yield('styles')

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased min-h-screen">
    <div class="min-h-screen flex flex-col" x-data="{ 
        mobileMenuOpen: false,
        scrolled: false,
        init() {
            this.handleScroll();
            window.addEventListener('scroll', () => this.handleScroll());
        },
        handleScroll() {
            this.scrolled = window.scrollY > 10;
        }
    }">
        <!-- Navigation -->
        <nav class="nav-container" :class="{ 'scrolled': scrolled }">
            <div class="nav-content">
                <!-- Logo Section -->
                <a href="{{ route('client.dashboard') }}" class="logo-container">
                    <div class="logo-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <span class="brand-text font-display">E0coding</span>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="nav-links">
                    <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('client.courses') }}" class="nav-link {{ request()->routeIs('client.courses') || request()->routeIs('client.course.detail') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Courses
                    </a>
                    <a href="{{ route('client.profile') }}" class="nav-link {{ request()->routeIs('client.profile') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>
                    <a href="{{ route('client.cart.index') }}" class="nav-link {{ request()->routeIs('client.cart.index') ? 'active' : '' }} relative">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007.5 17h9a1 1 0 00.9-1.45L17 13M7 13V6a1 1 0 011-1h7a1 1 0 011 1v7"></path>
                        </svg>
                        Cart
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="cart-badge">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    <a href="{{ route('client.purchased-courses') }}" class="nav-link {{ request()->routeIs('client.purchased-courses') ? 'active' : '' }}">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="nav-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>My Courses</span>
                    </a>
                </div>

                <!-- User Section -->
                <div class="user-section">
                    <!-- Desktop User Dropdown -->
                    <div class="hidden lg:block relative" x-data="{ open: false }" @click.away="open = false">
                        @php
                            $user = auth()->guard('client')->user();
                        @endphp

                        <button @click="open = !open" class="user-button flex items-center space-x-2">
                            @if($user && $user->image && file_exists(public_path($user->image)))
                                <div class="user-avatar w-10 h-10 rounded-full overflow-hidden">
                                    <img src="{{ asset($user->image) }}" 
                                         alt="User Avatar" 
                                         class="w-full h-full object-cover"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="user-avatar avatar-placeholder w-10 h-10 rounded-full bg-gray-400 text-white items-center justify-center text-lg font-semibold" style="display: none;">
                                        {{ strtoupper(substr($user->name ?? 'G', 0, 1)) }}
                                    </div>
                                </div>
                            @else
                                <div class="user-avatar avatar-placeholder w-10 h-10 rounded-full bg-gray-400 text-white flex items-center justify-center text-lg font-semibold">
                                    {{ strtoupper(substr($user->name ?? 'G', 0, 1)) }}
                                </div>
                            @endif

                            <div class="user-info text-left hidden md:block">
                                <div class="user-name font-medium">{{ $user->name ?? 'Guest' }}</div>
                                <div class="user-email text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($user->email ?? '', 20) }}</div>
                            </div>

                            <svg class="dropdown-arrow w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="dropdown-menu"
                             style="display: none;">
                            <a href="{{ route('client.profile') }}" class="dropdown-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile Settings
                            </a>
                            <a href="{{ route('client.password') }}" class="dropdown-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('client.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item danger">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="mobile-menu-button">
                        <svg :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="mobile-menu lg:hidden"
                 style="display: none;">
                <div class="py-3">
                    <a href="{{ route('client.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('client.courses') }}" class="mobile-nav-link {{ request()->routeIs('client.courses') || request()->routeIs('client.course.detail') ? 'active' : '' }}">
                        Courses
                    </a>
                    <a href="{{ route('client.profile') }}" class="mobile-nav-link {{ request()->routeIs('client.profile') ? 'active' : '' }}">
                        Profile
                    </a>
                    <a href="{{ route('client.cart.index') }}" class="mobile-nav-link {{ request()->routeIs('client.cart.index') ? 'active' : '' }}">
                        Cart
                        @if(session('cart') && count(session('cart')) > 0)
                            ({{ count(session('cart')) }})
                        @endif
                    </a>
                </div>
                
                <div class="border-t border-gray-200 py-3">
                    <div class="mobile-user-info">
                        <div class="mobile-user-name">{{ auth()->guard('client')->user()->name ?? 'Guest' }}</div>
                        <div class="mobile-user-email">{{ auth()->guard('client')->user()->email ?? '' }}</div>
                    </div>
                    <a href="{{ route('client.profile') }}" class="mobile-nav-link">Profile Settings</a>
                    <a href="{{ route('client.password') }}" class="mobile-nav-link">Change Password</a>
                    <form method="POST" action="{{ route('client.logout') }}">
                        @csrf
                        <button type="submit" class="mobile-nav-link text-red-600">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="main-container page-content">
                <!-- Success Alert -->
                @if (session('success'))
                    <div class="alert alert-success fade-in">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="alert-content">
                            <div class="alert-title">Success!</div>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Error Alert -->
                @if (session('error'))
                    <div class="alert alert-error fade-in">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="alert-content">
                            <div class="alert-title">Error!</div>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-error fade-in">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="alert-content">
                            <div class="alert-title">Please fix the following errors:</div>
                            <ul style="margin-top: 0.5rem; padding-left: 1rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-content">
                    <div class="footer-grid">
                        <div class="footer-brand-section">
                            <div class="footer-brand">
                                <div class="logo-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </div>
                                <span class="footer-brand-text font-display">E0coding</span>
                            </div>
                            <p class="footer-description">
                                Empowering developers worldwide with cutting-edge, accessible education. Join thousands of students on their transformative journey to mastering modern programming technologies.
                            </p>
                            <div class="social-links">
                                <a href="#" class="social-link" aria-label="Facebook">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#" class="social-link" aria-label="Twitter">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"></path>
                                    </svg>
                                </a>
                                <a href="#" class="social-link" aria-label="LinkedIn">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="#" class="social-link" aria-label="GitHub">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="footer-section">
                            <h3>Quick Links</h3>
                            <ul class="footer-links">
                                <li><a href="{{ route('client.courses') }}" class="footer-link">All Courses</a></li>
                                <li><a href="#" class="footer-link">Certificates</a></li>
                                <li><a href="#" class="footer-link">Instructors</a></li>
                                <li><a href="#" class="footer-link">Help Center</a></li>
                                <li><a href="#" class="footer-link">Community</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="footer-bottom-content">
                        <p class="footer-copyright">
                            &copy; {{ date('Y') }} E0coding. All rights reserved. Empowering education worldwide.
                        </p>
                        <div class="footer-bottom-links">
                            <a href="#" class="footer-link">Status</a>
                            <a href="#" class="footer-link">Blog</a>
                            <a href="#" class="footer-link">Careers</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @yield('scripts')
</body>
</html>