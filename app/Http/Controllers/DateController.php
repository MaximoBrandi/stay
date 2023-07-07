<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use App\Models\AttendanceModel;
use App\Models\retirement;
use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use JsonSerializable;

class DateController extends Controller
{
    private readonly int $course;
    private readonly string $inicioClases;
    private readonly string $tardeClases;
    private readonly string $ausenteClases;
    private readonly string $aperturaClases;
    private readonly string $finClases;

    private readonly Carbon $inicioCiclo;
    private readonly Carbon $finCiclo;

    private readonly Carbon $inicioReceso;
    private readonly Carbon $finReceso;

    private readonly Carbon $fechaActual;

    private readonly array $feriados;
    private $attendances;

    private $attendancesDays;

    private $retirements;
    private $absents;
    private $classDays;

    private readonly int $clases;
    private $students;
    private $prom;

    public function __construct($course, bool $datatable = null)
    {
        // Testing time
        $knownDate = Carbon::create(Carbon::now()->year, Carbon::now()->month, Carbon::now()->day, 18, 20);
        Carbon::setTestNow($knownDate);

        $this->course = $course;

        $this->HorarioActual(Team::find($this->course)->pluck('shift')->first());

        $this->Initialize();
    }

    private function Initialize()
    {
        $this->inicioCiclo = Carbon::create(2023, 2, 27, 0);
        $this->finCiclo = Carbon::create(2023, 12, 22, 0);

        $this->inicioReceso = Carbon::create(2023, 7, 17, 0);
        $this->finReceso = Carbon::create(2023, 7, 28, 0);

        $this->fechaActual = Carbon::now();

        $this->feriados = array(
            Carbon::create(2023, 3, 24, 0), // 24/03/2023	Día Nacional de la Memoria por la Verdad y la Justicia
            Carbon::create(2023, 4, 2, 0), // 02/04/2023	Día del Veterano y de los Caídos en la Guerra de Malvinas
            Carbon::create(2023, 4, 6, 0), // 06/04/2023	Jueves Santo
            Carbon::create(2023, 4, 7, 0), // 07/04/2023	Viernes Santo
            Carbon::create(2023, 5, 1, 0), // 01/05/2023	Día del Trabajador
            Carbon::create(2023, 5, 25, 0), // 25/05/2023	Día de la Revolución de Mayo
            Carbon::create(2023, 5, 26, 0), // 26/05/2023	Feriado con fines turísticos
            Carbon::create(2023, 6, 17, 0), // 17/06/2023	Paso a la Inmortalidad del Gral. Don Martín Miguel de Güemes
            Carbon::create(2023, 6, 19, 0), // 19/06/2023	Feriado con fines turísticos
            Carbon::create(2023, 6, 20, 0), // 20/06/2023	Paso a la Inmortalidad del Gral. Manuel Belgrano
            Carbon::create(2023, 7, 9, 0), // 09/07/2023	Día de la Independencia
            Carbon::create(2023, 8, 21, 0), // 21/08/2023	Paso a la Inmortalidad del Gral. José de San Martín (17/8)
            Carbon::create(2023, 10, 13, 0), // 13/10/2023	Feriado con fines turísticos
            Carbon::create(2023, 10, 16, 0), // 16/10/2023	Día del Respeto a la Diversidad Cultural (12/10)
            Carbon::create(2023, 11, 20, 0), // 20/11/2023	Día de la Soberanía Nacional
            Carbon::create(2023, 12, 8, 0) // 08/12/2023	Inmaculada Concepción de María
        );

        $this->students = User::whereHas('privilege', function ($query) {
            return $query->where('privilege_grade', '=', 1);
        })->where('current_team_id', '=', $this->course)->get();

        $this->attendances = AttendanceModel::whereIn('student_id', $this->students->pluck('id')->toArray())->exists() ? AttendanceModel::whereIn('student_id', $this->students->pluck('id')->toArray())->orderBy('created_at')->get()->groupBy('student_id')->map(function ($attendance) {
            return $attendance->pluck('created_at')->toArray();
        })->toArray() : array("null" => "null");

        foreach ($this->attendances as $usuarioId => $fechasPresentes) {
            $fechasPresentes = collect($fechasPresentes)->map(function ($attendance) {
                if (!is_string($attendance)) {
                    return $attendance->toDateString();
                } else {
                    return $attendance;
                }
            })->toArray();

            $attendancesDays[$usuarioId] = array_values($fechasPresentes);
        }

        $this->attendancesDays = isset($attendancesDays) ? $attendancesDays : array();

        $this->retirements = retirement::whereIn('student_id', $this->students->pluck('id')->toArray())->exists() ? retirement::whereIn('student_id', $this->students->pluck('id')->toArray())->orderBy('created_at')->get()->groupBy('student_id')->map(function ($retirement) {
            return $retirement->pluck('created_at')->toArray();
        })->toArray() : array("null" => "null");

        $this->classDays = array_values(array_diff(CarbonPeriod::create(Carbon::create(2023, 2, 27, 0), Carbon::now())->filter('isWeekday')->toArray(), $this->feriados));

        foreach ($this->attendancesDays as $usuarioId => $fechasPresentes) {
            $classDays = collect($this->classDays)->map(function ($attendance) {
                return $attendance->toDateString();
            })->toArray();

            $resultados[$usuarioId] = array_values(array_diff($classDays, $fechasPresentes));
        }

        $this->absents = isset($resultados) ? $resultados : array("null" => "null");

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

    private function HorarioActual($shift)
    {
        switch ($shift) {
            case 'night':
                $this->aperturaClases = Carbon::createFromTime(17, 00, 0)->format('H:i:s');
                $this->inicioClases = Carbon::createFromTime(18, 0, 0)->format('H:i:s');
                $this->tardeClases = Carbon::createFromTime(18, 30, 0)->format('H:i:s');
                $this->ausenteClases = Carbon::createFromTime(18, 45, 0)->format('H:i:s');
                $this->finClases = Carbon::createFromTime(22, 50, 0)->format('H:i:s');
                break;
            case 'afternoon':
                if (Carbon::today()->englishDayOfWeek == 'Friday') {
                    $this->aperturaClases = Carbon::createFromTime(17, 30, 0)->format('H:i:s');
                    $this->inicioClases = Carbon::createFromTime(18, 30, 0)->format('H:i:s');
                    $this->tardeClases = Carbon::createFromTime(19, 00, 0)->format('H:i:s');
                    $this->ausenteClases = Carbon::createFromTime(19, 15, 0)->format('H:i:s');
                    $this->finClases = Carbon::createFromTime(22, 20, 0)->format('H:i:s');
                } else {
                    $this->aperturaClases = Carbon::createFromTime(17, 00, 0)->format('H:i:s');
                    $this->inicioClases = Carbon::createFromTime(18, 0, 0)->format('H:i:s');
                    $this->tardeClases = Carbon::createFromTime(18, 30, 0)->format('H:i:s');
                    $this->ausenteClases = Carbon::createFromTime(18, 45, 0)->format('H:i:s');
                    $this->finClases = Carbon::createFromTime(22, 50, 0)->format('H:i:s');
                }
                break;
            case 'morning':
                if (Carbon::today()->englishDayOfWeek == 'Monday') {
                    $this->aperturaClases = Carbon::createFromTime(7, 0, 0)->format('H:i:s');
                    $this->inicioClases = Carbon::createFromTime(7, 30, 0)->format('H:i:s');
                    $this->tardeClases = Carbon::createFromTime(7, 45, 0)->format('H:i:s');
                    $this->ausenteClases = Carbon::createFromTime(8, 0, 0)->format('H:i:s');
                    $this->finClases = Carbon::createFromTime(12, 20, 0)->format('H:i:s');
                } else {
                    $this->aperturaClases = Carbon::createFromTime(17, 00, 0)->format('H:i:s');
                    $this->inicioClases = Carbon::createFromTime(18, 0, 0)->format('H:i:s');
                    $this->tardeClases = Carbon::createFromTime(18, 30, 0)->format('H:i:s');
                    $this->ausenteClases = Carbon::createFromTime(18, 45, 0)->format('H:i:s');
                    $this->finClases = Carbon::createFromTime(22, 50, 0)->format('H:i:s');
                }
                break;

            default:
                # code...
                break;
        }
    }

    public function Tardes($id)
    {
        $tardes = 0;

        if (array_key_exists($id, $this->attendances)) {
            foreach ($this->attendances[$id] as $attendance) {
                if ($attendance->format('H:i:s') >= $this->tardeClases && $attendance->format('H:i:s') <= $this->ausenteClases) {
                    $tardes++;
                }
            }
        }

        return $tardes;
    } // 0.02~ ms

    public function Libres(): array
    {
        $libres = array();

        foreach ($this->students as $key => $student) {
            if ($this->Ausentes($student->id) >= 25) {
                array_push($libres, $student->id);
            }
        }

        return $libres;
    } // 2.134 ms

    public function AbsentDay()
    {
        $absentDay = [];
        $diaAusente = $this->DiaConMasAusentes();

        if (!isset($this->absents['null'])) {
            foreach ($this->absents as $idUsuario => $fecha) {
                $contador = Carbon::create(2023, 2, 27, 0);
                $contadorAusentes = 0;

                foreach ($fecha as $value) {
                    if (Carbon::parse($value)->dayName == $diaAusente) {
                        $contadorAusentes++;
                    }
                }

                $absentDay[$idUsuario] = $contadorAusentes;
            }

            $prom = array_sum($absentDay) / count($absentDay);

            $absentDay = array_filter($absentDay, function ($n) use ($prom) {
                return $n >= $prom;
            });

            arsort($absentDay);

            return $absentDay;
        }else{
            foreach ($this->students as $usuario) {
                $contador = Carbon::create(2023, 2, 27, 0);
                $contadorAusentes = 0;

                $absentDay[$usuario->id] = $this->clases;
            }

            return $absentDay;
        }
    } // 38 ms

    public function DiaConMasAusentes()
    {
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
                $dias[$contador->dayName] += $this->AusentesHoy($contador);
            }

            $contador->addDay(); // Avanza al siguiente día
        }

        return array_search(max($dias), $dias);
    } // 17 ms

    public function diaDeClases()
    {
        if ($this->fechaActual->isWeekday() && !in_array($this->fechaActual, $this->feriados)) {
            return true;
        } else {
            return false;
        }
    } // 0.265 ms

    public function horaDeClases()
    {
        if (Carbon::now()->format('H:i:s') >= $this->aperturaClases && Carbon::now()->format('H:i:s') <= $this->finClases) {
            return true;
        } else {
            return false;
        }
    } // 0.8 ms

    public function estadoDelDia(int $id)
    {
        if (array_key_exists(strval($id), $this->attendances)) {
            foreach ($this->attendances[$id] as $fecha) {
                if ($fecha->isSameDay(Carbon::today())) {
                    if ($fecha->addHours(5)->format('H:i:s') >= $this->tardeClases && $fecha->addHours(5)->format('H:i:s') <= $this->ausenteClases) {
                        return 1;
                    } else
                        if ($fecha->addHours(5)->format('H:i:s') >= $this->ausenteClases && $fecha->addHours(5)->format('H:i:s') <= $this->finClases) {
                            return 2;
                        } else
                            if ($fecha->addHours(5)->format('H:i:s') >= $this->aperturaClases && $fecha->addHours(5)->format('H:i:s') <= $this->inicioClases) {
                                return 3;
                            }
                }
            }
        } // ESTA PARA TESTEO

        return 4;
    } // 0.76 ms

    public function AverageRetirement()
    {
        $averageRetirement = [];

        foreach ($this->retirements as $userId => $retirements) {
            if (is_string($retirements)) {
                $averageRetirement[$userId] = 0;
            } else {
                $averageRetirement[$userId] = count($retirements);
            }
        }

        arsort($averageRetirement, SORT_NUMERIC);
        $sortedKeys = array_keys($averageRetirement);

        $selectedKeys = array_slice($sortedKeys, 0, 3);
        $selectedKeys = array_merge($selectedKeys, array_slice($sortedKeys, -3));

        $averageRetirement = array_intersect_key($averageRetirement, array_flip($selectedKeys));

        return $averageRetirement;
    } // 0.04 ms

    public function AverageAbsent()
    {
        $averageAbsent = [];

        if (isset($this->absents['null'])) {
            foreach ($this->students as $userId => $absents) {
                if (is_string($absents)) {
                    $averageAbsent[$userId] = 0;
                } else {
                    $averageAbsent[$userId] = $this->clases;
                }
            }

            asort($averageAbsent);
            $sortedKeys = array_keys($averageAbsent);

            $selectedKeys = array_slice($sortedKeys, 0, 3);
            $selectedKeys = array_merge($selectedKeys, array_slice($sortedKeys, -3));

            $averageAbsent = array_intersect_key($averageAbsent, array_flip($selectedKeys));

            return $averageAbsent;
        } else {
            foreach ($this->absents as $userId => $absents) {
                if (is_string($absents)) {
                    $averageAbsent[$userId] = 0;
                } else {
                    $averageAbsent[$userId] = count($absents);
                }
            }

            asort($averageAbsent);
            $sortedKeys = array_keys($averageAbsent);

            $selectedKeys = array_slice($sortedKeys, 0, 3);
            $selectedKeys = array_merge($selectedKeys, array_slice($sortedKeys, -3));

            $averageAbsent = array_intersect_key($averageAbsent, array_flip($selectedKeys));

            return $averageAbsent;
        }
    } // 0.032 ms

    public function PromedioAusentesClases()
    {
        if (isset($this->absents['null'])) {
            return $this->students->count();
        }
        $totalAusentes = null;
        foreach ($this->absents as $absents) {
            if (!is_string($absents)) {
                $totalAusentes += count($absents);
            }
        }

        return number_format($totalAusentes / $this->clases, 2, '.', '');
    } // 0.065 ms

    public function PromedioRetirosSemana()
    {
        $totalRetiros = null;

        foreach ($this->retirements as $retirements) {
            if (!is_string($retirements)) {
                $totalRetiros += count($retirements);
            }
        }

        $clasesPorSemana = $this->clases / 5;
        return number_format($totalRetiros / $clasesPorSemana / $this->clases, 3, '.', '');
    } // 0.3 ms

    public function AusentesHoy($fecha, bool $ids = null)
    {
        $totalAusentesHoy = 0;

        foreach ($this->students as $key => $student) {
            if ($this->absents->has($student->id)) {
                if (array_search($fecha->toDateString(), $this->absents[$student->id])) {
                    if ($ids) {
                        $keys[$key] = $key;
                    } else {
                        $totalAusentesHoy++;
                    }
                }
            }
        }

        if ($ids) {
            return $keys;
        } else {
            return $totalAusentesHoy;
        }
    } // 0.4 ms

    public function PresenteAusente($id)
    {
        $presentAusentes = 0;

        if ($this->attendances->has($id)) {
            foreach ($this->attendances[$id] as $attendance) {
                if ($attendance->format('H:i:s') >= $this->ausenteClases && $attendance->format('H:i:s') <= $this->finClases) {
                    $presentAusentes++;
                }
            }
        }

        return $presentAusentes;
    } // 0.1 ms

    public function Ausentes($id): int
    {
        $ausentes = $this->clases;

        return $ausentes - $this->Presentes($id);
    } // 0.12 ms

    public function Retiradas($id)
    {
        return (array_key_exists($id, $this->retirements) && !is_string($this->retirements[$id])) ? (count($this->retirements[$id])) : 0;
    } // 0.030 ms

    public function Presentes($id)
    {
        return ((array_key_exists($id, $this->attendances) && !is_string($this->attendances[$id])) ? count($this->attendances[$id]) : 0) - ((array_key_exists($id, $this->retirements) && !is_string($this->retirements[$id])) ? (count($this->retirements[$id]) / 2) : 0) - $this->PresenteAusente($id);
    } // 0.12 ms
}
