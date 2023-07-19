<?php

namespace App\Exports;

use App\Models\Holiday;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;

class HolidayExport implements FromCollection, WithTitle
{
    use Exportable;


    public function collection()
    {
        return Holiday::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Holidays';
    }
}
