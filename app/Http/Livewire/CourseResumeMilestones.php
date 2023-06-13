<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Http\Controllers\DateController;

class CourseResumeMilestones extends Component
{
    public $course;
    public $disengage = 0;
    public $PromedioAusentes = 0;
    public $PromedioRetiros = 0;
    public $diaMasAusentes;

    private function casiLibres(){
        foreach (User::where('current_team_id', $this->course)->where('id', '>', 3)->get('id')->map(function($i) {return array_values($i->only('id'));})->toArray() as $studentID) {
            if ((new DateController)->Ausentes($studentID[0]) > 25) {
                $this->disengage++;
            }
        }
    }

    private function PromedioAusentes(){
        $this->PromedioAusentes = (new DateController)->PromedioAusentesClases($this->course);
    }

    private function PromedioRetiros(){
        $this->PromedioRetiros = (new DateController)->PromedioRetirosSemana($this->course);
    }

    public function render()
    {
        $this->PromedioAusentes();
        $this->PromedioRetiros();
        $this->casiLibres();
        $this->diaMasAusentes = (new DateController)->DiaConMasAusentes($this->course);

        return view('livewire.course-resume-milestones');
    }
}
