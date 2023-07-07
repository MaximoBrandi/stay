<?php

namespace App\Http\Livewire\Database\Course;

use Livewire\Component;
use App\Models\User;
use App\Http\Controllers\DateController;
use Carbon\Carbon;

class CourseMilestones extends Component
{
    public $course;
    public $disengage = 0;
    public $PromedioAusentes = 0;
    public $PromedioRetiros = 0;
    public $diaMasAusentes;
    private $dateController;
    public function render()
    {
        if (!($this->dateController instanceof DateController)) {
            $this->dateController = new DateController($this->course);
        }

        $this->PromedioAusentes = $this->dateController->PromedioAusentesClases();
        $this->PromedioRetiros = $this->dateController->PromedioRetirosSemana();
        $this->disengage = count($this->dateController->Libres());
        $this->diaMasAusentes = $this->dateController->DiaConMasAusentes(); // 3838 ms

        return view('livewire.database.course.course-milestones');
    }
}
