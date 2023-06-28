<?php

namespace App\Http\Livewire\Database\Components;

use Livewire\Component;

class AbsentAverage extends Component
{
    public $course;
    public function render()
    {
        return view('livewire.database.components.absent-average');
    }
}
