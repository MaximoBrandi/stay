<?php

namespace App\Http\Livewire\Teams\Update;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UploadStudents extends Component
{
    use WithFileUploads;
    public $excel;
    private $loginLink = "http://localhost:8000/login";
    public function save()
    {
        Excel::import(new UsersImport, $this->excel);

        $this->emit('saved');

        $this->emit('savedUpload');

    }
    public function download()
    {
        return Storage::download('public/StudentsUploadExample.xlsx');
    }
    public function render()
    {
        return view('livewire.teams.update.upload-students');
    }
}
