<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class CourseStudents extends LivewireDatatable
{
    public $model = User::class;

    public $exportable = true;

    public function builder()
    {
        return User::query()->where('current_team_id', '=', Auth::user()->currentTeam->id)->where('id', '>', 6);
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        NumberColumn::name('id')->defaultSort()->label('Student ID')
        ];
    }
}
