<?php

namespace App\Http\Livewire\Teams\Actions\Exports;

use App\Exports\StudentsExport;
use Livewire\Component;
use App\Exports\UsersExport;

class DownloadStudents extends Component
{
    public $attendancesBool;
    public $retirementsBool;
    public $selectedInput;

    public function save(){
        if ($this->attendancesBool && $this->retirementsBool) {
            $this->emit('saved');

            return (new StudentsExport($this->selectedInput, true, true))->download('Students.xlsx');
        } elseif ($this->attendancesBool) {
            $this->emit('saved');

            return (new StudentsExport($this->selectedInput, false, true))->download('Students.xlsx');
        } elseif ($this->retirementsBool) {
            $this->emit('saved');

            return (new StudentsExport($this->selectedInput, true, false))->download('Students.xlsx');
        } else {
            $this->emit('saved');

            return (new UsersExport)->forUser($this->selectedInput)->forPrivilege(1)->download('Students.xlsx');
        }

    }
    public function render()
    {
        return view('livewire.teams.actions.exports.download-students');
    }
}
