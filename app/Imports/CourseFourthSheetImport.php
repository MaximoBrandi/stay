<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\AttendanceModel;
use Carbon\Carbon;

class CourseFourthSheetImport implements ToModel
{

   public function model(array $row)
   {
        if ($row[2] !== null) {
            AttendanceModel::Create([
                'created_at' => Carbon::parse($row[2])->setTimezone(env('APP_TIMEZONE', 'UTC'))
                ,
                'updated_at' => Carbon::parse($row[2])->setTimezone(env('APP_TIMEZONE', 'UTC'))
                ,
                'student_id' => $row[1],
            ]);
        } else {
            return null;
        }
    }
}
