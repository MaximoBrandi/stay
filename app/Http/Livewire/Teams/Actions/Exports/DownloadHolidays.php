<?php

namespace App\Http\Livewire\Teams\Actions\Exports;

use Livewire\Component;
use App\Exports\HolidayExport;

class DownloadHolidays extends Component
{
    public function save(){

        $this->emit('saved');

        return (new HolidayExport)->download('Holidays.xlsx');

    }
    public function render()
    {
        return view('livewire.teams.actions.exports.download-holidays');
    }
}
