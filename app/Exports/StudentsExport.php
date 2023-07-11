<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentsExport implements WithMultipleSheets
{
    use Exportable;

    protected $ids;
    protected $retirements;
    protected $attendance;

    public function __construct(array $ids, bool $retirements, bool $attendance)
    {
        $this->ids = $ids;
        $this->retirements = $retirements;
        $this->attendance = $attendance;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = (new UsersExport)->forUser($this->ids)->forPrivilege(1);

        if ($this->attendance) {
            $sheets[] = (new AttendanceExport)->forUser($this->ids);
        }

        if ($this->retirements) {
            $sheets[] = (new RetirementExport)->forUser($this->ids);
        }

        return $sheets;
    }
}
