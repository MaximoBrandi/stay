<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class CourseExport implements WithMultipleSheets
{
    use Exportable;

    protected array $courses;

    public function __construct(array $courses)
    {
        $this->courses = $courses;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = (new TeamExport)->forCourse($this->courses);
        $sheets[] = (new UsersExport)->forCourse($this->courses)->forPrivilege(1);
        $sheets[] = (new UsersExport)->forPrivilege(3);
        $sheets[] = (new AttendanceExport)->forCourse($this->courses);
        $sheets[] = (new RetirementExport)->forCourse($this->courses);
        $sheets[] = (new SchedulesExport)->forCourse($this->courses);

        return $sheets;
    }
}
