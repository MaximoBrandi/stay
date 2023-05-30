<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceModel extends Model
{
    use HasFactory;

    public function privilege(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'student_id');
    }
}
