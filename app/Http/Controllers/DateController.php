<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use App\Models\AttendanceModel;
use App\Models\Holiday;
use App\Models\retirement;
use App\Models\Team;
use App\Models\User;

class DateController extends Controller
{
    private readonly Team $course;

    private readonly array $feriados;
    private readonly array $attendances;

    private readonly array $attendancesDays;

    private readonly array $retirements;
    private readonly array $absents;
    private readonly array $classDays;

    private readonly int $clases;
    private $students;
    private $prom;

    public function __construct($course)
    {
        $this->course = $course;

        $this->Initialize();
    }

    private function Initialize()
    {
        $this->feriados = Holiday::pluck('date')->toArray();

        $this->students = User::whereHas('privilege', function ($query) {
            return $query->where('privilege_grade', '=', 1);
        })->where('current_team_id', '=', $this->course->id)->get();

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

        $this->classDays = array_values(array_diff(CarbonPeriod::create($this->course->startCycle, Carbon::now())->filter('isWeekday')->toArray(), $this->feriados));

        foreach ($this->attendancesDays as $usuarioId => $fechasPresentes) {
            $classDays = collect($this->classDays)->map(function ($attendance) {
                return $attendance->toDateString();
            })->toArray();

            $resultados[$usuarioId] = array_values(array_diff($classDays, $fechasPresentes));
        }

        $this->absents = isset($resultados) ? $resultados : array("null" => "null");

        $contador = $this->course->startCycle;

        $clases = 0;

        while (Carbon::now() >= $contador) {
            if ($contador->isWeekday() && !in_array($contador, $this->feriados)) {
                $clases++;
            }

            $contador->addDay(); // Avanza al siguiente día
        }

        $this->clases = $clases;
    }

    public function Tardes($id) : int
    {
        $tardes = 0;

        if (array_key_exists($id, $this->attendances)) {
            foreach ($this->attendances[$id] as $attendance) {
                if ($attendance->format('H:i:s') >= $this->course->schedule->lateTime && $attendance->format('H:i:s') <= $this->course->schedule->absentTime) {
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

    public function AbsentDay() : array
    {
        $diaAusente = $this->DiaConMasAusentes();

        $absentDay = collect($this->absents)->filter(function ($value, $key) {
            return $key !== 'null';
        })->map(function ($value, $key) use ($diaAusente) {
            $contadorAusentes = 0;
            foreach ($value as $fecha) {
                if (Carbon::parse($fecha)->dayName == $diaAusente) {
                    $contadorAusentes++;
                }
            }
            return [
                'id' => $key,
                'contadorAusentes' => $contadorAusentes,
            ];
        })->filter(function ($item) {
            return $item['contadorAusentes'] >= $this->prom;
        })->sortByDesc('contadorAusentes')->pluck('id');

        return $absentDay->toArray();
    } // 59

    public function DiaConMasAusentes() : string
    {
        $contador = $this->course->startCycle;
        $dias = [
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
        ];

        while (Carbon::now() >= $contador) {
            if ($contador->isWeekday() && !in_array($contador, $this->feriados)) {
                $dias[$contador->dayName] += $this->AusentesHoy($contador);
            }

            $contador->addDay(); // Avanza al siguiente día
        }

        return array_search(max($dias), $dias);
    } // 17 ms

    public function diaDeClases() : bool
    {
        if (Carbon::now()->isWeekday() && !in_array(Carbon::now(), $this->feriados)) {
            return true;
        } else {
            return false;
        }
    } // 0.265 ms

    public function horaDeClases() : bool
    {
        if (env('APP_DEBUG')) {
            return true;
        }

        if (Carbon::now()->format('H:i:s') >= $this->course->schedule->openTime && Carbon::now()->format('H:i:s') <=  $this->course->schedule->closeTime ) {
            return true;
        } else {
            return false;
        }
    } // 0.8 ms

    public function estadoDelDia(int $id) : int // 1 = Late . 2 = Absent Present . 3 = Present . 4 = Absent
    {
        if (array_key_exists(strval($id), $this->attendances)) {
            foreach ($this->attendances[$id] as $fecha) {
                if ($fecha->isSameDay(Carbon::today())) {
                    if (env('APP_DEBUG')){
                        return 3;
                    }
                    if ($fecha->format('H:i:s') >= $this->course->schedule->lateTime && $fecha->format('H:i:s') <= $this->course->schedule->absentTime) {
                        return 1;
                    } else
                        if ($fecha->format('H:i:s') >= $this->course->schedule->absentTime && $fecha->format('H:i:s') <=  $this->course->schedule->closeTime ) {
                            return 2;
                        } else
                            if ($fecha->format('H:i:s') >= $this->course->schedule->openTime && $fecha->format('H:i:s') <= $this->course->schedule->startTime) {
                                return 3;
                            }
                }
            }
        }

        return 4;
    } // 0.76 ms

    public function AverageRetirement() : array
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

    public function AverageAbsent() : array
    {
        $averageAbsent = [];

        if (isset($this->absents['null'])) {
            foreach ($this->students as $userId => $absents) {
                if (is_string($absents)) {
                    $averageAbsent[$userId] = 0;
                } else {
                    $averageAbsent[$absents->id] = $this->clases;
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

    public function PromedioAusentesClases() : string
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

    public function PromedioRetirosSemana() : string
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

    public function AusentesHoy($fecha, bool $ids = null) : mixed
    {
        $totalAusentesHoy = 0;
        $keys = [];

        foreach ($this->students as $key => $student) {
            if (array_key_exists($student->id, $this->absents)) {
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

    public function PresenteAusente($id) : int
    {
        $presentAusentes = 0;

        if (array_key_exists($id, $this->attendances)) {
            foreach ($this->attendances[$id] as $attendance) {
                if ($attendance->format('H:i:s') >= $this->course->schedule->absentTime && $attendance->format('H:i:s') <= $this->course->schedule->closeTime) {
                    $presentAusentes++;
                }
            }
        }

        return $presentAusentes;
    } // 0.1 ms

    public function Ausentes($id) : int
    {
        $ausentes = $this->clases;

        return $ausentes - $this->Presentes($id);
    } // 0.12 ms

    public function Retiradas($id) : int
    {
        return (array_key_exists($id, $this->retirements) && !is_string($this->retirements[$id])) ? (count($this->retirements[$id])) : 0;
    } // 0.030 ms

    public function Presentes($id) : int
    {
        return ((array_key_exists($id, $this->attendances) && !is_string($this->attendances[$id])) ? count($this->attendances[$id]) : 0) - ((array_key_exists($id, $this->retirements) && !is_string($this->retirements[$id])) ? (count($this->retirements[$id]) / 2) : 0) - $this->PresenteAusente($id);
    } // 0.12 ms
}
