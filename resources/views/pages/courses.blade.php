@extends('layouts.app')

@section('content')
@include('organisms.header')

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
        <!-- Header with House-Aware Greeting -->
        <div class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <div class="bg-[#7BFF00] p-2 rounded-md inline-block mb-4">
                    <svg class="w-8 h-8 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.747 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">All Courses</h1>
                <p class="text-blue-300 text-xl">
                    Welcome {{ auth()->user()->name }}, discover all {{ ucfirst(auth()->user()->house) }} House courses
                </p>
            </div>
            
            <!-- User's House Display -->
            <div class="mt-6 md:mt-0 flex items-center bg-[#00162F] bg-opacity-70 rounded-lg p-4 border border-[#00417A]">
                <div class="w-14 h-14 {{ auth()->user()->getHouseColor() }} rounded-full flex items-center justify-center mr-4">
                    <img src="{{ url('images/' . auth()->user()->getHouseIcon()) }}" alt="{{ ucfirst(auth()->user()->house) }} House" class="w-10 h-10 object-contain">
                </div>
                <div>
                    <p class="text-white font-bold">{{ ucfirst(auth()->user()->house) }} House</p>
                    <p class="text-blue-300 text-sm">Your chosen house</p>
                </div>
            </div>
        </div>

        @include("organisms.houses_focus")

        <!-- Courses Grid with Progress Tracking -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
            @foreach($courses as $course)
                <a href="{{ !$course['is_locked'] ? route('course.show', $course['id']) : '#' }}" 
                   class="group {{ $course['is_locked'] ? 'cursor-not-allowed' : '' }}">
                    <div class="bg-[#00162F] rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-[#001E5F]/30 border border-[#00417A] hover:{{ !$course['is_locked'] ? $course['style']['border'] : '' }} h-full {{ $course['is_locked'] ? 'opacity-50' : '' }}">
                        <div class="{{ $course['style']['bg'] }} p-4 relative overflow-hidden flex justify-between items-start">
                            <h3 class="text-2xl font-bold text-white z-10 pr-16">{{ $course['name'] }}</h3>
                            
                            <!-- Course Icon -->
                            <div class="absolute -bottom-4 -right-4 w-16 h-16 rounded-full {{ $course['style']['bg'] }} flex items-center justify-center">
                                <img src="{{ url('images/' . $course['style']['icon']) }}" alt="Course House" class="w-12 h-12 object-contain">
                                
                                <!-- Lock Icon for Locked Courses -->
                                @if($course['is_locked'])
                                    <div class="absolute inset-0 bg-black bg-opacity-60 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <p class="text-blue-200 mb-4">{{ $course['description'] }}</p>
                            
                            <!-- Stats Row -->
                            <div class="flex text-sm text-blue-300 mb-4">
                                <div class="flex items-center mr-4">
                                    <svg class="w-4 h-4 {{ $course['style']['text'] }} mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.747 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    {{ $course['lesson_count'] }} Lessons
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 {{ $course['style']['text'] }} mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    {{ $course['level_count'] }} Levels
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-xs text-blue-300 mb-1">
                                    <span>Progress</span>
                                    <span>{{ round($course['progress']['progress']) }}%</span>
                                </div>
                                <div class="h-1.5 bg-[#001E5F] rounded-full overflow-hidden">
                                    <div class="h-full {{ $course['style']['bg'] }}" style="width: {{ $course['progress']['progress'] }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Start/Continue Button -->
                            <div class="mt-2">
                                <div class="flex items-center justify-between">
                                    @if($course['is_locked'])
                                        <span class="text-xs text-blue-300">Complete previous course to unlock</span>
                                        <div class="bg-[#001E5F] rounded-lg px-3 py-1.5 flex items-center">
                                            <span class="text-gray-400 text-sm font-medium mr-1">Locked</span>
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        @if($course['progress']['status'] === 'in_progress')
                                            <span class="text-xs text-blue-300">Continue where you left off</span>
                                            <div class="group-hover:{{ $course['style']['bg'] }} bg-[#001E5F] rounded-lg transition-colors px-3 py-1.5 flex items-center">
                                                <span class="text-white text-sm font-medium mr-1">Continue</span>
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        @elseif($course['progress']['status'] === 'completed')
                                            <span class="text-xs {{ $course['style']['text'] }}">Completed ✓</span>
                                            <div class="group-hover:{{ $course['style']['bg'] }} bg-[#001E5F] rounded-lg transition-colors px-3 py-1.5 flex items-center">
                                                <span class="text-white text-sm font-medium mr-1">Review</span>
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <span class="text-xs text-blue-300">Learn at your own pace</span>
                                            <div class="group-hover:{{ $course['style']['bg'] }} bg-[#001E5F] rounded-lg transition-colors px-3 py-1.5 flex items-center">
                                                <span class="text-white text-sm font-medium mr-1">Start</span>
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- House Character Grid -->
        <div class="bg-[#00162F] rounded-xl overflow-hidden mb-16">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-white mb-4">House Characters</h2>
                <p class="text-blue-300 mb-6">Learn with our mascots from each house and discover their unique coding styles</p>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-[#124C00] bg-opacity-70 p-4 rounded-lg text-center transition-transform hover:scale-105">
                        <div class="bg-[#124C00] w-16 h-16 mx-auto rounded-full mb-3 flex items-center justify-center">
                            <img src="{{ url('images/engineer.png') }}" alt="Engineers" class="w-12 h-12 object-contain">
                        </div>
                        <h3 class="text-white font-bold">Engineers</h3>
                        <p class="text-[#7BFF00] text-xs">Building Robust Code</p>
                    </div>
                    
                    <div class="bg-[#7A0025] bg-opacity-70 p-4 rounded-lg text-center transition-transform hover:scale-105">
                        <div class="bg-[#7A0025] w-16 h-16 mx-auto rounded-full mb-3 flex items-center justify-center">
                            <img src="{{ url('images/speedsters.png') }}" alt="Speedsters" class="w-12 h-12 object-contain">
                        </div>
                        <h3 class="text-white font-bold">Speedsters</h3>
                        <p class="text-[#FF5252] text-xs">Fast & Efficient Solutions</p>
                    </div>
                    
                    <div class="bg-[#3A005A] bg-opacity-70 p-4 rounded-lg text-center transition-transform hover:scale-105">
                        <div class="bg-[#3A005A] w-16 h-16 mx-auto rounded-full mb-3 flex items-center justify-center">
                            <img src="{{ url('images/hipsters.png') }}" alt="Hipsters" class="w-12 h-12 object-contain">
                        </div>
                        <h3 class="text-white font-bold">Hipsters</h3>
                        <p class="text-[#A034D9] text-xs">Creative Approaches</p>
                    </div>
                    
                    <div class="bg-[#00417A] bg-opacity-70 p-4 rounded-lg text-center transition-transform hover:scale-105">
                        <div class="bg-[#00417A] w-16 h-16 mx-auto rounded-full mb-3 flex items-center justify-center">
                            <img src="{{ url('images/shadows.png') }}" alt="Shadows" class="w-12 h-12 object-contain">
                        </div>
                        <h3 class="text-white font-bold">Shadows</h3>
                        <p class="text-[#00A0FF] text-xs">Deep Problem Solving</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="bg-[#00162F] rounded-xl overflow-hidden">
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <div class="bg-[#7BFF00] p-2 rounded-md inline-block mb-4">
                        <svg class="w-6 h-6 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Stay Updated</h2>
                    <p class="text-blue-300 mb-6">Subscribe to our newsletter to get updates on new courses, coding tips, and events.</p>
                    
                    <form class="space-y-4">
                        <div>
                            <label for="email" class="block text-blue-300 mb-1 text-sm font-medium">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-[#00417A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" placeholder="your@email.com" required
                                    class="bg-[#001E5F] bg-opacity-70 border border-[#00417A] text-white rounded-lg block w-full pl-10 p-2.5 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#7BFF00] focus:border-[#7BFF00] transition-colors">
                            </div>
                        </div>
                        
                        <button type="submit" class="bg-[#7BFF00] hover:bg-opacity-90 text-[#001E5F] font-bold py-2.5 px-4 rounded-lg transition-colors shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            Subscribe
                        </button>
                    </form>
                </div>
                
                <div class="flex items-center justify-center">
                    <div class="grid grid-cols-2 gap-4 max-w-md">
                        <div class="bg-[#124C00] p-3 rounded-full w-24 h-24 flex items-center justify-center">
                            <img src="{{ url('images/engineer.png') }}" alt="Engineers House" class="w-16 h-16 object-contain">
                        </div>
                        <div class="bg-[#7A0025] p-3 rounded-full w-24 h-24 flex items-center justify-center">
                            <img src="{{ url('images/speedsters.png') }}" alt="Speedsters House" class="w-16 h-16 object-contain">
                        </div>
                        <div class="bg-[#3A005A] p-3 rounded-full w-24 h-24 flex items-center justify-center">
                            <img src="{{ url('images/hipsters.png') }}" alt="Hipsters House" class="w-16 h-16 object-contain">
                        </div>
                        <div class="bg-[#00417A] p-3 rounded-full w-24 h-24 flex items-center justify-center">
                            <img src="{{ url('images/shadows.png') }}" alt="Shadows House" class="w-16 h-16 object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 