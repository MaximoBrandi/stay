<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Http\Controllers\DateController;

class CourseResumeDatabase extends Component
{
    public Team $course;
    public int $alumnoID;
    public int $ausentes;
    public int $retiradas;
    public int $presentes;
    public int $presenteAusente;
    public int $tardes;
    public bool $dashboard;

    private function startUp(){
        if (request()->routeIs('dashboard')) {
            $this->dashboard = true;
        }

        return new DateController($this->course);
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
