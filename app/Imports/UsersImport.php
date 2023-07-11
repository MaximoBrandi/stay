<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Privileges;
use App\Models\Team;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\OpenAccount;
use Illuminate\Support\Str;

class UsersImport implements ToModel
{
    private $loginLink = "http://localhost:8000/login";
    private int $privilege;

    public function __construct(int $privilege = null) {
        $this->privilege = $privilege;
    }

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
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

        if ($this->privilege == 2) {
            $student->current_team_id = 0;

            $student->save();
        } else {
            $student->current_team_id = $row[5];

            $student->save();

            Team::find($row[5])->users()->attach($student, ['role' => 'student']);
        }

        $privilege = new Privileges;
        $privilege->user_id = $student->id;
        if(isset($this->privilege)){
            $privilege->privilege_grade = $this->privilege;
        }else{
            $privilege->privilege_grade = 1;
        }
        $privilege->save();

        if (!config('app.debug')) {
            Mail::to($student)->send(new OpenAccount($password, $this->loginLink));
        }
    }
}
