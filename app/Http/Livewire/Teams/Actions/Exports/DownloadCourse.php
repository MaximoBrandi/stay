<?php

namespace App\Http\Livewire\Teams\Actions\Exports;

use App\Exports\CourseExport;
use Livewire\Component;

class DownloadCourse extends Component
{
    public $selectedInput;

    public function save(){

        $this->emit('saved');

        return (new CourseExport($this->selectedInput))->download('Courses.xlsx');

    }
    public function render()
    {
        return view('livewire.teams.actions.exports.download-course');
    }
}
