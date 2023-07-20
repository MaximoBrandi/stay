<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

class CourseImport implements WithMultipleSheets
{
    use WithConditionalSheets;
    public function conditionalSheets(): array
    {
        return [
            'Preceptors' => new CourseFirstSheetImport(),
            'Courses' => new CourseSecondSheetImport(),
            'Students' => new CourseThirdSheetImport(),
            'Attendances' => new CourseFourthSheetImport(),
            'Retirements' => new CourseFifthSheetImport(),
            'Schedules' => new CourseSixthSheetImport(),
        ];
    }
}
