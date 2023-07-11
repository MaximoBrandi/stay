<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Privileges;
use App\Models\Team;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\OpenAccount;
use Illuminate\Support\Str;

class CourseFirstSheetImport implements ToModel
{
    private $loginLink = "http://localhost:8000/login";

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        static $password;

        $preceptor = User::factory(1)->create()->first();


        $preceptor->name = $row[1];
        $preceptor->email = $row[2];
        if (!config('app.debug')) {
            $password = Str::random(10);

            $preceptor->password = bcrypt($password);
        }else{
            $preceptor->password = bcrypt('12341234');
        }
        $preceptor->save();

        $privilege = new Privileges;
        $privilege->user_id = $preceptor->id;
        $privilege->privilege_grade = 3;
        $privilege->save();

        if (!config('app.debug')) {
            Mail::to($preceptor)->send(new OpenAccount($password, $this->loginLink));
        }
    }
}
