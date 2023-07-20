<?php

namespace App\Imports;

use App\Models\Holiday;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class HolidayImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[1] !== null) {
            Holiday::Create([
                'date' => Carbon::parse($row[1])->setTimezone(env('APP_TIMEZONE', 'UTC')),
            ]);
        } else {
            return null;
        }

    }
}
