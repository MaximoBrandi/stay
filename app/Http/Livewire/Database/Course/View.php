<?php

namespace App\Http\Livewire\Database\Course;

use Livewire\Component;
use App\Models\Team;

class View extends Component
{
    public Team $course;
    public bool $courseVisible = false;
    protected $listeners = ['showButton'];

    public function showButton(Team $course)
    {
        if ($this->course->id == $course->id) {
            $this->courseVisible = true;
        }
    }
    public function render()
    {
        if ($this->courseVisible) {
            return view('livewire.database.course.view');
        }else{
            return view('livewire.database.course.null');
        }
    }
}
