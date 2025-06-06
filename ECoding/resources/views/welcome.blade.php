<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E0coding - Programming Language PDF Courses</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|fira-code:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Tailwind CSS styles from original file */
            </style>
        @endif
        
        <style>
            .code-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23000000' fillOpacity='0.03' fillRule='evenodd'/%3E%3C/svg%3E");
                background-size: 150px 150px;
            }
            
            .dark .code-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fillOpacity='0.05' fillRule='evenodd'/%3E%3C/svg%3E");
            }
            
            .code-text {
                font-family: 'Fira Code', monospace;
            }
            
            .gradient-text {
                background: linear-gradient(90deg, #3b82f6, #8b5cf6);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-fill-color: transparent;
            }
            
            .dark .gradient-text {
                background: linear-gradient(90deg, #60a5fa, #a78bfa);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-fill-color: transparent;
            }
            
            .feature-card {
                transition: all 0.3s ease;
            }
            
            .feature-card:hover {
                transform: translateY(-5px);
            }
            
            .code-block {
                position: relative;
                overflow: hidden;
                border-radius: 0.5rem;
            }
            
            .code-block::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(45deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
                z-index: -1;
            }
            
            .dark .code-block::before {
                background: linear-gradient(45deg, rgba(96, 165, 250, 0.1), rgba(167, 139, 250, 0.1));
            }
        </style>
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased">
        <div class="min-h-screen flex flex-col">
            <!-- Header -->
            <header class="border-b border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center">
                                <span class="text-2xl font-bold gradient-text">E0coding</span>
                            </div>
                        </div>
                       <!-- Dans la section Header, à l'intérieur de la div avec la classe "flex items-center" -->
<div class="flex items-center">
    @if (Route::has('login'))
        <div class="hidden space-x-4 sm:flex">
            @auth
                {{-- Authentifié comme user (guard web) --}}
                <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Dashboard
                </a>
            @else
                @if(Auth::guard('client')->check())
                    {{-- Authentifié comme client --}}
                    <a href="{{ route('client.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Client Dashboard
                    </a>
                @else
                    {{-- Non authentifié : afficher les options de connexion --}}
                    <a href="{{ route('client.login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Client Login
                    </a>

                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Admin Login
                    </a>

                    
                @endif
            @endauth
        </div>
    @endif
</div>

                        
                        
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-grow">
                <!-- Hero Section -->
                <section class="relative overflow-hidden code-pattern">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
                        <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                                    <span class="block">Master Programming with</span>
                                    <span class="block gradient-text">E0coding PDF Courses</span>
                                </h1>
                                <p class="mt-3 text-base text-gray-600 dark:text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                    Comprehensive, well-structured PDF guides to help you learn programming languages efficiently. From beginners to advanced developers.
                                </p>
                                <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">
                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <a href="#courses" class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Explore Courses
                                        </a>
                                        <a href="#about" class="flex items-center justify-center px-5 py-3 border border-gray-300 dark:border-gray-700 text-base font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                                <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md code-block">
                                    <div class="relative block w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                                        <div class="px-4 pt-3 pb-2 border-b border-gray-200 dark:border-gray-700 flex items-center">
                                            <div class="flex space-x-1.5">
                                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                            </div>
                                            <div class="ml-4 text-xs text-gray-500 dark:text-gray-400 code-text">main.js</div>
                                        </div>
                                        <div class="p-4">
                                            <pre class="text-sm code-text text-gray-800 dark:text-gray-200"><span class="text-purple-600 dark:text-purple-400">function</span> <span class="text-blue-600 dark:text-blue-400">learnToCode</span>() {
  <span class="text-purple-600 dark:text-purple-400">const</span> languages = [<span class="text-green-600 dark:text-green-400">'JavaScript'</span>, <span class="text-green-600 dark:text-green-400">'Python'</span>, <span class="text-green-600 dark:text-green-400">'Java'</span>];
  <span class="text-purple-600 dark:text-purple-400">const</span> platform = <span class="text-green-600 dark:text-green-400">'E0coding'</span>;
  
  <span class="text-purple-600 dark:text-purple-400">return</span> <span class="text-blue-600 dark:text-blue-400">languages.map</span>(lang => {
    <span class="text-purple-600 dark:text-purple-400">return</span> <span class="text-green-600 dark:text-green-400">`Master ${lang} with ${platform}!`</span>;
  });
}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Features Section -->
                <section id="about" class="py-12 bg-white dark:bg-gray-800">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center">
                            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                                Why Choose E0coding?
                            </h2>
                            <p class="mt-4 max-w-2xl text-xl text-gray-600 dark:text-gray-300 mx-auto">
                                Our PDF courses are designed with developers in mind
                            </p>
                        </div>

                        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            <!-- Feature 1 -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow-sm p-6 feature-card">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="mt-5">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Comprehensive PDF Guides</h3>
                                    <p class="mt-2 text-base text-gray-600 dark:text-gray-300">
                                        Detailed, well-structured content that covers everything from basic syntax to advanced concepts.
                                    </p>
                                </div>
                            </div>

                            <!-- Feature 2 -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow-sm p-6 feature-card">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                </div>
                                <div class="mt-5">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Practical Examples</h3>
                                    <p class="mt-2 text-base text-gray-600 dark:text-gray-300">
                                        Learn by doing with real-world code examples and projects that reinforce your understanding.
                                    </p>
                                </div>
                            </div>

                            <!-- Feature 3 -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg shadow-sm p-6 feature-card">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div class="mt-5">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Learn at Your Own Pace</h3>
                                    <p class="mt-2 text-base text-gray-600 dark:text-gray-300">
                                        Download once and access anytime, anywhere. No internet connection required after download.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Courses Section -->
                <section id="courses" class="py-12 bg-gray-50 dark:bg-gray-900">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center">
                            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                                Popular Programming Courses
                            </h2>
                            <p class="mt-4 max-w-2xl text-xl text-gray-600 dark:text-gray-300 mx-auto">
                                Start your coding journey with our best-selling PDF guides
                            </p>
                        </div>

                        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            <!-- Course 1 -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">JavaScript Mastery</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">From basics to advanced concepts</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-base text-gray-600 dark:text-gray-300">
                                            Comprehensive guide covering ES6+, DOM manipulation, async programming, and modern frameworks.
                                        </p>
                                    </div>
                                   
                                </div>
                            </div>

                            <!-- Course 2 -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Python Programming</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Data science & automation</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-base text-gray-600 dark:text-gray-300">
                                            Learn Python for data analysis, machine learning, web development, and task automation.
                                        </p>
                                    </div>
                                    
                                </div>
                            </div>

                            <!-- Course 3 -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">SQL Database Design</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Database fundamentals & optimization</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-base text-gray-600 dark:text-gray-300">
                                            Master database design, SQL queries, performance tuning, and data modeling techniques.
                                        </p>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 text-center">
                            @if(Auth::guard('client')->check() || Auth::check())
                                <a href="{{ route('client.courses') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Browse All Courses
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('client.login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Browse All Courses
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- Testimonials Section -->
                <section class="py-12 bg-white dark:bg-gray-800">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center">
                            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                                What Our Students Say
                            </h2>
                            <p class="mt-4 max-w-2xl text-xl text-gray-600 dark:text-gray-300 mx-auto">
                                Success stories from developers who learned with our PDF courses
                            </p>
                        </div>

                        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            <!-- Testimonial 1 -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-base text-gray-600 dark:text-gray-300">
                                            "The JavaScript course was incredibly comprehensive. I went from knowing basic syntax to building complex applications. The PDF format made it easy to reference concepts whenever I needed."
                                        </p>
                                        <div class="mt-4">
                                            <p class="text-base font-medium text-gray-900 dark:text-white">Alex Johnson</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Frontend Developer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Testimonial 2 -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-base text-gray-600 dark:text-gray-300">
                                            "I've tried many online courses, but E0coding's Python PDF guide was the most structured and practical. I could learn offline and at my own pace, which was perfect for my busy schedule."
                                        </p>
                                        <div class="mt-4">
                                            <p class="text-base font-medium text-gray-900 dark:text-white">Sarah Miller</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Data Scientist</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Testimonial 3 -->
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-base text-gray-600 dark:text-gray-300">
                                            "The SQL course helped me land my first database administrator job. The examples were practical and the explanations were clear. I still reference it regularly at work."
                                        </p>
                                        <div class="mt-4">
                                            <p class="text-base font-medium text-gray-900 dark:text-white">Michael Chen</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Database Administrator</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- CTA Section -->
                <section class="py-12 bg-indigo-600">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center">
                            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                                Ready to Start Your Coding Journey?
                            </h2>
                            <p class="mt-4 max-w-2xl text-xl text-indigo-100 mx-auto">
                                Join thousands of developers who have accelerated their careers with E0coding
                            </p>
                            <div class="mt-8 flex justify-center">
                                @if(Auth::guard('client')->check())
                                    <div class="inline-flex rounded-md shadow">
                                        <a href="{{ route('client.dashboard') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Get Started Today
                                        </a>
                                    </div>
                                @elseif(!Auth::check())
                                    <div class="inline-flex rounded-md shadow">
                                        <a href="{{ route('client.login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Get Started Today
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="flex justify-center md:justify-start">
                            <span class="text-xl font-bold gradient-text">E0coding</span>
                        </div>
                        <div class="mt-8 md:mt-0">
                            <p class="text-center text-base text-gray-500 dark:text-gray-400">
                                &copy; {{ date('Y') }} E0coding. All rights reserved.
                            </p>
                        </div>
                    </div>
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-800 pt-8 md:flex md:items-center md:justify-between">
                        <div class="flex justify-center space-x-6 md:justify-start">
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">GitHub</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                        <div class="mt-8 md:mt-0 flex justify-center space-x-6 md:justify-end">
                            <a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                                Privacy Policy
                            </a>
                            <a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                                Terms of Service
                            </a>
                            <a href="#" class="text-base text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>