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
    <div class="container mx-auto px-4 pt-[120px] pb-16 relative z-10">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-10">
                <div class="bg-[#7BFF00] p-2 rounded-md inline-block mb-4">
                    <svg class="w-8 h-8 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Join the Coding Adventure</h1>
                <p class="text-blue-300 text-xl max-w-2xl mx-auto">
                    Create your account, choose your house, and begin your journey to becoming a coding master.
                </p>
            </div>

            <!-- Main Form Card -->
            <div class="bg-gradient-to-b from-[#002780] to-[#0A0A2A] rounded-2xl shadow-2xl overflow-hidden relative">
                <!-- Forms Container -->
                <div class="md:flex">
                    <!-- Left Side: Signup Form -->
                    <div class="w-full md:w-1/2 p-8">
                        <h2 class="text-2xl font-bold text-white mb-6">Create Your Account</h2>
                        
                        <form method="POST" action="{{ route('register') }}" id="registrationForm" class="space-y-5">
                            @csrf
                            
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-blue-300 mb-1 text-sm font-medium">Full Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                                        class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors">
                                </div>
                                @error('name')
                                    <p class="text-[#FF5252] text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-blue-300 mb-1 text-sm font-medium">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                        class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors">
                                </div>
                                @error('email')
                                    <p class="text-[#FF5252] text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-blue-300 mb-1 text-sm font-medium">Password</label>
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
                            
                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-blue-300 mb-1 text-sm font-medium">Confirm Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required 
                                        class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors">
                                </div>
                            </div>
                            
                            <!-- Hidden house field - will be updated by JavaScript -->
                            <input type="hidden" name="house" id="selectedHouse" value="engineer">
                            
                            <!-- Submit Button back on left side -->
                            <div class="pt-2">
                                <button type="submit" class="w-full bg-[#7BFF00] hover:bg-opacity-90 text-[#001E5F] font-bold py-3 px-4 rounded-lg transition-colors shadow-lg flex items-center justify-center" id="submitButton">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Create Account
                                </button>
                            </div>
                            
                            <!-- Already have account -->
                            <div class="text-center text-blue-200 text-sm mt-6">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-[#7BFF00] hover:underline">Log in here</a>
                            </div>
                            
                            <!-- Errors Display -->
                            @if ($errors->any())
                                <div class="bg-[#240000] bg-opacity-30 p-3 rounded-lg border border-[#FF5252] mt-4">
                                    <ul class="list-disc pl-5 text-[#FF5252] text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                    
                    <!-- Right Side: House Selection -->
                    <div class="w-full md:w-1/2 bg-[#00162F] p-8 border-t md:border-t-0 md:border-l border-[#00417A]">
                        <h2 class="text-2xl font-bold text-white mb-6">Choose Your House</h2>
                        <p class="text-blue-300 mb-6">Select the house that best represents your coding style and personality. Your house will be your team throughout your learning journey!</p>
                        
                        <div class="space-y-4">
                            <!-- House Selection Inputs - These are now outside the form but will update the hidden field -->
                            <label class="block cursor-pointer house-option" data-house="engineer">
                                <input type="radio" name="house_selection" value="engineer" class="sr-only peer house-radio" checked>
                                <div class="flex items-center p-3 rounded-lg border border-[#00417A] peer-checked:border-[#7BFF00] peer-checked:bg-[#124C00] peer-checked:bg-opacity-30 transition-colors">
                                    <div class="bg-[#124C00] p-2 rounded-full flex items-center justify-center mr-4">
                                        <img src="{{ url('images/engineer.png') }}" alt="Engineer House" class="w-12 h-12 object-contain house-icon">
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold">Engineer House</h3>
                                        <p class="text-blue-300 text-sm">Strategic thinkers who build robust solutions.</p>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="block cursor-pointer house-option" data-house="speedster">
                                <input type="radio" name="house_selection" value="speedster" class="sr-only peer house-radio">
                                <div class="flex items-center p-3 rounded-lg border border-[#00417A] peer-checked:border-[#FF5252] peer-checked:bg-[#7A0025] peer-checked:bg-opacity-30 transition-colors">
                                    <div class="bg-[#7A0025] p-2 rounded-full flex items-center justify-center mr-4">
                                        <img src="{{ url('images/speedsters.png') }}" alt="Speedster House" class="w-12 h-12 object-contain house-icon">
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold">Speedster House</h3>
                                        <p class="text-blue-300 text-sm">Fast learners who optimize for efficiency.</p>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="block cursor-pointer house-option" data-house="hipster">
                                <input type="radio" name="house_selection" value="hipster" class="sr-only peer house-radio">
                                <div class="flex items-center p-3 rounded-lg border border-[#00417A] peer-checked:border-[#A034D9] peer-checked:bg-[#3A005A] peer-checked:bg-opacity-30 transition-colors">
                                    <div class="bg-[#3A005A] p-2 rounded-full flex items-center justify-center mr-4">
                                        <img src="{{ url('images/hipsters.png') }}" alt="Hipster House" class="w-12 h-12 object-contain house-icon">
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold">Hipster House</h3>
                                        <p class="text-blue-300 text-sm">Creative innovators with unique perspectives.</p>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="block cursor-pointer house-option" data-house="shadow">
                                <input type="radio" name="house_selection" value="shadow" class="sr-only peer house-radio">
                                <div class="flex items-center p-3 rounded-lg border border-[#00417A] peer-checked:border-[#00A0FF] peer-checked:bg-[#00417A] peer-checked:bg-opacity-50 transition-colors">
                                    <div class="bg-[#00417A] p-2 rounded-full flex items-center justify-center mr-4">
                                        <img src="{{ url('images/shadows.png') }}" alt="Shadow House" class="w-12 h-12 object-contain house-icon">
                                    </div>
                                    <div>
                                        <h3 class="text-white font-bold">Shadow House</h3>
                                        <p class="text-blue-300 text-sm">Deep thinkers who solve complex problems.</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Selection Hint -->
                        <div class="mt-6 bg-[#001E5F] bg-opacity-50 p-4 rounded-lg border border-[#00417A]">
                            <p class="text-blue-100 text-sm">
                                <span class="text-[#7BFF00] font-medium">House Selection Tip:</span> 
                                Your house choice isn't permanent! You can change houses later as you discover more about your coding style.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Info Box -->
            <div class="mt-10 bg-[#00162F] bg-opacity-70 rounded-xl p-6 border border-[#00417A] shadow-lg">
                <div class="flex items-start">
                    <div class="bg-[#7BFF00] p-2 rounded-md mr-4">
                        <svg class="w-6 h-6 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-lg mb-2">About House System</h3>
                        <p class="text-blue-200">
                            Our house system encourages friendly competition and collaboration. Each house has its own strengths and specialties in the coding world. As you progress through courses, you'll earn points for your house and unlock special achievements!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="bg-[#00162F] mt-16 py-6 relative z-10">
        <div class="container mx-auto px-4 text-center">
            <p class="text-blue-300 text-sm">
                &copy; {{ date('Y') }} MSO Academy. All rights reserved. 
                <a href="#" class="text-[#7BFF00] hover:underline">Privacy Policy</a> | 
                <a href="#" class="text-[#7BFF00] hover:underline">Terms of Service</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Optional JavaScript for enhancing the house selection experience
    document.addEventListener('DOMContentLoaded', function() {
        const houseInputs = document.querySelectorAll('input[name="house_selection"]');
        
        houseInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Could add animations or other visual feedback here
                console.log('Selected house:', this.value);
            });
        });
    });
</script>
@endsection