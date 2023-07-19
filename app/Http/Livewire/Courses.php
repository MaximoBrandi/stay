<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;

class Courses extends Component
{
    public Team $course;

    public function render()
    {
        return view('livewire.courses');
    }
}
