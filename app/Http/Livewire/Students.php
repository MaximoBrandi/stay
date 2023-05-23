<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Attendance;


class Students extends Component
{

        /**
     * Mostrar la lista de asistencias.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendance::all();
        return view('attendance.index', compact('attendances'));
    }

    /**
     * Mostrar el formulario para crear una nueva asistencia.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('attendance.create');
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
            'date' => 'required',
            'student_id' => 'required',
            // Agrega aquí las reglas de validación para los demás campos de la tabla
        ]);

        // Crear una nueva instancia de Attendance y asignar los valores
        $attendance = new Attendance;
        $attendance->date = $request->input('date');
        $attendance->student_id = $request->input('student_id');
        // Asigna aquí los demás campos de la tabla

        // Guardar la asistencia en la base de datos
        $attendance->save();

        return redirect()->route('attendance.index')->with('success', 'Asistencia creada correctamente.');
    }

    /**
     * Mostrar los detalles de una asistencia específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendance = Attendance::find($id);
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Mostrar el formulario para editar una asistencia específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attendance = Attendance::find($id);
        return view('attendance.edit', compact('attendance'));
    }

    /**
     * Actualizar una asistencia específica en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'date' => 'required',
            'student_id' => 'required',
            // Agrega aquí las reglas de validación para los demás campos de la tabla
        ]);

        // Buscar la asistencia por ID y actualizar los valores
        $attendance = Attendance::find($id);
        $attendance->date = $request->input('date');
        $attendance->student_id = $request->input('student_id');
        // Actualiza aquí los demás campos de la tabla

        // Guardar los cambios en la base de datos
        $attendance->save();

        return redirect()->route('attendance.index')->with('success', 'Asistencia actualizada correctamente.');
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
        $attendance = Attendance::find($id);
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Asistencia eliminada correctamente.');
    }
    public function render()
    {


        return view('livewire.students');
    }
}
