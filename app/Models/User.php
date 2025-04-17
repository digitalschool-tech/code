<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'house',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    /**
     * Check if the user has selected a house
     *
     * @return bool
     */
    public function hasSelectedHouse()
    {
        return !empty($this->house);
    }

    /**
     * Get the color code for the user's house
     *
     * @return string|null
     */
    public function getHouseColor()
    {
        $colors = [
            'engineer' => 'bg-[#124C00]',
            'speedster' => 'bg-[#7A0025]',
            'hipster' => 'bg-[#3A005A]',
            'shadow' => 'bg-[#00417A]',
        ];
        
        return $this->hasSelectedHouse() ? ($colors[$this->house] ?? null) : null;
    }

    /**
     * Get the icon filename for the user's house
     *
     * @return string|null
     */
    public function getHouseIcon()
    {
        $icons = [
            'engineer' => 'engineer.png',
            'speedster' => 'speedsters.png',
            'hipster' => 'hipsters.png',
            'shadow' => 'shadows.png',
        ];
        
        return $this->hasSelectedHouse() ? ($icons[$this->house] ?? null) : null;
    }

    /**
     * Get the levels that the user has made progress on.
     */
    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class, 'user_level_progress')
            ->withPivot(['status', 'attempts', 'score', 'code_snapshot', 'completed_at'])
            ->withTimestamps();
    }
    
    /**
     * Track progress for a specific level.
     *
     * @param int $levelId
     * @param string $status
     * @param int $attempts
     * @param int $score
     * @param array|null $codeSnapshot
     * @return UserLevelProgress
     */
    public function trackLevelProgress(int $levelId, string $status = 'started', int $attempts = 1, int $score = 0, ?array $codeSnapshot = null)
    {
        $progress = UserLevelProgress::updateOrCreate(
            ['user_id' => $this->id, 'level_id' => $levelId],
            [
                'status' => $status,
                'attempts' => DB::raw('attempts + ' . $attempts),
                'score' => $score > 0 ? $score : DB::raw('score'),
                'code_snapshot' => $codeSnapshot,
                'completed_at' => in_array($status, ['completed', 'mastered']) ? now() : null,
            ]
        );
        
        return $progress;
    }
    
    /**
     * Complete a level and update progress.
     *
     * @param int $levelId
     * @param int $score
     * @param array|null $codeSnapshot
     * @return UserLevelProgress
     */
    public function completeLevel(int $levelId, int $score = 0, ?array $codeSnapshot = null)
    {
        return $this->trackLevelProgress($levelId, 'completed', 1, $score, $codeSnapshot);
    }
    
    /**
     * Master a level (highest completion status).
     *
     * @param int $levelId
     * @param int $score
     * @param array|null $codeSnapshot
     * @return UserLevelProgress
     */
    public function masterLevel(int $levelId, int $score = 0, ?array $codeSnapshot = null)
    {
        return $this->trackLevelProgress($levelId, 'mastered', 1, $score, $codeSnapshot);
    }
    
    /**
     * Check if the user has started a level.
     *
     * @param int $levelId
     * @return bool
     */
    public function hasStartedLevel(int $levelId): bool
    {
        return $this->levels()->where('level_id', $levelId)->exists();
    }
    
    /**
     * Check if the user has completed a level.
     *
     * @param int $levelId
     * @return bool
     */
    public function hasCompletedLevel($levelId): bool
    {
        $progress = $this->levelProgress()->where('level_id', $levelId)->first();
        return $progress && in_array($progress->status, ['completed', 'mastered']);
    }
    
    /**
     * Check if the user has mastered a level.
     *
     * @param int $levelId
     * @return bool
     */
    public function hasMasteredLevel(int $levelId): bool
    {
        return $this->levels()
            ->where('level_id', $levelId)
            ->wherePivot('status', 'mastered')
            ->exists();
    }
    
    /**
     * Get the current level the user is working on.
     *
     * @return Level|null
     */
    public function getCurrentLevel()
    {
        $currentCourse = $this->getCurrentCourse();
        
        if (!$currentCourse) {
            return null;
        }
        
        foreach ($currentCourse->lessons as $lesson) {
            foreach ($lesson->levels as $level) {
                $progress = $this->levels()->where('level_id', $level->id)->first();
                
                if (!$progress || $progress->status !== 'completed') {
                    return $level;
                }
            }
        }
        
        return null;
    }
    
    /**
     * Get the current lesson the user is working on.
     *
     * @return Lesson|null
     */
    public function getCurrentLesson()
    {
        $currentLevel = $this->getCurrentLevel();
        
        if ($currentLevel) {
            return $currentLevel->lesson;
        }
        
        return null;
    }
    
    /**
     * Get the current course the user is working on.
     *
     * @return Course|null
     */
    public function getCurrentCourse()
    {
        $courses = \App\Models\Course::with(['lessons.levels'])->orderBy('id')->get();
        
        foreach ($courses as $course) {
            $allLevelsCompleted = true;
            $hasStartedCourse = false;
            
            foreach ($course->lessons as $lesson) {
                foreach ($lesson->levels as $level) {
                    $progress = $this->levels()->where('level_id', $level->id)->first();
                    
                    if ($progress) {
                        $hasStartedCourse = true;
                    }
                    
                    if (!$progress || $progress->status !== 'completed') {
                        $allLevelsCompleted = false;
                        return $course; // Return the first course with incomplete levels
                    }
                }
            }
            
            // If user has started this course but all levels are completed,
            // move to the next course unless this is the last course
            if ($hasStartedCourse && $allLevelsCompleted) {
                continue;
            }
            
            // If user hasn't started any course, return the first one
            if (!$hasStartedCourse) {
                return $course;
            }
        }
        
        // If all courses are completed, return the last one
        return $courses->last();
    }
    
    /**
     * Get all completed levels for the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCompletedLevels()
    {
        return $this->levelProgress()
            ->whereIn('status', ['completed', 'mastered'])
            ->with('level')
            ->get()
            ->pluck('level');
    }
    
    /**
     * Get all levels the user has mastered.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMasteredLevels()
    {
        return $this->levels()
            ->wherePivot('status', 'mastered')
            ->get();
    }
    
    /**
     * Get the next level the user should attempt.
     *
     * @param int|null $courseId
     * @return Level|null
     */
    public function getNextLevel(?int $courseId = null)
    {
        // Get completed level IDs
        $completedLevelIds = $this->levels()
            ->wherePivotIn('status', ['completed', 'mastered'])
            ->pluck('level_id');
        
        $query = Level::query();
        
        // If course ID is provided, filter by that course
        if ($courseId) {
            $query->whereHas('lesson', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }
        
        // Find the first level that hasn't been completed yet
        if ($completedLevelIds->isNotEmpty()) {
            $query->whereNotIn('id', $completedLevelIds);
        }
        
        // Order by lesson ID and then by level index to get the next logical level
        return $query->orderBy('lesson_id')
            ->orderBy('index')
            ->first();
    }
    
    /**
     * Get user's progress statistics for all courses
     *
     * @return array
     */
    public function getProgressStats()
    {
        $stats = [
            'courses' => [],
            'completed_levels' => 0,
            'total_levels' => 0,
            'overall_progress' => 0
        ];
        
        // Get all courses
        $courses = \App\Models\Course::with(['lessons.levels'])->get();
        $totalLevelsCount = 0;
        
        foreach ($courses as $course) {
            $courseStats = [
                'id' => $course->id,
                'name' => $course->name,
                'completed_levels' => 0,
                'total_levels' => 0,
                'progress' => 0
            ];
            
            $completedLevelsInCourse = 0;
            $totalLevelsInCourse = 0;
            
            foreach ($course->lessons as $lesson) {
                foreach ($lesson->levels as $level) {
                    $totalLevelsInCourse++;
                    $totalLevelsCount++;
                    
                    // Check if level is completed
                    $progress = $this->levels()->where('level_id', $level->id)->first();
                    if ($progress && $progress->status === 'completed') {
                        $completedLevelsInCourse++;
                        $stats['completed_levels']++;
                    }
                }
            }
            
            $courseStats['total_levels'] = $totalLevelsInCourse;
            $courseStats['completed_levels'] = $completedLevelsInCourse;
            
            // Calculate course progress percentage
            if ($totalLevelsInCourse > 0) {
                $courseStats['progress'] = ($completedLevelsInCourse / $totalLevelsInCourse) * 100;
            }
            
            $stats['courses'][] = $courseStats;
        }
        
        $stats['total_levels'] = $totalLevelsCount;
        
        // Calculate overall progress
        if ($totalLevelsCount > 0) {
            $stats['overall_progress'] = ($stats['completed_levels'] / $totalLevelsCount) * 100;
        }
        
        return $stats;
    }

    /**
     * Get the level progress for this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function levelProgress(): HasMany
    {
        return $this->hasMany(UserLevelProgress::class);
    }

    /**
     * Get the current level progress or create a new one.
     *
     * @param int $levelId
     * @return \App\Models\UserLevelProgress
     */
    public function getOrCreateLevelProgress($levelId)
    {
        return $this->levelProgress()->firstOrCreate(
            ['level_id' => $levelId],
            [
                'status' => 'in_progress',
                'attempts' => 0,
                'score' => 0
            ]
        );
    }

    /**
     * Determine if a user can access a specific course
     *
     * @param int $courseId
     * @param array $courses
     * @return bool
     */
    public function canAccessCourse(int $courseId, array $courses = null): bool
    {
        // First course is always accessible
        if ($courseId === 1) {
            return true;
        }
        
        // Get user progress stats
        $stats = $this->getProgressStats();
        
        // Find the previous course in the sequence
        $prevCourseId = null;
        if ($courses) {
            foreach ($courses as $index => $course) {
                if ($course['id'] == $courseId && $index > 0) {
                    $prevCourseId = $courses[$index - 1]['id'];
                    break;
                }
            }
        } else {
            $prevCourseId = $courseId - 1;
        }
        
        // If there's no previous course, allow access
        if (!$prevCourseId) {
            return true;
        }
        
        // Check if previous course is completed
        if (isset($stats['courses'])) {
            $prevCourseStats = collect($stats['courses'])->firstWhere('id', $prevCourseId);
            return $prevCourseStats && $prevCourseStats['progress'] >= 100;
        }
        
        return false;
    }

    /**
     * Determine if a user can access a specific level
     *
     * @param int $levelId
     * @param array $course
     * @param int $lessonId
     * @return bool
     */
    public function canAccessLevel(int $levelId, array $course, int $lessonId): bool
    {
        // First level of first lesson is always accessible
        $firstLesson = $course['lessons'][0] ?? null;
        $firstLevel = $firstLesson['levels'][0] ?? null;
        
        if ($firstLesson && $firstLevel && 
            $firstLesson['id'] == $lessonId && 
            $firstLevel['id'] == $levelId) {
            return true;
        }
        
        $previousLevelFound = false;
        $previousLevelCompleted = false;
        
        foreach ($course['lessons'] as $lesson) {
            foreach ($lesson['levels'] as $level) {
                // If we've found the target level
                if ($lesson['id'] == $lessonId && $level['id'] == $levelId) {
                    // Can only access if we've either not found a previous level (first level)
                    // or the previous level was completed
                    return !$previousLevelFound || $previousLevelCompleted;
                }
                
                // Mark that we've found a level before the target
                $previousLevelFound = true;
                
                // Check if this level is completed
                $previousLevelCompleted = $this->hasCompletedLevel($level['id']);
            }
        }
        
        return false;
    }

    /**
     * Get the progress for a specific course
     *
     * @param int $courseId
     * @return array
     */
    public function getCourseProgress($courseId): array
    {
        $course = Course::with(['lessons.levels'])->findOrFail($courseId);
        $totalLevels = 0;
        $completedLevels = 0;
        
        foreach ($course->lessons as $lesson) {
            $totalLevels += $lesson->levels->count();
            
            foreach ($lesson->levels as $level) {
                if ($this->hasCompletedLevel($level->id)) {
                    $completedLevels++;
                }
            }
        }
        
        $progress = $totalLevels > 0 ? ($completedLevels / $totalLevels) * 100 : 0;
        
        return [
            'total_levels' => $totalLevels,
            'completed_levels' => $completedLevels,
            'progress' => $progress,
            'status' => $completedLevels >= $totalLevels ? 'completed' : 'in_progress'
        ];
    }

    /**
     * Check if the user has any progress record for a level.
     *
     * @param int $levelId
     * @return bool
     */
    public function hasLevelProgress($levelId): bool
    {
        return $this->levelProgress()->where('level_id', $levelId)->exists();
    }

    /**
     * Get the user's progress for a specific level.
     *
     * @param int $levelId
     * @return \App\Models\UserLevelProgress|null
     */
    public function getLevelProgress($levelId)
    {
        return $this->levelProgress()->where('level_id', $levelId)->first();
    }
}
