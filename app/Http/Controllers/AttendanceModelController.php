<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AttendanceModel;

class AttendanceModelController extends Controller
{
    /**
     * Mostrar el formulario para crear una nueva asistencia.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('attendance.create');
    }

    /**
     * Almacenar una nueva asistencia en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'student_id' => 'required',
            // Agrega aquí las reglas de validación para los demás campos de la tabla
        ]);

        // Crear una nueva instancia de AttendanceModel y asignar los valores
        if (AttendanceModel::where('student_id', '=', $request->student_id)->) {
            $attendance = new AttendanceModel;
            $attendance->date = $request->input('date');
            $attendance->student_id = $request->input('student_id');

            // Guardar la asistencia en la base de datos
            $attendance->save();
        }
    }

    /**
     * Eliminar una asistencia específica de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscar la asistencia por ID y eliminarla
        $attendance = AttendanceModel::find($id);
        $attendance->delete();
    }
}
