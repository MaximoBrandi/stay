<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DatabaseCourse extends Component
{
    public $course;
    public function render()
    {
        return view('livewire.database-course');
    }
}
