<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithTitle;


class UsersExport implements FromQuery, WithTitle
{
    use Exportable;

    public array $course;
    public array $ids;
    public int $privilege;

    public function forPrivilege(int $privilege)
    {
        $this->privilege = $privilege;

        return $this;
    }

    public function forUser(array $ids)
    {
        $this->ids = $ids;

        return $this;
    }

    public function forCourse(array $course)
    {
        $this->course = $course;

        return $this;
    }

    public function query()
    {
        if (isset($this->ids)) {
            return User::query()->whereIn('id', $this->ids);
        }

        if (isset($this->course) && isset($this->privilege)) {
            return User::query()->whereIn('current_team_id', $this->course)
                    ->whereHas('privilege', function ($query) {
                $query->where('privilege_grade', '=', $this->privilege);
            });
        }

        if (isset($this->course)) {
            return User::query()->whereIn('current_team_id', $this->course);
        }

        if (isset($this->privilege)) {
            return User::query()->whereHas('privilege', function ($query) {
                $query->where('privilege_grade', '=', $this->privilege);
            });
        }

        return User::query()->all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        if ($this->privilege == 3) {
            return 'Preceptors';
        }elseif($this->privilege == 1){
            return 'Students';
        }else{
            return 'Users';
        }
    }
}
