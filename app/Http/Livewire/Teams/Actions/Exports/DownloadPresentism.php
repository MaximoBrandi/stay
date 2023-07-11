<?php

namespace App\Http\Livewire\Teams\Actions\Exports;

use Livewire\Component;
use App\Exports\AttendanceExport;

class DownloadPresentism extends Component
{
    public $selectedInput;

    public function save(){

        $this->emit('saved');

        return (new AttendanceExport)->forCourse($this->selectedInput)->download('Presentism.xlsx');

    }
    public function render()
    {
        return view('livewire.teams.actions.exports.download-presentism');
    }
}
