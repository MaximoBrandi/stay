<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DatabaseCourse extends Component
{
    public $courseX;
    public function render()
    {
        return view('livewire.database-course');
    }
}
