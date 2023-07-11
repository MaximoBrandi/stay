<?php

namespace App\Http\Livewire\Teams\Actions\Exports;

use Livewire\Component;
use App\Exports\UsersExport;

class DownloadPreceptor extends Component
{
    public $selectedInput = array();

    public function save() {
        $this->emit('saved');

        return (new UsersExport)->forUser($this->selectedInput)->forPrivilege(3)->download('Preceptors.xlsx');
    }

    public function render()
    {
        return view('livewire.teams.actions.exports.download-preceptor');
    }
}
