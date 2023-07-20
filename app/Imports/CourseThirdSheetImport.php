<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Privileges;
use App\Models\Team;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\OpenAccount;
use Illuminate\Support\Str;

class CourseThirdSheetImport implements ToModel
{
    private $loginLink = "http://localhost:8000/login";

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        if ($row[5] !== null) {
            static $password;

            $student = User::factory(1)->create()->first();

            $student->name = $row[1];
            $student->email = $row[2];
            if (!config('app.debug')) {
                $password = Str::random(10);

                $student->password = bcrypt($password);
            }else{
                $student->password = bcrypt('12341234');
            }

            $student->current_team_id = $row[5];
            $student->save();

            Team::find($row[5])->users()->attach($student, ['role' => 'student']);

            $privilege = new Privileges;
            $privilege->user_id = $student->id;
            $privilege->privilege_grade = 1;
            $privilege->save();

            if (!config('app.debug')) {
                Mail::to($student)->send(new OpenAccount($password, $this->loginLink));
            }
        } else {
            return null;
        }

    }
}
