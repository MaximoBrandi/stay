<?php

namespace App\Imports;

use App\Models\CourseSchedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class CourseSeventhSheetImport implements ToModel
{
    public function model(array $row)
    {
        CourseSchedule::Create([
            'date' => Carbon::parse($row[1])->setTimezone(env('APP_TIMEZONE', 'UTC')),
        ]);
    }
}
