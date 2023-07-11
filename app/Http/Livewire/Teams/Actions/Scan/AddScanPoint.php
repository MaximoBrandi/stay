<?php

namespace App\Http\Livewire\Teams\Actions\Scan;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class AddScanPoint extends Component
{
    use WithFileUploads;

    public $excel;
    public function save()
    {
        Excel::import(new UsersImport(2), $this->excel);

        $this->emit('saved');

    }
    public function download()
    {
        return Storage::download('public/StudentsUploadExample.xlsx');
    }
    public function render()
    {
        return view('livewire.teams.actions.scan.add-scan-point');
    }
}
