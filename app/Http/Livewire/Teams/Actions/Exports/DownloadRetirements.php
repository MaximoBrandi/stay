<?php

namespace App\Http\Livewire\Teams\Actions\Exports;

use Livewire\Component;
use App\Exports\RetirementExport;

class DownloadRetirements extends Component
{
    public $selectedInput;

    public function save(){

        $this->emit('saved');

        return (new RetirementExport)->forCourse($this->selectedInput)->download('Retirements.xlsx');

    }
    public function render()
    {
        return view('livewire.teams.actions.exports.download-retirements');
    }
}
