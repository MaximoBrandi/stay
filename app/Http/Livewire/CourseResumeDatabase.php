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
    public $dashboard;

    private function startUp(){
        return $dateController = new DateController($this->course);
    }

    private function increment(DateController $dateController)
    {
        $this->ausentes = $dateController->Ausentes($this->alumnoID);

        $this->retiradas = $dateController->Retiradas($this->alumnoID);

        $this->presentes = $dateController->Presentes($this->alumnoID);

        $this->tardes = $dateController->Tardes($this->alumnoID);

        $this->presenteAusente = $dateController->PresenteAusente($this->alumnoID);
    }
    public function change($id){
        $this->alumnoID = $id;
    }
    public function render()
    {
        if (isset($this->alumnoID)) {
            $this->increment($this->startUp());
        }

        return view('livewire.course-resume-database');
    }
}
