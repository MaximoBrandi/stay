<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Attendances extends Component
{
    public $attendances;

    protected $listeners = ['refreshComponent' => '$refresh'];

    /**
     * Mostrar la lista de asistencias.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::all();
    }

    public function render()
    {
        return view('livewire.attendances');
    }
}
