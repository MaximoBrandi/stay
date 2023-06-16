<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DisengageStudentsComponent extends Component
{
    public $course;

    public function render()
    {
        return view('livewire.disengage-students-component');
    }
}
