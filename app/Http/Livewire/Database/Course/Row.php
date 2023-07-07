<?php

namespace App\Http\Livewire\Database\Course;

use Livewire\Component;
use App\Models\Team;

class Row extends Component
{
    public Team $course;
    public function render()
    {
        return view('livewire.database.course.row');
    }
}
