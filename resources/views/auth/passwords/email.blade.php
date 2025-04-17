@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-[#001E5F] to-[#0A0A2A] overflow-hidden">
    <!-- Wave Pattern Background -->
    <div class="absolute inset-0 z-0 opacity-20">
        <svg viewBox="0 0 1200 200" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
            class="h-full w-full">
            <path d="M0,100 C150,200 350,0 500,100 C650,200 850,0 1000,100 C1150,200 1350,0 1500,100 V200 H0 Z"
                fill="#4682B4"></path>
        </svg>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 pt-[140px] pb-16 relative z-10">
        <div class="max-w-md mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="bg-[#7BFF00] p-2 rounded-md inline-block mb-4">
                    <svg class="w-8 h-8 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Reset Password</h1>
                <p class="text-blue-300">
                    Enter your email address and we'll send you a link to reset your password
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-gradient-to-b from-[#002780] to-[#0A0A2A] rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-8">
                    @if (session('status'))
                        <div class="bg-[#124C00] bg-opacity-30 border border-[#7BFF00] text-[#7BFF00] rounded-lg p-4 mb-6">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="email" class="block text-blue-300 mb-1 text-sm font-medium">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input id="email" type="email" class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                                <p class="text-[#FF5252] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="w-full bg-[#7BFF00] hover:bg-opacity-90 text-[#001E5F] font-bold py-3 px-4 rounded-lg transition-colors shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>

                    <div class="text-center text-blue-200 text-sm mt-6">
                        <a href="{{ route('login') }}" class="text-[#7BFF00] hover:underline">
                            Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
