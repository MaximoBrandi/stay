<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Privileges;
use App\Models\Team;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Mail;
use App\Mail\OpenAccount;
use Illuminate\Support\Str;

class CourseSecondSheetImport implements ToModel
{

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $preceptor = User::find($row[1]);

        $preceptor->switchTeam($team = $preceptor->ownedTeams()->create([
            'name' => $row[2],
            'personal_team' => false,
        ]));

        $team->shift = $row[3];
        $team->save();

        $preceptor->current_team_id = $team->id;
        $preceptor->save();
    }
}
