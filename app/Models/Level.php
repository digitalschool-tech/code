<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'content',
        'lesson_id',
        'index',
        'player',
        'goal',
        'route',
        'blocks'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'player' => 'array',
        'goal' => 'array',
        'route' => 'array',
        'blocks' => 'array',
    ];

    /**
     * Get the lesson that owns this level.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the progress records for this level.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(UserLevelProgress::class);
    }
}
