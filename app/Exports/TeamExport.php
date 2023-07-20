<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

class TeamExport implements FromQuery, WithTitle
{
    use Exportable;

    protected array $course;
    protected array $ids;

    public function forCourse(array $course)
    {
        $this->course = $course;

        return $this;
    }

    public function query()
    {
        return Team::query()->whereIn('id', $this->course);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Courses';
    }
}
