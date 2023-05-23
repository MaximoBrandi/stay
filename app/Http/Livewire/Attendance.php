<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AttendanceModel;

class Attendance extends Component
{
    /**
     * Mostrar los detalles de una asistencia específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        $attendance = AttendanceModel::find($id);

        return view('livewire.attendance', compact('attendance'));
    }
}
