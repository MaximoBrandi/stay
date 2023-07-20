<?php

namespace App\Http\Livewire\Database\Course;

use Livewire\Component;
use App\Models\User;
use App\Http\Controllers\DateController;
<<<<<<< HEAD:app/Http/Livewire/Database/Course/CourseMilestones.php
use Carbon\Carbon;
=======
use App\Models\Team;
>>>>>>> main:app/Http/Livewire/CourseResumeMilestones.php

class CourseMilestones extends Component
{
<<<<<<< HEAD:app/Http/Livewire/Database/Course/CourseMilestones.php
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
=======
    public Team $course;
    public int $disengage;
    public string $PromedioAusentes;
    public string $PromedioRetiros;
    public string $diaMasAusentes;
    private DateController $dateController;

    public function render()
    {
        $this->dateController = new DateController($this->course);
>>>>>>> main:app/Http/Livewire/CourseResumeMilestones.php

        $this->PromedioAusentes = $this->dateController->PromedioAusentesClases();
        $this->PromedioRetiros = $this->dateController->PromedioRetirosSemana();
        $this->disengage = count($this->dateController->Libres());
        $this->diaMasAusentes = $this->dateController->DiaConMasAusentes(); // 3838 ms

        return view('livewire.database.course.course-milestones');
    }
}
