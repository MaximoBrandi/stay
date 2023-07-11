<?php

namespace App\Http\Livewire\Teams\Actions\Imports;

use App\Imports\AttendanceImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UploadPresentism extends Component
{
    use WithFileUploads;
    public $excel;
    public function save()
    {
        Excel::import(new AttendanceImport, $this->excel);

        $this->emit('saved');
    }
    public function download()
    {
        return Storage::download('public/PresentsUploadExample.xlsx');
    }
    public function render()
    {
        return view('livewire.teams.actions.imports.upload-presentism');
    }
}
