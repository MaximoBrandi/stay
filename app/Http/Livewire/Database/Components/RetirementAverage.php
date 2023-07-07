<?php

namespace App\Http\Livewire\Database\Components;

use Livewire\Component;

class RetirementAverage extends Component
{
    public $course;
    public function render()
    {
        return view('livewire.database.components.retirement-average');
    }
}
