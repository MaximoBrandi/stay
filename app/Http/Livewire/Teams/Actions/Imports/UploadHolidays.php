<?php

namespace App\Http\Livewire\Teams\Actions\Imports;

use App\Imports\HolidayImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UploadHolidays extends Component
{
    use WithFileUploads;
    public $excel;
    public function save()
    {
        Excel::import(new HolidayImport, $this->excel);

        $this->emit('saved');
    }
    public function download()
    {
        return Storage::download('public/HolidaysUploadExample.xlsx');
    }
    public function render()
    {
        return view('livewire.teams.actions.imports.upload-holidays');
    }
}
