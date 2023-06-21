<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class retirement extends Model
{
    protected $fillable = [
        'student_id',
        'updated_at',
        'created_at',
    ];

    use HasFactory;
}
