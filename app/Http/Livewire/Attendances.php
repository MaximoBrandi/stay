<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AttendanceModel;

class Attendances extends Component
{
    public $attendances;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function index()
    {
        $this->attendances = Attendance::all();
    }

    public function render()
    {
        return view('livewire.attendances');
    }
}
