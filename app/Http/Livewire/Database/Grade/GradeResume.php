<?php

namespace App\Http\Livewire\Database\Grade;

use Livewire\Component;

class GradeResume extends Component
{
    public $grade;
    public $courseID;
    public function change($id){
        $this->courseID = $id;
    }
    public function render()
    {
        return view('livewire.database.grade.grade-resume');
    }
}
