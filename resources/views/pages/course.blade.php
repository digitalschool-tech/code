@extends('layouts.app')

@section('content')
@include('organisms.header')

<div class="min-h-screen bg-gradient-to-b from-[#001E5F] to-[#0A0A2A]">
    <!-- Course Header Section -->
    <div class="container mx-auto px-4 pt-[140px] pb-10">
        <div class="flex flex-col md:flex-row items-start gap-6 mb-10">
            <!-- Left Side: Course Info -->
            <div class="w-full md:w-2/3">
                <div class="bg-[#7BFF00] p-2 inline-block mb-3">
                    <svg class="w-6 h-6 text-[#001E5F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl text-white font-bold mb-3">{{ $course["name"] }}</h1>
                <p class="text-blue-300 text-lg mb-6">{{ $course["description"] }}</p>
                
                <!-- Course Stats -->
                <div class="flex text-sm text-white mb-4">
                    <div class="flex items-center mr-6">
                        <svg width="14" viewBox="0 0 9 12" class="mr-2 fill-current text-[#7BFF00]">
                            <g fill="none" fill-rule="evenodd">
                                <g class="fill-current">
                                    <path d="M2.858 5.15v4.415c0 .197-.11.371-.273.436-.231.092-.51.14-.808.14-.855 0-1.775-.396-1.775-1.266v-5.65c-.02-.389.1-1.074.676-1.445C.945 1.607 2.348.589 3.052.074c.125-.092.286-.098.417-.018.132.081.214.237.214.406v.669c0 .255-.183.462-.41.462-.175 0-.325-.125-.383-.302-.636.462-1.574 1.14-1.806 1.29-.21.136-.255.385-.264.52 0 .151.029.27.081.335.145.18.63.068 1.157-.29C2.566 2.802 5.067.92 5.092.902c.126-.095.287-.104.42-.023.133.08.216.237.216.408v.052c0 .155-.068.299-.182.385 0 0-1.736 1.31-1.89 1.42-.589.428-.798.953-.798 2.005zM9 2.92v5.998c0 .158-.072.306-.191.39 0 0-2.385 2.092-2.869 2.425-.254.175-.578.267-.936.267-.85 0-1.73-.52-1.73-1.389V4.878l.001-.006c.008-.338.078-.82.635-1.285.334-.278 2.321-1.809 2.406-1.873.125-.097.288-.107.421-.027.134.08.218.237.218.408v.67c0 .254-.183.461-.409.461-.169 0-.314-.115-.376-.28-.635.49-1.566 1.212-1.775 1.385-.263.22-.298.365-.303.551.001.138.034.243.101.313.209.216.77.125 1.324-.25.41-.278 2.176-1.819 2.822-2.389.124-.108.29-.128.431-.05.14.077.23.237.23.414zm-.818 2.059L6.137 6.77v.924l2.045-1.792v-.924z"></path>
                                </g>
                            </g>
                        </svg>
                        <span>{{ count($course["lessons"]) }} Mësime</span>
                    </div>
                    <div class="flex items-center">
                        <svg width="14" viewBox="0 0 10 13" class="mr-2 fill-current text-[#7BFF00]">
                            <g fill="none" fill-rule="evenodd">
                                <g class="fill-current">
                                    <path d="M5 2C2.25 2 0 4.25 0 7s2.25 5 5 5 5-2.25 5-5-2.25-5-5-5zm2.282 6.923L4.615 7.318v-3.01h.77v2.608l2.307 1.355-.41.652z"></path>
                                </g>
                            </g>
                        </svg>
                        <span>{{ $course['level_count'] }} Nivele</span>
                    </div>
                </div>

                <!-- Course Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between text-sm text-blue-300 mb-2">
                        <span>Your Progress</span>
                        <span>{{ round($courseProgress['progress']) }}% Complete</span>
                    </div>
                    <div class="w-full h-2 bg-[#0A0A2A] rounded-full overflow-hidden">
                        <div class="h-full" style="width: {{ $courseProgress['progress'] }}%; background-color: {{ $courseStyle['hex'] }}"></div>
                    </div>
                    <div class="mt-2 text-xs text-blue-300">
                        {{ $courseProgress['completed_levels'] }} of {{ $courseProgress['total_levels'] }} levels completed
                    </div>
                </div>
            </div>
            
            <!-- Right Side: House Icon -->
            <div class="w-full md:w-1/3 flex justify-center">
                <div style="background-color: {{ $courseStyle['hex'] }}" class="p-6 rounded-full w-40 h-40 flex items-center justify-center">
                    <style>
                        .{{ $courseStyle['outline'] }} { 
                            filter: drop-shadow(1px 0 0 white) drop-shadow(-1px 0 0 white) drop-shadow(0 1px 0 white) drop-shadow(0 -1px 0 white);
                        }
                    </style>
                    <img src="{{ url('images/' . $courseStyle['icon']) }}" alt="House Icon" class="w-32 h-32 object-contain {{ $courseStyle['outline'] }}">
                </div>
            </div>
        </div>
    
        <!-- Lessons Table with Sequential Unlocking -->
        <div class="bg-white bg-opacity-10 rounded-xl p-6 backdrop-blur-sm">
            <h2 class="text-2xl text-white font-bold mb-6">Course Content</h2>
            
            @foreach ($course["lessons"] as $lessonIndex => $lesson)
                <div class="mb-8 last:mb-0 {{ !$lesson['is_available'] ? 'opacity-50' : '' }}">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full {{ $lesson['is_available'] ? 'bg-[#7BFF00] text-[#001E5F]' : 'bg-gray-400 text-gray-700' }} flex items-center justify-center font-bold mr-3">
                            @if(!$lesson['is_available'])
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            @else
                                {{ $lessonIndex + 1 }}
                            @endif
                        </div>
                        <h3 class="text-xl text-white font-semibold">{{ $lesson["name"] }}</h3>
                    </div>
                    
                    <div class="ml-14">
                        <div class="flex flex-wrap gap-3 mb-2">
                            @foreach ($lesson["levels"] as $levelIndex => $level)
                                @if($level['is_locked'])
                                    <!-- Locked Level -->
                                    <div class="group transition-all cursor-not-allowed">
                                        <div class="w-12 h-12 rounded-full border-2 border-gray-500 bg-[#001E5F] bg-opacity-50 text-gray-400 flex justify-center items-center relative">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <!-- Tooltip on hover -->
                                        <div class="absolute hidden group-hover:block bg-[#001E5F] text-white text-xs p-2 rounded mt-2 w-40 z-10">
                                            Complete previous levels to unlock
                                        </div>
                                    </div>
                                @else
                                    <!-- Available or Completed Level -->
                                    <a href="{{ route('level.show', [
                                            'course_id' => $course['id'],
                                            'lesson_id' => $lesson['id'],
                                            'level_id' => $level['id']
                                        ]) }}" 
                                       class="group transition-all relative">
                                        <div class="w-12 h-12 rounded-full border-2 
                                            {{ $level['is_completed'] ? 'border-[#7BFF00] bg-[#7BFF00] text-[#001E5F]' : 'border-[#7BFF00] bg-[#001E5F] hover:bg-[#7BFF00] hover:text-[#001E5F] text-white' }} 
                                            flex justify-center items-center transition-all transform group-hover:scale-110">
                                            @if($level['is_completed'])
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="font-bold">{{ $levelIndex + 1 }}</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Current Level Indicator -->
                                        @if(isset($nextLevelInfo) && $nextLevelInfo && $nextLevelInfo['level_id'] == $level['id'])
                                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-white rounded-full animate-pulse"></div>
                                        @endif
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Course Navigation Button -->
        @if(isset($nextLevelInfo))
            <div class="mt-8 flex justify-center">
                <a href="{{ route('level.show', [
                        'course_id' => $course['id'],
                        'lesson_id' => $nextLevelInfo['lesson_id'],
                        'level_id' => $nextLevelInfo['level_id']
                    ]) }}" 
                   class="bg-[#7BFF00] hover:bg-opacity-90 text-[#001E5F] font-bold px-6 py-3 rounded-lg transition-colors shadow-lg flex items-center">
                    @if($courseProgress['completed_levels'] > 0)
                        Continue Learning
                    @else
                        Start Learning
                    @endif
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        @elseif($courseProgress['completed_levels'] === $courseProgress['total_levels'] && $courseProgress['total_levels'] > 0)
            <div class="mt-8 flex justify-center">
                <div class="bg-[#7BFF00] text-[#001E5F] font-bold px-6 py-3 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Course Completed!
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
