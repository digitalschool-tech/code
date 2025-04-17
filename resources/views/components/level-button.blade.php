@if($isLocked)
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
            'course_id' => $courseId,
            'lesson_id' => $lessonId,
            'level_id' => $level['id']
        ]) }}" 
       class="group transition-all relative">
        <div class="w-12 h-12 rounded-full border-2 
            {{ $isCompleted ? 'border-[#7BFF00] bg-[#7BFF00] text-[#001E5F]' : 'border-[#7BFF00] bg-[#001E5F] hover:bg-[#7BFF00] hover:text-[#001E5F] text-white' }} 
            flex justify-center items-center transition-all transform group-hover:scale-110">
            @if($isCompleted)
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            @else
                <span class="font-bold">{{ $index }}</span>
            @endif
        </div>
        
        <!-- Current Level Indicator -->
        @if($isCurrent)
            <div class="absolute -top-1 -right-1 w-4 h-4 bg-white rounded-full animate-pulse"></div>
        @endif
    </a>
@endif 