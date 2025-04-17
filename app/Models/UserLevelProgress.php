<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLevelProgress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_level_progress';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'level_id',
        'status',
        'attempts',
        'score',
        'commands_used',
        'code_snapshot',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'code_snapshot' => 'array',
        'completed_at' => 'datetime',
        'status' => 'string',  // Ensure proper casting
    ];

    /**
     * Constant values for status (for code readability and consistency)
     */
    const STATUS_NOT_STARTED = 'not_started';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_MASTERED = 'mastered';

    /**
     * Validate if the status is one of the allowed values
     * 
     * @param string $status
     * @return bool
     */
    public static function isValidStatus(string $status): bool
    {
        return in_array($status, [
            self::STATUS_NOT_STARTED,
            self::STATUS_IN_PROGRESS, 
            self::STATUS_COMPLETED,
            self::STATUS_MASTERED
        ]);
    }

    /**
     * Get the user that owns this progress record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the level that this progress record belongs to.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
} 