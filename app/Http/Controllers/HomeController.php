<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\UserLevelProgress;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CourseStyleHelper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only require authentication for dashboard
        $this->middleware('auth')->only(['dashboard']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $courses = $this->getCourses();
        return view('pages.homepage', compact('courses'));
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = Auth::user();
        $courses = $this->getCourses();
        
        return view('pages.homepage', [
            'courses' => $courses,
            'user' => $user
        ]);
    }

    /**
     * Show all courses with access control and progress information.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function courses()
    {
        // Ensure user is authenticated (you may want to use middleware instead)
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        $courses = $this->getCourses();
        $userStats = $user->getProgressStats();
        $currentCourse = $user->getCurrentCourse();
        $currentLevel = $user->getCurrentLevel();
        $completedLevels = $user->getCompletedLevels()->take(2);
        $houseStyle = CourseStyleHelper::getHouseStyle($user->house);
        
        // Calculate access for each course
        foreach ($courses as &$course) {
            $course['is_locked'] = !$user->canAccessCourse($course['id'], $courses);
            $course['progress'] = $user->getCourseProgress($course['id']);
            $course['style'] = CourseStyleHelper::getCourseStyle($course['id'], $course['name']);
        }
        
        return view('pages.courses', [
            'courses' => $courses,
            'userStats' => $userStats,
            'currentCourse' => $currentCourse,
            'currentLevel' => $currentLevel,
            'completedLevels' => $completedLevels,
            'houseStyle' => $houseStyle
        ]);
    }

    /**
     * Show a specific course with level access control.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showCourse($id)
    {
        // Ensure user is authenticated (you may want to use middleware instead)
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        $course = $this->getCourseWithLessonsAndLevels($id);
        
        if (!$course) {
            abort(404, 'Course not found');
        }
        
        // Get course style based on course ID or name
        $courseStyle = CourseStyleHelper::getCourseStyle($course['id'], $course['name']);
        
        // Get user's progress for this course
        $courseProgress = $user->getCourseProgress($id);
        
        // Mark all lessons in first lesson as available
        $firstLessonId = $course['lessons'][0]['id'] ?? null;
        
        // Process lesson availability and level access for each level
        $previousLessonCompleted = true; // First lesson is always available
        
        foreach ($course['lessons'] as &$lesson) {
            // Determine if lesson is available
            $lesson['is_available'] = ($lesson['id'] == $firstLessonId) || $previousLessonCompleted;
            
            $allLevelsInLessonCompleted = true;
            
            foreach ($lesson['levels'] as &$level) {
                // Check if level is complete
                $isCompleted = $user->hasCompletedLevel($level['id']);
                $level['is_completed'] = $isCompleted;
                
                // Check if level is accessible
                $level['is_locked'] = !($lesson['is_available'] && 
                    ($level === $lesson['levels'][0] || 
                     $user->hasCompletedLevel($lesson['levels'][array_search($level, $lesson['levels']) - 1]['id'] ?? 0)));
                
                if (!$isCompleted) {
                    $allLevelsInLessonCompleted = false;
                }
            }
            
            // Update for next lesson
            $previousLessonCompleted = $allLevelsInLessonCompleted;
        }
        
        // Find next level for navigation
        $nextLevelInfo = $this->getNextLevelInfo($course);
        
        return view('pages.course', [
            'course' => $course,
            'courseStyle' => $courseStyle,
            'courseProgress' => $courseProgress,
            'nextLevelInfo' => $nextLevelInfo
        ]);
    }

    /**
     * Show a specific level.
     *
     * @param int $courseId
     * @param int $lessonId
     * @param int $levelId
     * @return \Illuminate\View\View
     */
    public function showLevel($courseId, $lessonId, $levelId)
    {
        $user = auth()->user();
        $course = Course::with(['lessons.levels'])->findOrFail($courseId);
        $lesson = $course->lessons->where('id', $lessonId)->firstOrFail();
        $level = $lesson->levels->where('id', $levelId)->firstOrFail();
        
        // Track progress for the current level
        $this->trackLevelProgress($user, $levelId);
        
        // Load levels for the sidebar navigation
        $levels = $lesson->levels;
        
        // Prepare level data for the game engine
        $levelData = [
            'id' => $level->id,
            'index' => $level->index,
            'title' => $level->title,
            'description' => $level->description,
            'player' => $level->player ?? '{}',
            'goal' => $level->goal ?? '{}',
            'route' => $level->route ?? '{}',
            'blocks' => $level->blocks ?? '{}',
            'hints' => $level->hints ?? [],
            'start_code' => $level->start_code,
            'solution_code' => $level->solution_code,
        ];
        
        // Check status and availability for each level in the navigation
        foreach ($levels as $levelItem) {
            // Get progress for this level
            $progress = $user->levelProgress()->where('level_id', $levelItem->id)->first();
            
            // Set status based on progress
            if ($progress) {
                $levelItem->status = $progress->status;
            } else {
                $levelItem->status = 'not_started';
            }
            
            // Determine if this level is available to the user
            $levelItem->is_available = $this->isLevelAvailable($user, $levelItem, $levels);
        }
        
        return view('pages.level', [
            'course' => $course,
            'lesson' => $lesson,
            'level' => $levelData,
            'levels' => $levels,
        ]);
    }
    
    /**
     * Mark a level as completed and update user progress.
     *
     * @param Request $request
     * @param int $courseId
     * @param int $lessonId
     * @param int $levelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function completeLevel(Request $request, $courseId, $lessonId, $levelId)
    {
        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $lesson = $course->lessons->where('id', $lessonId)->firstOrFail();
        $level = $lesson->levels->where('id', $levelId)->firstOrFail();
        
        // Get or create progress record
        $progress = $user->levelProgress()->where('level_id', $levelId)->first();
        
        if (!$progress) {
            $progress = $user->levelProgress()->create([
                'level_id' => $levelId,
                'status' => 'in_progress',
                'attempts' => 0,
                'score' => 0,
                'commands_used' => 0
            ]);
        }
        
        // Update the progress record
        $progress->status = 'completed';
        $progress->score = max($progress->score, $request->input('score', 0));
        $progress->commands_used = $request->input('commands_used', 0);
        $progress->code_snapshot = $request->input('code');
        $progress->completed_at = now();
        $progress->attempts += 1;
        $progress->save();
        
        // Find the next level if available
        $nextLevel = $lesson->levels->where('index', '>', $level->index)->sortBy('index')->first();
        
        // If no next level in current lesson, check if there's another lesson
        if (!$nextLevel) {
            $nextLesson = $course->lessons->where('index', '>', $lesson->index)->sortBy('index')->first();
            
            if ($nextLesson) {
                $nextLevel = $nextLesson->levels->sortBy('index')->first();
            }
        }
        
        // Evaluate code quality based on commands used
        $codeQuality = 'Good';
        if ($progress->commands_used <= 5) {
            $codeQuality = 'Excellent';
        } else if ($progress->commands_used <= 10) {
            $codeQuality = 'Great';
        }
        
        // Calculate points based on code quality and attempts
        $points = 50;
        if ($progress->attempts <= 1) {
            $points += 25; // Bonus for solving on first try
        }
        if ($progress->commands_used <= 5) {
            $points += 25; // Bonus for efficient solution
        }
        
        // Return response with next level info if available
        $response = [
            'success' => true,
            'message' => 'Level completed successfully',
            'progress' => [
                'status' => $progress->status,
                'score' => $progress->score,
                'attempts' => $progress->attempts,
                'commands_used' => $progress->commands_used,
                'completed_at' => $progress->completed_at,
                'code_quality' => $codeQuality,
                'points_earned' => $points
            ]
        ];
        
        if ($nextLevel) {
            $response['nextLevel'] = [
                'id' => $nextLevel->id,
                'title' => $nextLevel->title,
                'url' => route('level.show', [
                    'course_id' => $courseId,
                    'lesson_id' => $nextLevel->lesson_id,
                    'level_id' => $nextLevel->id
                ])
            ];
        }
        
        return response()->json($response);
    }
    
    /**
     * Track a failed attempt on a level.
     *
     * @param Request $request
     * @param int $courseId
     * @param int $lessonId
     * @param int $levelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordAttempt(Request $request, $courseId, $lessonId, $levelId)
    {
        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $lesson = $course->lessons->where('id', $lessonId)->firstOrFail();
        $level = $lesson->levels->where('id', $levelId)->firstOrFail();
        
        // Get or create progress record
        $progress = $user->levelProgress()->where('level_id', $levelId)->first();
        
        if (!$progress) {
            $progress = $user->levelProgress()->create([
                'level_id' => $levelId,
                'status' => 'in_progress',
                'attempts' => 1, // First attempt
                'score' => 0,
                'commands_used' => $request->input('commands_used', 0),
                'code_snapshot' => $request->input('code', 'No code available')
            ]);
        } else {
            // Increment attempts count
            $progress->attempts += 1;
            $progress->commands_used = $request->input('commands_used', 0);
            $progress->code_snapshot = $request->input('code', 'No code available');
            $progress->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Attempt recorded successfully',
            'attempts' => $progress->attempts
        ]);
    }
    
    /**
     * Get course data with lessons and levels.
     *
     * @param  int|null  $id
     * @return array|null
     */
    protected function getCourseWithLessonsAndLevels($id = null)
    {
        try {
            // Query for courses with their relationships
            $query = Course::with('lessons.levels');
            
            if ($id) {
                $courseModel = $query->find($id);
                
                if (!$courseModel) {
                    return null;
                }
                
                // Transform to array format
                $course = [
                    'id' => $courseModel->id,
                    'name' => $courseModel->name,
                    'description' => $courseModel->description,
                    'lesson_count' => $courseModel->lessons->count(),
                    'level_count' => $courseModel->lessons->sum(function($lesson) {
                        return $lesson->levels->count();
                    }),
                    'lessons' => []
                ];
                
                // Add lessons
                foreach ($courseModel->lessons as $lesson) {
                    $lessonData = [
                        'id' => $lesson->id,
                        'name' => $lesson->name,
                        'description' => $lesson->description,
                        'course_id' => $lesson->course_id,
                        'levels' => []
                    ];
                    
                    // Add levels
                    foreach ($lesson->levels as $level) {
                        $levelData = [
                            'id' => $level->id,
                            'name' => $level->name,
                            'description' => $level->description,
                            'content' => $level->content,
                            'lesson_id' => $level->lesson_id,
                            'index' => $level->index
                        ];
                        
                        // Add progress data if user is logged in
                        if (Auth::check()) {
                            $progress = Auth::user()->levelProgress()
                                ->where('level_id', $level->id)
                                ->first();
                                
                            $levelData['progress'] = $progress ? [
                                'status' => $progress->status,
                                'score' => $progress->score,
                                'attempts' => $progress->attempts,
                                'completed_at' => $progress->completed_at,
                            ] : null;
                        }
                        
                        $lessonData['levels'][] = $levelData;
                    }
                    
                    // Sort levels by index
                    usort($lessonData['levels'], function($a, $b) {
                        return $a['index'] - $b['index'];
                    });
                    
                    $course['lessons'][] = $lessonData;
                }
                
                return $course;
            }
            
            // For multiple courses, return a simpler format
            return $this->getCourses();
        }
        catch (\Exception $e) {
            // For development debugging
            if (config('app.debug')) {
                throw $e;
            }
            
            // Log the error
            \Log::error('Error fetching course data: ' . $e->getMessage());
            
            return null;
        }
    }
    
    /**
     * Get all courses with basic data.
     *
     * @return array
     */
    protected function getCourses()
    {
        try {
            $coursesCollection = Course::with('lessons.levels')->get();
            
            $courses = [];
            foreach ($coursesCollection as $course) {
                $lessonCount = $course->lessons->count();
                $levelCount = 0;
                
                foreach ($course->lessons as $lesson) {
                    $levelCount += $lesson->levels->count();
                }
                
                $courses[] = [
                    'id' => $course->id,
                    'name' => $course->name,
                    'description' => $course->description,
                    'lesson_count' => $lessonCount,
                    'level_count' => $levelCount
                ];
            }
            
            return $courses;
        }
        catch (\Exception $e) {
            // Log the error
            \Log::error('Error fetching courses: ' . $e->getMessage());
            
            // Return mock data if database isn't ready
            return $this->getMockCourses();
        }
    }
    
    /**
     * Generate mock course data for development.
     *
     * @return array
     */
    protected function getMockCourses()
    {
        return [
            [
                'id' => 1,
                'name' => 'Introduction to Programming',
                'description' => 'Learn the basics of programming with this beginner-friendly course.',
                'lesson_count' => 4,
                'level_count' => 12
            ],
            [
                'id' => 2,
                'name' => 'Web Development Fundamentals',
                'description' => 'Master HTML, CSS, and JavaScript to build modern websites.',
                'lesson_count' => 5,
                'level_count' => 15
            ],
            [
                'id' => 3,
                'name' => 'Advanced JavaScript',
                'description' => 'Take your JavaScript skills to the next level with modern techniques.',
                'lesson_count' => 3,
                'level_count' => 9
            ],
            [
                'id' => 4,
                'name' => 'Data Structures and Algorithms',
                'description' => 'Learn essential CS concepts to solve complex programming problems.',
                'lesson_count' => 6,
                'level_count' => 18
            ]
        ];
    }
    
    /**
     * Track user's progress on a level.
     *
     * @param \App\Models\User $user
     * @param int $levelId
     * @return void
     */
    private function trackLevelProgress($user, $levelId)
    {
        // Only create progress record if it doesn't exist
        if (!$user->hasLevelProgress($levelId)) {
            $user->levelProgress()->create([
                'level_id' => $levelId,
                'status' => 'in_progress', 
                'attempts' => 0,
                'score' => 0
            ]);
        }
    }
    
    /**
     * Determines if a level is available to the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Level $level
     * @param \Illuminate\Database\Eloquent\Collection $levels
     * @return bool
     */
    private function isLevelAvailable($user, $level, $levels)
    {
        // First level is always available
        if ($level->index === 1) {
            return true;
        }
        
        // Find the previous level
        $previousLevel = $levels->where('index', $level->index - 1)->first();
        
        if (!$previousLevel) {
            return true; // If there is no previous level, allow access
        }
        
        // Check if previous level is completed
        $previousProgress = $user->getLevelProgress($previousLevel->id);
        
        // Level is available if previous level is completed
        return $previousProgress && in_array($previousProgress->status, ['completed', 'mastered']);
    }
    
    /**
     * Get the next level after a completed level.
     *
     * @param  int  $courseId
     * @param  int  $lessonId
     * @param  int  $levelId
     * @return array|null
     */
    protected function getNextLevel($courseId, $lessonId, $levelId)
    {
        $course = $this->getCourseWithLessonsAndLevels($courseId);
        $foundCurrent = false;
        
        foreach ($course['lessons'] as $lesson) {
            foreach ($lesson['levels'] as $level) {
                // Find the current level first
                if ($foundCurrent) {
                    return [
                        'id' => $level['id'],
                        'lesson_id' => $lesson['id']
                    ];
                }
                
                if ($lesson['id'] == $lessonId && $level['id'] == $levelId) {
                    $foundCurrent = true;
                }
            }
        }
        
        return null; // No next level found
    }

    /**
     * Check if a lesson should be available
     *
     * @param array $course
     * @param int $lessonId
     * @return bool
     */
    protected function isLessonAvailable(array $course, int $lessonId): bool
    {
        // First lesson is always available
        if ($lessonId == $course['lessons'][0]['id']) {
            return true;
        }
        
        $previousLessonCompleted = true;
        
        foreach ($course['lessons'] as $lesson) {
            // If this is the lesson we're checking
            if ($lesson['id'] == $lessonId) {
                return $previousLessonCompleted;
            }
            
            // Check if all levels in this lesson are completed
            $allLevelsCompleted = true;
            foreach ($lesson['levels'] as $level) {
                if (Auth::check() && !Auth::user()->hasCompletedLevel($level['id'])) {
                    $allLevelsCompleted = false;
                    break;
                }
            }
            
            $previousLessonCompleted = $allLevelsCompleted;
        }
        
        return false;
    }

    /**
     * Get next level info for navigation
     *
     * @param array $course
     * @return array|null
     */
    protected function getNextLevelInfo(array $course): ?array
    {
        $user = Auth::user();
        
        foreach ($course['lessons'] as $lesson) {
            foreach ($lesson['levels'] as $level) {
                if (!$user->hasCompletedLevel($level['id'])) {
                    return [
                        'level_id' => $level['id'],
                        'lesson_id' => $lesson['id']
                    ];
                }
            }
        }
        
        return null;
    }
}
