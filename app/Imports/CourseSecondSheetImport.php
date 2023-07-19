<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class CourseSecondSheetImport implements ToModel
{

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        if ($row[3] !== null) {
            $preceptor = User::find($row[1]);

            $preceptor->switchTeam($team = $preceptor->ownedTeams()->create([
                'name' => $row[2],
                'personal_team' => false,
            ]));

            $team->startCycle = Carbon::parse($row[5])->setTimezone(env('APP_TIMEZONE', 'UTC'));
            $team->endCycle = Carbon::parse($row[6])->setTimezone(env('APP_TIMEZONE', 'UTC'));
            $team->shift = $row[3];
            $team->save();

            $preceptor->current_team_id = $team->id;
            $preceptor->save();
        } else {
            return null;
        }
    }
}
