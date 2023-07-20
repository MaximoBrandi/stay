<?php

namespace App\Imports;

use App\Models\retirement;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class CourseFifthSheetImport implements ToModel
{
    public function model(array $row)
    {
        if ($row[2] !== null) {
            retirement::Create([
                'created_at' => Carbon::parse($row[2])->setTimezone(env('APP_TIMEZONE', 'UTC')),
                'updated_at' => Carbon::parse($row[2])->setTimezone(env('APP_TIMEZONE', 'UTC')),
                'student_id' => $row[1],
            ]);
        } else {
            return null;
        }
    }
}
