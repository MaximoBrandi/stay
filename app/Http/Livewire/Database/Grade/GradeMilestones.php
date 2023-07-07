<?php

namespace App\Http\Livewire\Database\Grade;

use Livewire\Component;

class GradeMilestones extends Component
{
    public $grade;
    public function render()
    {
        return view('livewire.database.grade.grade-milestones');
    }
}
