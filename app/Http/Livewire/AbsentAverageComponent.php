<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AbsentAverageComponent extends Component
{
    public $course;
    public function render()
    {
        return view('livewire.absent-average-component');
    }
}
