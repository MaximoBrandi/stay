<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CourseImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new CourseFirstSheetImport(),
            1 => new CourseSecondSheetImport(),
            2 => new CourseThirdSheetImport(),
        ];
    }
}
