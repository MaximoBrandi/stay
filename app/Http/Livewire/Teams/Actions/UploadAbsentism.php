<?php

namespace App\Http\Livewire\Teams\Actions;

use App\Imports\RetirementImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class UploadAbsentism extends Component
{
    use WithFileUploads;
    public $excel;
    public function save()
    {
        Excel::import(new RetirementImport, $this->excel);

        $this->emit('saved');
    }
    public function render()
    {
        return view('livewire.teams.actions.upload-absentism');
    }
}
