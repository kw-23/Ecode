@extends('layouts.client')

@section('title', 'Payment Successful')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                Payment Successful!
            </h2>
            
            <p class="text-gray-600 mb-8">
                Thank you for your purchase. You now have access to the course.
            </p>
            
            @if(isset($course))
            <div class="bg-white shadow rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Course Details</h3>
                <div class="text-left space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Course:</span>
                        <span class="font-medium">{{ $course->title }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Price:</span>
                        <span class="font-medium">${{ number_format($course->price, 2) }}</span>
                    </div>
                    @if(isset($paymentIntentId))
                    <div class="flex justify-between">
                        <span class="text-gray-600">Transaction ID:</span>
                        <span class="font-mono text-xs">{{ $paymentIntentId }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <div class="space-y-4">
                <a href="{{ route('client.course.show', $course) }}" 
                   class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Start Learning
                </a>
                
                <a href="{{ route('client.dashboard') }}" 
                   class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection