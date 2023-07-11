<?php

namespace App\Exports;

use App\Models\retirement;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

class RetirementExport implements FromQuery, WithTitle
{
    use Exportable;

    public $course;
    protected $ids;

    public function forCourse(array $course)
    {
        $this->course = $course;

        return $this;
    }
    public function forUser(array $ids)
    {
        $this->ids = $ids;

        return $this;
    }

    public function query()
    {
        if (isset($this->ids)) {
            return retirement::query()->whereIn('student_id', $this->ids);
        }
        return retirement::query()->whereIn('student_id', User::whereIn('current_team_id', $this->course)->pluck('id')->toArray());
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Retirements';
    }
}
