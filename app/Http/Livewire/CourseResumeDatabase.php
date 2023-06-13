<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Controllers\DateController;

class CourseResumeDatabase extends Component
{
    public $course;
    public $alumnoID;
    public $ausentes;
    public $retiradas;
    public $presentes;
    public $presenteAusente;
    public $tardes;

    private function increment()
    {
        $this->ausentes = (new DateController)->Ausentes($this->alumnoID);

        $this->retiradas = (new DateController)->Retiradas($this->alumnoID);

        $this->presentes = (new DateController)->Presentes($this->alumnoID);

        $this->tardes = (new DateController)->Tardes($this->alumnoID);

        $this->presenteAusente = (new DateController)->PresenteAusente($this->alumnoID);
    }
    public function change($id){
        $this->alumnoID = $id;
    }
    public function render()
    {
        $this->increment();

        return view('livewire.course-resume-database');
    }
}
