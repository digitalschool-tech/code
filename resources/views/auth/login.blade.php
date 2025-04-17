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
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Welcome Back!</h1>
                <p class="text-blue-300">
                    Log in to continue your coding journey
                </p>
            </div>

            <!-- Login Form Card -->
            <div class="bg-gradient-to-b from-[#002780] to-[#0A0A2A] rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        
                        <!-- Store redirect parameter if provided -->
                        @if(isset($redirect))
                            <input type="hidden" name="redirect" value="{{ $redirect }}">
                        @endif
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-blue-300 mb-1 text-sm font-medium">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors">
                            </div>
                            @error('email')
                                <p class="text-[#FF5252] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label for="password" class="block text-blue-300 text-sm font-medium">Password</label>
                                <a href="{{ route('password.request') }}" class="text-[#7BFF00] text-xs hover:underline">
                                    Forgot Password?
                                </a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input type="password" id="password" name="password" required
                                    class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors">
                            </div>
                            @error('password')
                                <p class="text-[#FF5252] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" 
                                class="w-4 h-4 border border-[#00417A] rounded bg-[#001E5F] focus:ring-[#7BFF00] text-[#7BFF00]" 
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 text-sm text-blue-300">
                                Remember me
                            </label>
                        </div>
                        
                        <!-- Login Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full bg-[#7BFF00] hover:bg-opacity-90 text-[#001E5F] font-bold py-3 px-4 rounded-lg transition-colors shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Log In
                            </button>
                        </div>
                    </form>
                    
                    <!-- Register Link -->
                    <div class="text-center text-blue-200 text-sm mt-8">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-[#7BFF00] hover:underline">Sign up here</a>
                    </div>
                </div>
            </div>

            <!-- House Icons Row - Just for decoration, not functional -->
            <div class="flex justify-center mt-8 space-x-6">
                <div class="bg-[#124C00] p-2 rounded-full w-14 h-14 flex items-center justify-center transform hover:scale-110 transition-all">
                    <img src="{{ url('images/engineer.png') }}" alt="Engineers House" class="w-10 h-10 object-contain engineers-outline">
                </div>
                <div class="bg-[#7A0025] p-2 rounded-full w-14 h-14 flex items-center justify-center transform hover:scale-110 transition-all">
                    <img src="{{ url('images/speedsters.png') }}" alt="Speedsters House" class="w-10 h-10 object-contain speedsters-outline">
                </div>
                <div class="bg-[#3A005A] p-2 rounded-full w-14 h-14 flex items-center justify-center transform hover:scale-110 transition-all">
                    <img src="{{ url('images/hipsters.png') }}" alt="Hipsters House" class="w-10 h-10 object-contain hipsters-outline">
                </div>
                <div class="bg-[#00417A] p-2 rounded-full w-14 h-14 flex items-center justify-center transform hover:scale-110 transition-all">
                    <img src="{{ url('images/shadows.png') }}" alt="Shadows House" class="w-10 h-10 object-contain shadows-outline">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
