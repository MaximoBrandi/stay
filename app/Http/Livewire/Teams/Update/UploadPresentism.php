<?php

namespace App\Http\Livewire\Teams\Update;

use App\Imports\AttendanceImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class UploadPresentism extends Component
{
    use WithFileUploads;
    public $excel;
    public function save()
    {
        Excel::import(new AttendanceImport, $this->excel);

        $this->emit('saved');
    }

    public function render()
    {
        return view('livewire.teams.update.upload-presentism');
    }
}
