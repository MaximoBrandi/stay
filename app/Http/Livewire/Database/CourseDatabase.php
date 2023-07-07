<?php

namespace App\Http\Livewire\Database;

use App\Http\Controllers\DateController;
use Livewire\Component;

class CourseDatabase extends Component
{
    public $course;
    public function render()
    {
        return view('livewire.database.course-database');
    }
}
