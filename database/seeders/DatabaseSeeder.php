<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Privileges;
use App\Models\Team;

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
        $teams = array();

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
            ]));

            array_push($teams, $team);

            $privilege = new Privileges;
            $privilege->user_id = $preceptor->id;
            $privilege->privilege_grade = 3;
            $privilege->save();

            $course_id++;
        }

        $students = User::factory(60)->create();

        $course_id = 1;

        foreach($students as $student) {
            if ($student_counter > 24) {
                $course_id++;
                $student_counter = 0;
            }

            $student_counter++;
            $student_id++;
            $student->name = 'Student '.$student_id;
            $student->email = 'student-'.$student_id.'@gmail.com';
            $student->current_team_id = $course_id;
            $student->save();

            Team::find($course_id)->users()->attach($student, ['role' => 'student']);

            $privilege = new Privileges;
            $privilege->user_id = $student->id;
            $privilege->privilege_grade = 1;
            $privilege->save();
        }
    }
}
