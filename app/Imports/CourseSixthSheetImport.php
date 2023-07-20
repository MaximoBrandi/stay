<?php

namespace App\Imports;

use App\Models\CourseSchedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class CourseSixthSheetImport implements ToModel
{
    public function model(array $row)
    {
        if ($row[2] !== null) {
            CourseSchedule::Create([
                'team_id' => $row[1],
                'shift' => $row[2],
                'openTime' => Carbon::parse($row[3])->setTimezone(env('APP_TIMEZONE', 'UTC')),
                'startTime' => Carbon::parse($row[4])->setTimezone(env('APP_TIMEZONE', 'UTC')),
                'lateTime' => Carbon::parse($row[5])->setTimezone(env('APP_TIMEZONE', 'UTC')),
                'absentTime' => Carbon::parse($row[6])->setTimezone(env('APP_TIMEZONE', 'UTC')),
                'closeTime' => Carbon::parse($row[7])->setTimezone(env('APP_TIMEZONE', 'UTC')),
            ]);
        }else{
            return null;
        }
    }
}
