<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AttendanceModel;
use App\Models\retirement;
use App\Models\User;
use App\Models\Team;

class DateController extends Controller
{
    private readonly int $course;
    private readonly Carbon $inicioClases;
    private readonly Carbon $tardeClases;
    private readonly Carbon $ausenteClases;

    private readonly Carbon $aperturaClases;

    private readonly Carbon $finClases;

    private readonly Carbon $inicioCiclo;
    private readonly Carbon $finCiclo;

    private readonly Carbon $inicioReceso;
    private readonly Carbon $finReceso;

    private readonly Carbon $fechaActual;

    private readonly array $feriados;

    private readonly int $clases;
    private $prom;

    public function __construct($course)
    {
        $this->course = $course;

        $this->HorarioActual(Team::find($this->course)->pluck('shift')->first());

        $this->Initialize();
    }

    private function Initialize(){
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

    private function HorarioActual($shift){
        switch ($shift) {
            case 'night':
                if (Carbon::today()->englishDayOfWeek == 'Friday') {
                    $this->aperturaClases = Carbon::createFromTime(17, 30, 0);
                    $this->inicioClases = Carbon::createFromTime(18, 30, 0);
                    $this->tardeClases = Carbon::createFromTime(19, 00, 0);
                    $this->ausenteClases = Carbon::createFromTime(19, 15, 0);
                    $this->finClases = Carbon::createFromTime(22, 20, 0);
                } else {
                    $this->aperturaClases = Carbon::createFromTime(17, 00, 0);
                    $this->inicioClases = Carbon::createFromTime(18, 0, 0);
                    $this->tardeClases = Carbon::createFromTime(18, 30, 0);
                    $this->ausenteClases = Carbon::createFromTime(18, 45, 0);
                    $this->finClases = Carbon::createFromTime(22, 50, 0);
                }
                break;
            case 'afternoon':
                if (Carbon::today()->englishDayOfWeek == 'Friday') {
                    $this->aperturaClases = Carbon::createFromTime(17, 30, 0);
                    $this->inicioClases = Carbon::createFromTime(18, 30, 0);
                    $this->tardeClases = Carbon::createFromTime(19, 00, 0);
                    $this->ausenteClases = Carbon::createFromTime(19, 15, 0);
                    $this->finClases = Carbon::createFromTime(22, 20, 0);
                } else {
                    $this->aperturaClases = Carbon::createFromTime(17, 00, 0);
                    $this->inicioClases = Carbon::createFromTime(18, 0, 0);
                    $this->tardeClases = Carbon::createFromTime(18, 30, 0);
                    $this->ausenteClases = Carbon::createFromTime(18, 45, 0);
                    $this->finClases = Carbon::createFromTime(22, 50, 0);
                }
                break;
            case 'morning':
                if (Carbon::today()->englishDayOfWeek == 'Monday') {
                    $this->aperturaClases = Carbon::createFromTime(7, 0, 0);
                    $this->inicioClases = Carbon::createFromTime(7, 30, 0);
                    $this->tardeClases = Carbon::createFromTime(7, 45, 0);
                    $this->ausenteClases = Carbon::createFromTime(8, 0, 0);
                    $this->finClases = Carbon::createFromTime(12, 20, 0);
                } else {
                    $this->aperturaClases = Carbon::createFromTime(17, 00, 0);
                    $this->inicioClases = Carbon::createFromTime(18, 0, 0);
                    $this->tardeClases = Carbon::createFromTime(18, 30, 0);
                    $this->ausenteClases = Carbon::createFromTime(18, 45, 0);
                    $this->finClases = Carbon::createFromTime(22, 50, 0);
                }
                break;

            default:
                # code...
                break;
        }
    }

    public function Tardes($id) {
        $tardes = 0;

        $retirements = retirement::where('student_id', $id)->pluck('created_at')->toArray();

        $attendances = AttendanceModel::where('student_id', $id)
            ->whereNotIn('created_at', $retirements)
            ->pluck('created_at')
            ->toArray();

        foreach ($attendances as $attendance) {
            $attendanceTime = Carbon::createFromFormat('Y-m-d H:i:s', $attendance);

            if ($attendanceTime->betweenIncluded($this->tardeClases, $this->ausenteClases)) {
                $tardes++;
            }
        }

        return $tardes;
    }

    public function Libres($curso) {
        $studentRetirements = User::where('id', '>', 3)
            ->where('current_team_id', $curso)
            ->get()
            ->filter(function ($user) {
                return $this->Ausentes($user->id) >= 30;
            })
            ->pluck('id')
            ->toArray();

        return $studentRetirements;
    }

    public function AbsentDay($curso) {
        $absentDay = [];
        $diaAusente = $this->DiaConMasAusentes($curso);

        $userIds = User::where('id', '>', 3)->where('current_team_id', $curso)->pluck('id')->toArray();

        foreach ($userIds as $userId) {
            $contador = Carbon::create(2023, 2, 27, 0);
            $contadorAusentes = 0;

            while ($this->fechaActual >= $contador) {
                if ($contador->dayName == $diaAusente && !in_array($contador, $this->feriados)) {
                    if (!AttendanceModel::whereDate('created_at', $contador)->where('student_id', $userId)->exists() || retirement::whereDate('created_at', $contador)->where('student_id', $userId)->exists()) {
                        $contadorAusentes++;
                    }
                }

                $contador->addDay(); // Avanza al siguiente día
            }

            $absentDay[$userId] = $contadorAusentes;
        }

        $prom = array_sum($absentDay) / count($absentDay);

        $absentDay = array_filter($absentDay, function ($n) use ($prom) {
            return $n >= $prom;
        });

        $mostAbsentKey = array_keys($absentDay);
        $mostAbsentValue = array_values($absentDay);

        return [$mostAbsentKey, $mostAbsentValue];
    }

    public function DiaConMasAusentes($curso) {
        $contador = Carbon::create(2023, 2, 27, 0);
        $dias = [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
        ];

        while ($this->fechaActual >= $contador) {
            if ($contador->isWeekday() && !in_array($contador, $this->feriados)) {
                $dias[$contador->dayName] += $this->AusentesHoy($curso, $contador);
            }

            $contador->addDay(); // Avanza al siguiente día
        }

        return array_search(max($dias), $dias);
    }

    public function diaDeClases(){
        if ($this->fechaActual->isWeekday() && !in_array($this->fechaActual, $this->feriados)) {
            return true;
        }else{
            return false;
        }
    }

    public function horaDeClases(){
        if (Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->betweenIncluded($this->aperturaClases, $this->finClases)) {
            return true;
        }else{
            return false;
        }
    }

    public function estadoDelDia($id){
        $retirements = retirement::where('student_id', $id)->pluck('created_at')->toArray();

        $attendances = AttendanceModel::where('student_id', $id)->whereNotIn('created_at', $retirements)->pluck('created_at')->toArray();

        foreach ($attendances as $attendance) {
            $attendanceTime = Carbon::createFromFormat('Y-m-d H:i:s', $attendance);

            if ($attendanceTime->betweenIncluded($this->tardeClases, $this->ausenteClases)) {
                return 1;
            }else
            if ($attendanceTime->betweenIncluded($this->ausenteClases, $this->finClases)) {
                return 2;
            }else
            if ($attendanceTime->betweenIncluded($this->aperturaClases, $this->inicioClases)) {
                return 3;
            }
        }

        return 4;
    }

    public function AverageRetirement($curso) {
        $userIds = User::where('id', '>', 3)->where('current_team_id', $curso)->pluck('id')->toArray();
        $averageRetirement = [];

        foreach ($userIds as $userId) {
            $averageRetirement[$userId] = $this->Retiradas($userId);
        }

        arsort($averageRetirement, SORT_NUMERIC);
        $sortedKeys = array_keys($averageRetirement);

        $selectedKeys = array_slice($sortedKeys, 0, 3);
        $selectedKeys = array_merge($selectedKeys, array_slice($sortedKeys, -3));

        $averageRetirement = array_intersect_key($averageRetirement, array_flip($selectedKeys));

        return $averageRetirement;
    }

    public function AverageAbsent($curso) {
        $userIds = User::where('id', '>', 3)->where('current_team_id', $curso)->pluck('id')->toArray();
        $averageAbsent = [];

        foreach ($userIds as $userId) {
            $averageAbsent[$userId] = $this->Ausentes($userId);
        }

        asort($averageAbsent);
        $sortedKeys = array_keys($averageAbsent);

        $selectedKeys = array_slice($sortedKeys, 0, 3);
        $selectedKeys = array_merge($selectedKeys, array_slice($sortedKeys, -3));

        $averageAbsent = array_intersect_key($averageAbsent, array_flip($selectedKeys));

        return $averageAbsent;
    }

    public function PromedioAusentesClases($curso) {
        $userIds = User::where('id', '>', 3)->where('current_team_id', $curso)->pluck('id')->toArray();
        $totalAusentes = 0;

        foreach ($userIds as $userId) {
            $totalAusentes += $this->Ausentes($userId);
        }

        return number_format($totalAusentes / $this->clases, 2, '.', '');
    }

    public function PromedioRetirosSemana($curso) {
        $userIds = User::where('id', '>', 3)->where('current_team_id', $curso)->pluck('id')->toArray();
        $totalRetiros = 0;

        foreach ($userIds as $userId) {
            $totalRetiros += $this->Retiradas($userId);
        }

        $clasesPorSemana = $this->clases / 5;
        return number_format($totalRetiros / $clasesPorSemana / $this->clases, 3, '.', '');
    }

    public function AusentesHoy($curso, $fecha) {
        $userIds = User::where('id', '>', 3)->where('current_team_id', $curso)->pluck('id')->toArray();
        $totalAusentesHoy = 0;

        foreach ($userIds as $userId) {
            $attendanceExists = AttendanceModel::whereDate('created_at', $fecha)->where('student_id', $userId)->exists();
            $retirementExists = retirement::whereDate('created_at', $fecha)->where('student_id', $userId)->exists();

            if (!$attendanceExists || $retirementExists) {
                $totalAusentesHoy++;
            }
        }

        return $totalAusentesHoy;
    }

    public function PresenteAusente($id) {
        $presentAusentes = 0;

        $retirements = retirement::where('student_id', $id)->pluck('created_at')->toArray();
        $studentRetirements = array_column($retirements, 'created_at');

        $attendances = AttendanceModel::where('student_id', $id)
            ->whereNotIn('created_at', $studentRetirements)
            ->pluck('created_at')->toArray();

        foreach ($attendances as $attendance) {
            $attendanceTime = Carbon::parse($attendance);
            $startTime = Carbon::createFromTime($attendanceTime->hour, $attendanceTime->minute, $attendanceTime->second);

            if ($startTime->betweenIncluded($this->ausenteClases, $this->finClases)) {
                $presentAusentes++;
            }
        }

        return $presentAusentes;
    }

    public function Ausentes($id) {
        $ausentes = 0;

        $retirements = retirement::where('student_id', $id)->pluck('created_at')->toArray();
        $studentRetirements = array_column($retirements, 'created_at');

        $attendances = AttendanceModel::where('student_id', $id)
            ->whereNotIn('created_at', $studentRetirements)
            ->pluck('created_at')->toArray();
        $studentAttendances = array_map(function ($attendance) {
            return Carbon::parse($attendance)->startOfDay();
        }, $attendances);

        $contador = Carbon::create(2023, 2, 27, 0);

        while ($this->fechaActual >= $contador) {
            if ($contador->isWeekday() && !in_array($contador, $this->feriados) && !in_array($contador, $studentAttendances)) {
                $ausentes++;
            }

            $contador->addDay(); // Avanza al siguiente día
        }

        return $ausentes + $this->PresenteAusente($id);
    }

    public function Retiradas($id) {
        return retirement::where('student_id', '=', $id)->count();
    }

    public function Presentes($id) {
        return AttendanceModel::where('student_id', '=', $id)->count();
    }
}
