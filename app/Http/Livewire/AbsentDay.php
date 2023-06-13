<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use App\Http\Controllers\DateController;

class AbsentDay extends LivewireDatatable
{
    public $model = User::class;
    public $curso;
    public $exportable = true;

    public function builder()
    {
        if (Auth::user()->privilege->privilege_grade == 3) {
            $this->curso = Auth::user()->current_team_id;
        }

        return User::query()->whereIn('id', (new DateController)->Libres($this->curso));
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        Column::name('id')->label('Student ID')
        ];
    }
}
