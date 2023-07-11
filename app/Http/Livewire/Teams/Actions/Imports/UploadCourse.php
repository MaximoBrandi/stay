<?php

namespace App\Http\Livewire\Teams\Actions\Imports;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\CourseImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class UploadCourse extends Component
{
    use WithFileUploads;

    public $excel;

    public function save()
    {
        $courseImport = (new CourseImport);
        Excel::import($courseImport->onlySheets('Preceptors'), $this->excel);

        Excel::import($courseImport->onlySheets('Courses'), $this->excel);

        Excel::import($courseImport->onlySheets('Students'), $this->excel);

        Excel::import($courseImport->onlySheets('Attendances'), $this->excel);

        Excel::import($courseImport->onlySheets('Retirements'), $this->excel);

        $this->emit('saved');
    }
    public function download()
    {
        return Storage::download('public/CoursesUploadExample.xlsx');
    }
    public function render()
    {
        return view('livewire.teams.actions.imports.upload-course');
    }
}
