<div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="flex flex-col gap-1.5">
        <!-- Course -->
        <div class="flex items-center gap-1.5">
            <x-heroicon-m-academic-cap class="w-3.5 h-3.5 text-success-600 dark:text-success-400" />
            <span class="text-sm font-medium text-success-600 dark:text-success-400">Course: {{ $course }}</span>
        </div>
        
        <!-- Previous Lesson -->
        @isset($previousLesson)
        <div class="flex items-center gap-3 pl-3">
            <div class="flex items-center gap-1">
                <div class="h-4 w-2 border-l border-b border-primary-200 dark:border-primary-700 rounded-bl"></div>
            </div>
            <x-heroicon-m-book-open class="w-3 h-3 text-gray-400" />
            <span class="text-xs text-gray-400">Previous Lesson: {{ $previousLesson->name }}</span>
        </div>
        @endisset

        <!-- Current Lesson -->
        <div class="flex items-center gap-1.5 pl-3">
            <div class="flex items-center gap-1">
                <div class="h-4 w-2 border-l border-b border-primary-200 dark:border-primary-700 rounded-bl"></div>
            </div>
            <x-heroicon-m-book-open class="w-3.5 h-3.5 text-primary-600 dark:text-primary-400" />
            <span class="text-sm font-medium text-primary-600 dark:text-primary-400">Current Lesson: {{ $lesson }}</span>
        </div>

        <!-- Next Lesson -->
        @isset($nextLesson)
        <div class="flex items-center gap-3 pl-">
            <div class="flex items-center gap-1">
                <div class="h-4 w-2 border-l border-b border-primary-200 dark:border-primary-700 rounded-bl"></div>
            </div>
            <x-heroicon-m-book-open class="w-3 h-3 text-gray-400" />
            <span class="text-xs text-gray-400">Next Lesson: {{ $nextLesson->name }}</span>
        </div>
        @endisset
        
        <!-- Current Level -->
        @isset($record)
        <div class="flex items-center gap-1.5 pl-6">
            <div class="flex items-center gap-1">
                <div class="h-4 w-2 border-l border-b border-gray-200 dark:border-gray-700 rounded-bl"></div>
            </div>
            <x-heroicon-m-puzzle-piece class="w-3.5 h-3.5 text-gray-600 dark:text-gray-400" />
            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Level: {{ $record->index }}</span>
        </div>
        @endisset
    </div>
</div> 