<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AttendanceModel;
use App\Models\retirement;
use App\Models\User;

class DateController extends Controller
{
    private $inicioClases;
    private $tardeClases;
    private $ausenteClases;

    private $inicioCiclo;
    private $finCiclo;

    private $inicioReceso;
    private $finReceso;

    private $fechaActual;

    private $feriados;

    private $clases;
    private $prom;

    private function Initialize(){
        $this->HorarioActual();

        $this->inicioCiclo = Carbon::create(2023, 2, 27, 0);
        $this->finCiclo = Carbon::create(2023, 12, 22, 0);

        $this->inicioReceso = Carbon::create(2023, 7, 17, 0);
        $this->finReceso = Carbon::create(2023, 7, 28, 0);

        $this->fechaActual = Carbon::now();

        $this->feriados = array(
            Carbon::create(2023, 3, 24, 0),		// 24/03/2023	Día Nacional de la Memoria por la Verdad y la Justicia
            Carbon::create(2023, 4, 2, 0),		// 02/04/2023	Día del Veterano y de los Caídos en la Guerra de Malvinas
            Carbon::create(2023, 4, 6, 0),		// 06/04/2023	Jueves Santo
            Carbon::create(2023, 4, 7, 0),		// 07/04/2023	Viernes Santo
            Carbon::create(2023, 5, 1, 0),		// 01/05/2023	Día del Trabajador
            Carbon::create(2023, 5, 25, 0),		// 25/05/2023	Día de la Revolución de Mayo
            Carbon::create(2023, 5, 26, 0),		// 26/05/2023	Feriado con fines turísticos
            Carbon::create(2023, 6, 17, 0),		// 17/06/2023	Paso a la Inmortalidad del Gral. Don Martín Miguel de Güemes
            Carbon::create(2023, 6, 19, 0),		// 19/06/2023	Feriado con fines turísticos
            Carbon::create(2023, 6, 20, 0),		// 20/06/2023	Paso a la Inmortalidad del Gral. Manuel Belgrano
            Carbon::create(2023, 7, 9, 0),		// 09/07/2023	Día de la Independencia
            Carbon::create(2023, 8, 21, 0),		// 21/08/2023	Paso a la Inmortalidad del Gral. José de San Martín (17/8)
            Carbon::create(2023, 10, 13, 0),		// 13/10/2023	Feriado con fines turísticos
            Carbon::create(2023, 10, 16, 0),		// 16/10/2023	Día del Respeto a la Diversidad Cultural (12/10)
            Carbon::create(2023, 11, 20, 0),		// 20/11/2023	Día de la Soberanía Nacional
            Carbon::create(2023, 12, 8, 0)		// 08/12/2023	Inmaculada Concepción de María
        );

        $contador = Carbon::create(2023, 2, 27, 0);

        $clases = 0;

        while ($this->fechaActual >= $contador) {
            if ($contador->isWeekday() && !in_array($contador, $this->feriados)) {
                $clases++;
            }

            $contador->addDay(); // Avanza al siguiente día
        }

        $this->clases = $clases;
    }

    private function HorarioActual(){
        if (Carbon::today()->englishDayOfWeek == 'Friday') {
            $this->inicioClases = Carbon::createFromTime(18, 30, 0);
            $this->tardeClases = Carbon::createFromTime(19, 00, 0);
            $this->ausenteClases = Carbon::createFromTime(19, 15, 0);
        } else {
            $this->inicioClases = Carbon::createFromTime(18, 0, 0);
            $this->tardeClases = Carbon::createFromTime(18, 30, 0);
            $this->ausenteClases = Carbon::createFromTime(18, 45, 0);
        }
    }

    public function Tardes($id){
        $this->Initialize();

        $tardes = 0;

        $retirementsModelsCrud = retirement::where('student_id', '=', $id)->get('created_at')->map(function($i) {return array_values($i->only('created_at'));})->toArray();
        $studentRetirements = array();

        foreach ($retirementsModelsCrud as $key => $value) {
            array_push($studentRetirements, $value[0]);
        }

        $attendancesModelsCrud = AttendanceModel::query()->where('student_id', '=', $id)->whereNotIn('created_at', $studentRetirements)->get('created_at')->map(function($i) {return array_values($i->only('created_at'));})->toArray();
        $studentAttendances = array();

        foreach ($attendancesModelsCrud as $key => $value) {
            if (Carbon::createFromTime($value[0]->hour, $value[0]->minute, $value[0]->second)->betweenIncluded($this->tardeClases, $this->ausenteClases)) {
                $tardes++;
            }
        }

        return $tardes;
    }

    public function Libres($curso){
        $this->Initialize();

        $studentRetirements = array();

        foreach (User::query()->where('id', '>', 3)->where('current_team_id', '=', $curso)->get('id')->map(function($i) {return array_values($i->only('id'));})->toArray() as $key => $value) {
            if ($this->Ausentes($value[0]) >= 30) {
                array_push($studentRetirements, $value[0]);
            }
        }

        return $studentRetirements;
    }

    public function AbsentDay($curso){
        $this->Initialize();

        $absentDay = array();

        $diaAusente = $this->DiaConMasAusentes($curso);

        $mostAbsentKey = array();

        $mostAbsentValue = array();

        foreach (User::query()->where('id', '>', 3)->where('current_team_id', '=', $curso)->get('id')->map(function($i) {return array_values($i->only('id'));})->toArray() as $key => $value) {
            $contador = Carbon::create(2023, 2, 27, 0);
            $contadorAusentes = 0;

            while ($this->fechaActual >= $contador) {

                if ($contador->dayName == $diaAusente && !in_array($contador, $this->feriados)) {
                    if (!AttendanceModel::whereDate('created_at', $contador)->where('student_id', '=', $value[0])->exists() || retirement::whereDate('created_at', $contador)->where('student_id', '=', $value[0])->exists()) {
                        $contadorAusentes++;
                    }
                }

                $contador->addDay(); // Avanza al siguiente día
            }
            array_push($absentDay, [
                $value[0] => $contadorAusentes,
            ]);
        }

        $this->prom = array_sum($absentDay)/count($absentDay);

        $absentDay = array_filter($absentDay, function($n){

             return $n >= $this->prom;
         });

         $result = array();

        foreach ($absentDay as $key => $value) {
            array_push($mostAbsentKey, array_keys($value)[0]);
            array_push($mostAbsentValue, array_values($value)[0]);
        }

        array_push($result, $mostAbsentKey);
        array_push($result, $mostAbsentValue);

        return $result;
    }

    public function DiaConMasAusentes($curso){
        $this->Initialize();

        $contador = $this->inicioCiclo;

        $dias = array(
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
        );

        while ($this->fechaActual >= $contador) {

            if ($contador->isWeekday() && !in_array($contador, $this->feriados)) {
                $dias[$contador->dayName] = $dias[$contador->dayName] + $this->AusentesHoy($curso, $contador);
            }

            $contador->addDay(); // Avanza al siguiente día
        }

        return array_search(max($dias), $dias);
    }

    public function AverageRetirement($curso){
        $this->Initialize();

        $averageRetirement = array();

        foreach (User::query()->where('id', '>', 3)->where('current_team_id', '=', $curso)->get('id')->map(function($i) {return array_values($i->only('id'));})->toArray() as $key => $value) {
            $contador = Carbon::create(2023, 2, 27, 0);
            $contadorAusentes = 0;

            $averageRetirement[$value[0]] = $this->Retiradas($value[0]);
        }

        arsort($averageRetirement, SORT_NUMERIC);

        $newArray = array_keys($averageRetirement);

        $newnewArray = array();

        array_push($newnewArray, $averageRetirement[$newArray[0]], $averageRetirement[$newArray[1]], $averageRetirement[$newArray[2]], $averageRetirement[$newArray[count($newArray)-1]], $averageRetirement[$newArray[count($newArray)-2]], $averageRetirement[$newArray[count($newArray)-3]]);

        $averageRetirement = array();

        foreach ($newnewArray as $key => $value) {
            $averageRetirement[$newArray[$key]] = $value;
        }

        return $averageRetirement;
    }

    public function PromedioAusentesClases($curso){
        $this->Initialize();

        $totalAusentes = 0;

        foreach (User::query()->where('id', '>', 3)->where('current_team_id', '=', $curso)->get('id')->map(function($i) {return array_values($i->only('id'));})->toArray() as $key => $value) {
            $totalAusentes = $totalAusentes + $this->Ausentes($value[0]);
        }

        return number_format((float)($totalAusentes / $this->clases), 2, '.', '');
    }

    public function PromedioRetirosSemana($curso){
        $this->Initialize();

        $totalRetiros = 0;

        foreach (User::query()->where('id', '>', 3)->where('current_team_id', '=', $curso)->get('id')->map(function($i) {return array_values($i->only('id'));})->toArray() as $key => $value) {
            $totalRetiros = $totalRetiros + $this->Retiradas($value[0]);
        }

        return number_format((float)($totalRetiros / ( $this->clases / 5)) / $this->clases, 3, '.', '');
    }

    public function AusentesHoy($curso, $fecha){
        $this->Initialize();

        $totalAusentesHoy = 0;

        foreach (User::query()->where('id', '>', 3)->where('current_team_id', '=', $curso)->get('id')->map(function($i) {return array_values($i->only('id'));})->toArray() as $key => $value) {
            if (!AttendanceModel::whereDate('created_at', $fecha)->where('student_id', '=', $value[0])->exists() || retirement::whereDate('created_at', $fecha)->where('student_id', '=', $value[0])->exists()) {
                $totalAusentesHoy++;
            }
        }

        return $totalAusentesHoy;
    }

    public function PresenteAusente($id){
        $this->Initialize();

        $presentAusentes = 0;

        $retirementsModelsCrud = retirement::where('student_id', '=', $id)->get('created_at')->map(function($i) {return array_values($i->only('created_at'));})->toArray();
        $studentRetirements = array();

        foreach ($retirementsModelsCrud as $key => $value) {
            array_push($studentRetirements, $value[0]);
        }

        $attendancesModelsCrud = AttendanceModel::query()->where('student_id', '=', $id)->whereNotIn('created_at', $studentRetirements)->get('created_at')->map(function($i) {return array_values($i->only('created_at'));})->toArray();
        $studentAttendances = array();

        foreach ($attendancesModelsCrud as $key => $value) {
            if (Carbon::createFromTime($value[0]->hour, $value[0]->minute, $value[0]->second)->betweenIncluded($this->ausenteClases, Carbon::createFromTime(23, 0, 0))) {
                $presentAusentes++;
            }
        }

        return $presentAusentes;
    }

    public function Ausentes($id) {
        $this->Initialize();

        $ausentes = 0;

        $retirementsModelsCrud = retirement::where('student_id', '=', $id)->get('created_at')->map(function($i) {return array_values($i->only('created_at'));})->toArray();
        $studentRetirements = array();

        foreach ($retirementsModelsCrud as $key => $value) {
            array_push($studentRetirements, $value[0]);
        }

        $attendancesModelsCrud = AttendanceModel::query()->where('student_id', '=', $id)->whereNotIn('created_at', $studentRetirements)->get('created_at')->map(function($i) {return array_values($i->only('created_at'));})->toArray();
        $studentAttendances = array();

        foreach ($attendancesModelsCrud as $key => $value) {
            array_push($studentAttendances, Carbon::create($value[0]->year, $value[0]->month, $value[0]->day, 0));
        }

        $contador = $this->inicioCiclo;

        while ($this->fechaActual >= $contador) {
            if ($contador->isWeekday() && !in_array($contador, $this->feriados) && !in_array($contador, $studentAttendances)) {
                $ausentes++;
            }

            $contador->addDay(); // Avanza al siguiente día
        }

        return $ausentes + $this->PresenteAusente($id);
    }

    public function Retiradas($id) {
        $this->Initialize();

        return retirement::where('student_id', '=', $id)->count();
    }

    public function Presentes($id) {
        $this->Initialize();

        return AttendanceModel::where('student_id', '=', $id)->count();
    }
}
