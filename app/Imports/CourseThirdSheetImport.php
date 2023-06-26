<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
use Illuminate\Support\Str;

class CourseThirdSheetImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        static $password;
        foreach ($rows as $row)
        {
            User::create([
                'name'     => $row[0],
                'email'    => $row[1],
                'password' => $password ?: $password = bcrypt($row[2]), // password
                'email_verified_at' => now(),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
                'current_team_id' => null,
            ]);
        }
    }
}
