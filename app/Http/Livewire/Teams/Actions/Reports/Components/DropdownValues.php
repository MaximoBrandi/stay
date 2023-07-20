<?php

namespace App\Http\Livewire\Teams\Actions\Reports\Components;

use Livewire\Component;

class DropdownValues extends Component
{
    public $selectedInput;
    public function render()
    {
        return view('livewire.teams.actions.reports.components.dropdown-values');
    }
}
