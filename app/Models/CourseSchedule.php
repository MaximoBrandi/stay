<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseSchedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'shift',
        'openTime',
        'startTime',
        'lateTime',
        'absentTime',
        'closeTime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'openTime' => 'datetime',
        'startTime' => 'datetime',
        'lateTime' => 'datetime',
        'absentTime' => 'datetime',
        'closeTime' => 'datetime',
    ];

    /**
     * Get the course that owns the schedule.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
