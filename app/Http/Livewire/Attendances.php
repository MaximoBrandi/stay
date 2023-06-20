<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AttendanceModel;

class Attendances extends Component
{
    public $attendances;

    private $darkMode;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function getDarkMode()
    {
        return $this->darkMode;
    }

    public function setDarkMode($value)
    {
        $this->darkMode = $value;
    }

    public function toggleDarkMode()
    {
        $this->darkMode = !$this->darkMode;
        dd($this->darkMode);
    }

    public function index()
    {
        $this->attendances = Attendance::all();
    }

    public function render()
    {
        return view('livewire.attendances');
    }
}
