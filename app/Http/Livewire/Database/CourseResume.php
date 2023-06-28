<?php

namespace App\Http\Livewire\Database;

use Livewire\Component;
use App\Http\Controllers\DateController;
use Carbon\Carbon;

class CourseResume extends Component
{
    public $course;
    public $alumnoID;
    public $ausentes;
    public $retiradas;
    public $presentes;
    public $presenteAusente;
    public $tardes;
    public $dashboard;
    private $dateController;

    private function increment()
    {
        $this->ausentes = $this->dateController->Ausentes($this->alumnoID);

        $this->retiradas = $this->dateController->Retiradas($this->alumnoID);

        $this->presentes = $this->dateController->Presentes($this->alumnoID);

        $this->tardes = $this->dateController->Tardes($this->alumnoID);

        $this->presenteAusente = $this->dateController->PresenteAusente($this->alumnoID);
    }
    public function change($id){
        $this->alumnoID = $id;
    }
    public function render()
    {
        if (!($this->dateController instanceof DateController)) {
            $this->dateController = new DateController($this->course);
        }
        if (isset($this->alumnoID)) {
            $this->increment();
        }

        return view('livewire.database.course-resume');
    }
}
