<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Client Registration - {{ config('app.name', 'Client Portal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#c7c3fa] min-h-screen flex items-center justify-center">
    <div class="w-full max-w-5xl mx-auto bg-white/0 rounded-lg shadow-lg flex overflow-hidden min-h-[600px]">
        <!-- Left: Register Form -->
        <div class="w-full md:w-1/2 bg-white flex flex-col justify-center p-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Register</h2>
            <form method="POST" action="{{ route('client.register') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required autocomplete="tel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" required autocomplete="street-address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                        <input id="city" type="text" name="city" value="{{ old('city') }}" required autocomplete="address-level2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                        <input id="state" type="text" name="state" value="{{ old('state') }}" required autocomplete="address-level1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                    <input id="zip_code" type="text" name="zip_code" value="{{ old('zip_code') }}" required autocomplete="postal-code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('zip_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <button type="submit" class="w-full px-4 py-2 bg-[#a89ff3] border border-transparent rounded-md font-semibold text-white hover:bg-[#7c6ee5] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">Register</button>
                </div>
            </form>
        </div>
        <!-- Right: Image & Text -->
        <div class="hidden md:flex md:w-1/2 relative items-center justify-center bg-cover bg-center" style="background-image: url('/images/lop.jpg');">
            <div class="absolute inset-0 bg-[#3a2567]/70"></div>
            <div class="relative z-10 flex flex-col justify-center items-start h-full p-12"><h1 class="text-6xl font-extrabold text-white leading-tight mb-4 drop-shadow-lg">
                Devenez développeur.<br>À votre rythme.
            </h1>
            <p class="text-white text-base mb-8 max-w-xs">
                Avec <span class="font-semibold">Ecoding</span>, apprenez à coder grâce à des cours en ligne simples, efficaces et accessibles partout.
            </p>
            <div>
                    <span class="text-white text-sm">Do you have an account?</span>
                    <a href="{{ route('client.login') }}" class="block mt-2 px-8 py-2 bg-white text-[#7c6ee5] font-semibold rounded shadow hover:bg-gray-100 transition">Login</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
