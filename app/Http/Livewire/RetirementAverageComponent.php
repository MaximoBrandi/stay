<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RetirementAverageComponent extends Component
{
    public $course;
    public function render()
    {
        return view('livewire.retirement-average-component');
    }
}
