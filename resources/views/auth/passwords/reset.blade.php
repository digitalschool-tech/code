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
                    Create a new password for your account
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-gradient-to-b from-[#002780] to-[#0A0A2A] rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-4">
                            <label for="email" class="block text-blue-300 mb-1 text-sm font-medium">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input id="email" type="email" class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>
                            </div>
                            @error('email')
                                <p class="text-[#FF5252] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-blue-300 mb-1 text-sm font-medium">New Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password" type="password" class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors" name="password" required autocomplete="new-password">
                            </div>
                            @error('password')
                                <p class="text-[#FF5252] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password-confirm" class="block text-blue-300 mb-1 text-sm font-medium">Confirm Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <input id="password-confirm" type="password" class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="w-full bg-[#7BFF00] hover:bg-opacity-90 text-[#001E5F] font-bold py-3 px-4 rounded-lg transition-colors shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
