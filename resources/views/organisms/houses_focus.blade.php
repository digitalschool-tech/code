<div class="bg-[#00162F] bg-opacity-70 rounded-xl p-6 border border-[#00417A] mb-16">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
        <div class="flex items-center mb-4 md:mb-0">
            <div class="w-14 h-14 {{ $houseStyle['bg'] }} rounded-full flex items-center justify-center mr-4">
                <img src="{{ url('images/' . $houseStyle['icon']) }}" alt="{{ ucfirst(auth()->user()->house) }}" class="w-10 h-10 object-contain">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white">Your Learning Journey</h2>
                <p class="text-blue-300">{{ round($userStats['overall_progress']) }}% Complete ({{ $userStats['completed_levels'] }}/{{ $userStats['total_levels'] }} levels)</p>
            </div>
        </div>
        
        <div class="{{ $houseStyle['bg'] }} bg-opacity-20 px-4 py-2 rounded-full border {{ $houseStyle['border'] }} border-opacity-30">
            <span class="{{ $houseStyle['text'] }} font-medium">{{ ucfirst(auth()->user()->house) }} House Member</span>
        </div>
    </div>
    
    <!-- Current Progress Section -->
    <div class="bg-[#001E5F] bg-opacity-50 rounded-lg p-5 mb-6">
        <h3 class="text-xl font-bold text-white mb-3">Continue Learning</h3>
        
        @if(isset($currentCourse) && isset($currentLevel))
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="bg-[#0A0A2A] p-3 rounded-lg flex items-center flex-grow">
                    <div class="w-12 h-12 {{ $houseStyle['bg'] }} rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                        <span class="text-white font-bold">{{ $currentLevel->index }}</span>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between">
                            <h4 class="text-white font-medium">{{ $currentCourse->name }}</h4>
                            <span class="text-xs text-blue-300">Level {{ $currentLevel->index }}</span>
                        </div>
                        <p class="text-blue-300 text-sm line-clamp-1">{{ $currentLevel->description }}</p>
                    </div>
                </div>
                
                <a href="{{ route('level.show', [
                    'course_id' => $currentCourse->id,
                    'lesson_id' => $currentLevel->lesson_id,
                    'level_id' => $currentLevel->id
                ]) }}" 
                   class="{{ $houseStyle['bg'] }} text-white px-4 py-2 rounded-lg font-medium hover:bg-opacity-90 transition-colors flex items-center whitespace-nowrap flex-shrink-0">
                    Continue
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        @else
            <p class="text-blue-300">You haven't started any courses yet. Choose one from above to begin your learning journey!</p>
        @endif
    </div>
    
    <!-- Recently Completed Levels -->
    @if(isset($completedLevels) && $completedLevels->isNotEmpty())
        <div>
            <h3 class="text-lg font-medium text-white mb-3">Recently Completed</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($completedLevels as $level)
                    <div class="bg-[#001E5F] bg-opacity-30 rounded-lg p-3 flex items-center">
                        <div class="w-10 h-10 {{ $houseStyle['bg'] }} rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex justify-between">
                                <h4 class="text-white text-sm font-medium">{{ $level->lesson->course->name }}</h4>
                                <span class="text-xs {{ $houseStyle['text'] }}">Completed</span>
                            </div>
                            <p class="text-blue-300 text-xs">Level {{ $level->index }} - {{ Str::limit($level->description, 30) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>