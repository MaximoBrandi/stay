<?php

namespace App\Exports;

use App\Models\CourseSchedule;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

class SchedulesExport implements FromQuery, WithTitle
{
    use Exportable;

    public array $course;

    public function forCourse(array $course)
    {
        $this->course = $course;

        return $this;
    }

    public function query()
    {
        return CourseSchedule::query()->whereIn('team_id', $this->course);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Schedules';
    }
}
