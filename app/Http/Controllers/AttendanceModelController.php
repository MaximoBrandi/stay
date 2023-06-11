<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AttendanceModel;
use App\Models\TokenModel;
use Illuminate\Support\Facades\Auth;

class AttendanceModelController extends Controller
{
    /**
     * Almacenar una nueva asistencia en la base de datos, verificando que el escáner lo pueda realizar.
     */
    private function saveAttendance(string $token){
        if (Auth::user()->privilege->privilege_grade == 2 || Auth::user()->privilege->privilege_grade == 3) {
            $token = TokenModel::where('token','=', $token)->first();

            $attendance = new AttendanceModel;
            $attendance->student_id = $token->student_id;

            // Guardar la asistencia en la base de datos
            $attendance->save();
            $token->delete();
        }else{
            return abort(404);
        }
    }

    /**
     * Verifica y almacena la asistencia en la base de datos.
     */
    public function store($token)
    {
        $attendanceModel = AttendanceModel::where('student_id', '=', TokenModel::where('token', '=', $token)->first()->student_id);

        if ($attendanceModel->exists()) {
            if ($attendanceModel->first()->created_at->day !== date('d')) {
                $this->saveAttendance($token);
            } else {
                return abort(404);
            }
        } else {
            $this->saveAttendance($token);
        }
    }

    /**
     * Eliminar una asistencia específica de la base de datos.
     */
    public function destroy($id)
    {
        // Buscar la asistencia por ID y eliminarla
        $attendance = AttendanceModel::find($id);
        $attendance->delete();
    }
}
