<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AplicationImport implements WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        return [
            0 => new CourseFirstSheetImport(),
            1 => new CourseSecondSheetImport(),
            2 => new CourseThirdSheetImport(),
        ];
    }
}
