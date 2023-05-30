<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokenModel;

class TokenModelController extends Controller
{
    /**
     * Almacenar una nueva asistencia en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $student_id = Auth::user()->id;

        // Crear una nueva instancia de TokenModel y asignar los valores
        $token = new TokenModel;
        $token->student_id = $request->input('student_id');
        $token->token = csrf_token();
        // Asigna aquí los demás campos de la tabla

        // Guardar la asistencia en la base de datos
        $token->save();
    }
}
