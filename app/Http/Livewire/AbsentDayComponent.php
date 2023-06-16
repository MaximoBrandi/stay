<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AbsentDayComponent extends Component
{
    public $course;
    public function render()
    {
        return view('livewire.absent-day-component');
    }
}
