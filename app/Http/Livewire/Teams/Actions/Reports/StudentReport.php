<?php

namespace App\Http\Livewire\Teams\Actions\Reports;

use Livewire\Component;

class StudentReport extends Component
{
    public $selectedInput = array();
    public function render()
    {
        return view('livewire.teams.actions.reports.student-report');
    }
}
