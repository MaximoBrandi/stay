<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Http\Controllers\DateController;
use App\Models\Team;

class CourseResumeMilestones extends Component
{
    public Team $course;
    public int $disengage;
    public string $PromedioAusentes;
    public string $PromedioRetiros;
    public string $diaMasAusentes;
    private DateController $dateController;

    public function render()
    {
        $this->dateController = new DateController($this->course);

        $this->PromedioAusentes = $this->dateController->PromedioAusentesClases();
        $this->PromedioRetiros = $this->dateController->PromedioRetirosSemana();
        $this->disengage = count($this->dateController->Libres());
        $this->diaMasAusentes = $this->dateController->DiaConMasAusentes(); // 3838 ms

        return view('livewire.course-resume-milestones');
    }
}
