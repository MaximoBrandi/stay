<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Holiday;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Privileges;
use App\Models\Team;
use App\Models\retirement;
use App\Models\AttendanceModel;
use App\Models\CourseSchedule;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $student_counter = 0;
        $student_id = 0;
        $course_id = 1;
        $preceptor_id = 0;
        $accountant_id = 0;
        $teams = array();

        $feriados = array(
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

        $recesoInicio = Carbon::create(2023, 7, 17, 0);

        $key = array_key_last($feriados);

        while ($recesoInicio <= Carbon::create(2023, 7, 28, 0)) {
            if ($recesoInicio->isWeekday() && !in_array($recesoInicio, $feriados)) {
                $key++;

                $feriados[$key] = clone $recesoInicio;
            }

            $recesoInicio->addDay();
        }

        foreach ($feriados as $key => $value) {
            $holiday = new Holiday;
            $holiday->date = $value;
            $holiday->save();
        }

        $holidays = Holiday::pluck('date');

        $preceptors = User::factory(3)->create();

        foreach($preceptors as $preceptor) {
            $preceptor_id++;
            $preceptor->name = 'Preceptor '.$preceptor_id;
            $preceptor->email = 'preceptor-'.$preceptor_id.'@gmail.com';
            $preceptor->current_team_id = $course_id;
            $preceptor->save();

            $preceptor->switchTeam($team = $preceptor->ownedTeams()->create([
                'name' => 'Course '.$course_id,
                'personal_team' => false,
                'shift' => 'night',
                'startCycle' => Carbon::create(2023, 2, 27, 0),
                'endCycle' => Carbon::create(2023, 12, 22, 0),
            ]));

            $schedule = new CourseSchedule;

            $schedule->openTime = Carbon::createFromTime(17, 00, 0)->format('H:i:s');
            $schedule->startTime = Carbon::createFromTime(18, 0, 0)->format('H:i:s');
            $schedule->lateTime = Carbon::createFromTime(18, 30, 0)->format('H:i:s');
            $schedule->absentTime = Carbon::createFromTime(18, 45, 0)->format('H:i:s');
            $schedule->closeTime = Carbon::createFromTime(22, 50, 0)->format('H:i:s');
            $schedule->team_id = $course_id;
            $schedule->shift = "night";
            $schedule->save();

            array_push($teams, $team);

            $privilege = new Privileges;
            $privilege->user_id = $preceptor->id;
            $privilege->privilege_grade = 3;
            $privilege->save();

            $course_id++;
        }

        $accountants = User::factory(3)->create();

        foreach($accountants as $accountant) {
            $accountant_id++;
            $accountant->name = 'accountant '.$accountant_id;
            $accountant->email = 'accountant-'.$accountant_id.'@gmail.com';
            $accountant->current_team_id = $course_id;
            $accountant->save();

            $privilege = new Privileges;
            $privilege->user_id = $accountant->id;
            $privilege->privilege_grade = 4;
            $privilege->save();
        }

        $students = User::factory(60)->create();

        $course_id = 1;

        foreach($students as $student) {
            if ($student_counter >= 24) {
                $course_id++;
                $student_counter = 0;
            }

            $student_counter++;
            $student_id++;
            $student->name = 'Student '.$student_id;
            $student->email = 'student-'.$student_id.'@gmail.com';
            $student->current_team_id = $course_id;
            $student->save();

            $contador = Carbon::create(2023, 2, 27, 0);

            $rounds = rand(0,20);

            for ($i=0; $i < $rounds; $i++) {
                $hour = rand(19,22);
                $minute = rand(10,50);

                if ($contador->isWeekday() && !in_array($contador, $holidays->toArray())) {
                    $retirement = new retirement;
                    $retirement->created_at = Carbon::create($contador->year, $contador->month, $contador->day, $hour, $minute, 0);
                    $retirement->updated_at = Carbon::create($contador->year, $contador->month, $contador->day, $hour, $minute, 0);
                    $retirement->student_id = $student_id + 6;
                }else{
                    $rounds++;
                }

                $contador->addDay();

                $retirement->save();
            }

            $contador = Carbon::create(2023, 2, 27, 0);

            $rounds = rand(60,82);

            for ($i=0; $i < $rounds; $i++) {
                $hour = 18;
                $minute = rand(0,46);

                if ($contador->isWeekday() && !in_array($contador, $holidays->toArray())) {
                    $attendance = new AttendanceModel;
                    $attendance->created_at = Carbon::create($contador->year, $contador->month, $contador->day, $hour, $minute, 0);
                    $attendance->updated_at = Carbon::create($contador->year, $contador->month, $contador->day, $hour, $minute, 0);
                    $attendance->student_id = $student_id + 6;
                }else{
                    $rounds++;
                }

                $contador->addDay();

                $attendance->save();
            }


            Team::find($course_id)->users()->attach($student, ['role' => 'student']);

            $privilege = new Privileges;
            $privilege->user_id = $student->id;
            $privilege->privilege_grade = 1;
            $privilege->save();
        }

    }
}
