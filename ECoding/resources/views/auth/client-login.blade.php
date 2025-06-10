<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Client Login - {{ config('app.name', 'Client Portal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#c7c3fa] min-h-screen flex items-center justify-center">
    <div class="w-full max-w-5xl mx-auto bg-white/0 rounded-lg shadow-lg flex overflow-hidden min-h-[600px]">
        <!-- Left: Image & Text -->
        <div class="hidden md:flex md:w-1/2 relative items-center justify-center bg-cover bg-center" style="background-image: url('/images/laap.jpg');">
            <div class="absolute inset-0 bg-[#3a2567]/70"></div>
            <div class="relative z-10 flex flex-col justify-center items-start h-full p-12">
                <h1 class="text-6xl font-extrabold text-white leading-tight mb-4 drop-shadow-lg">
                    Ecoding.
                </h1>
                <p class="text-white text-base mb-8 max-w-xs">
                    Apprenez à coder en ligne avec des cours pratiques et accessibles à tous. Progressez à votre rythme et construisez votre avenir dans le numérique.
                </p>
                
                
                <div>
                    <span class="text-white text-sm">Don't you have an account?</span>
                    <a href="{{ route('client.register') }}" class="block mt-2 px-8 py-2 bg-white text-[#7c6ee5] font-semibold rounded shadow hover:bg-gray-100 transition">Register</a>
                </div>
            </div>
        </div>
        <!-- Right: Login Form -->
        <div class="w-full md:w-1/2 bg-white flex flex-col justify-center p-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Login</h2>
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('client.login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Username</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600">Remember me</label>
                </div>
                <div class="flex items-center justify-between">
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot your password?</a>
                </div>
                <div>
                    <button type="submit" class="w-full px-4 py-2 bg-[#a89ff3] border border-transparent rounded-md font-semibold text-white hover:bg-[#7c6ee5] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
