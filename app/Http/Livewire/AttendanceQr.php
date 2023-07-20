<?php

namespace App\Http\Livewire;

use App\Http\Controllers\DateController;
use Livewire\Component;
use App\Models\AttendanceModel;
use App\Models\TokenModel;
use Illuminate\Support\Facades\Auth;

class AttendanceQr extends Component
{
    public string $qrlink;

    private $lasttoken; //TokenModel

    public bool $alreadylogedin;

    public int $classes;

    private function saveToken(){
        $this->alreadylogedin = false;

        $this->create();

        if (isset($this->lasttoken)) {
            $this->lasttoken->delete();
        }
    }

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
        $this->qrlink = "http://localhost:8000/attendance/".$token->token;
        // Guardar la asistencia en la base de datos
        $token->save();

        $token = $this->lasttoken;

        $token = null;
    }

    public function generate()
    {
        $attendanceModel = AttendanceModel::where('student_id', '=', Auth::user()->id);

        if ($attendanceModel->exists()) {

            if (($attendanceModel->first())->created_at->day !== (int)date('d')) {
                $this->saveToken();
            }else{
                $this->alreadylogedin = true;
            }

        }else{
            $this->saveToken();
        }
    }

    public function render()
    {
        if(Auth::user()->privilege->privilege_grade == 1){
            $dateController = new DateController(Auth::user()->currentTeam);

            if ($dateController->estadoDelDia(Auth::user()->id) == 4 && $dateController->horaDeClases() && $dateController->diaDeClases()) {
                $this->classes = 1;
            } else if(!$dateController->diaDeClases()) {
                $this->classes = 2;
            } else if(!$dateController->horaDeClases()) {
                $this->classes = 3;
            } else if($dateController->estadoDelDia(Auth::user()->id) != 4){
                $this->classes = 4;
            }
        }


        return view('livewire.attendance-qr');
    }
}
