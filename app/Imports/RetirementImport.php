<?php

namespace App\Imports;

use App\Models\retirement;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class RetirementImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new retirement([
            'created_at' => Carbon::parse($row[1].' ' .$row[2]),
            'updated_at' => Carbon::parse($row[1].' ' .$row[2]),
            'student_id' => $row[0],
        ]);
    }
}
