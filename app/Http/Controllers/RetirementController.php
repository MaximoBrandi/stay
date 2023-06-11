<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\retirement;
use App\Models\TokenModel;
use Illuminate\Support\Facades\Auth;

class RetirementController extends Controller
{
    /**
     * Almacenar una nueva asistencia en la base de datos.
     */
    private function saveRetirement(string $token){
        if (Auth::user()->privilege->privilege_grade == 2 || Auth::user()->privilege->privilege_grade == 3) {
            $token = TokenModel::where('token','=', $token)->first();

            $retirement = new retirement;
            $retirement->student_id = $token->student_id;

            // Guardar la asistencia en la base de datos
            $retirement->save();
            $token->delete();
        }else{
            return abort(404);
        }
    }

    /**
     * Almacenar una nueva asistencia en la base de datos.
     */
    public function store($token)
    {
        $retirmentModel = retirement::where('student_id', '=', TokenModel::where('token', '=', $token)->first()->student_id);

        // Crear una nueva instancia de AttendanceModel y asignar los valores
        if (($retirmentModel->exists())) {
            if (($retirmentModel->orderBy('created_at', 'desc')->first())->created_at->day !== date('d')) {
                $this->saveRetirement($token);
            }else{
                return abort(404);
            }
        }else {
            $this->saveRetirement($token);
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
        $attendance = retirement::find($id);
        $attendance->delete();
    }
}
