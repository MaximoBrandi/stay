<?php

namespace App\Exports;

use App\Models\User;
use App\Models\AttendanceModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceExport implements FromQuery, WithTitle
{
    use Exportable;

    protected array $course;
    protected array $ids;

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
            return AttendanceModel::query()->whereIn('student_id', $this->ids);
        }
        return AttendanceModel::query()->whereIn('student_id', User::whereIn('current_team_id', $this->course)->pluck('id')->toArray());
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Attendances';
    }
}
