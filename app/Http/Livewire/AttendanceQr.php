<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AttendanceModel;
use App\Models\TokenModel;
use Illuminate\Support\Facades\Auth;

class AttendanceQr extends Component
{
    public $qrlink;

    public $lasttoken;

    public $alreadylogedin;

    /**
     * Almacenar una nueva asistencia en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student_id = Auth::user()->id;

        // Crear una nueva instancia de TokenModel y asignar los valores
        $token = new TokenModel;
        $token->student_id = $student_id;
        $token->token = csrf_token();
        // Asigna aquí los demás campos de la tabla

        // Generar link del codigo qr
        $this->qrlink = "http://localhost:8000/attendance?_token=".$token->token;
        // Guardar la asistencia en la base de datos
        $token->save();

        $token = $this->lasttoken;

        $token = null;
    }

    public function generate()
    {
        if (AttendanceModel::find(1)) {
            if ((AttendanceModel::where('student_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->first())->created_at->day !== (int)date('d')) {
                $this->alreadylogedin = false;

                $this->create();

                if ($this->lasttoken) {
                    $this->lasttoken->delete();
                }
            }else{
                $this->alreadylogedin = true;
            }
        }else{
            $this->alreadylogedin = false;

            $this->create();

            if ($this->lasttoken) {
                $this->lasttoken->delete();
            }
        }
    }

    public function render()
    {
        return view('livewire.attendance-qr');
    }
}
