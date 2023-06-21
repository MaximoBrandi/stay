<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AttendanceAbsent extends LivewireDatatable
{
    public $model = User::class;

    public $exportable = true;

    public function builder()
    {
        $attendanceModelsCrud = AttendanceModel::whereDate('created_at', \Illuminate\Support\Carbon::today())->get('student_id')->map(function($i) {return array_values($i->only('student_id'));})->toArray();
        $attendanceModel = array();

        foreach ($attendanceModelsCrud as $key => $value) {
            array_push($attendanceModel, $value[0]);
        }

        return User::query()->where('current_team_id', '=', Auth::user()->currentTeam->id)->whereNotIn('id', $attendanceModel)->where('users.id', '>', '6');
    }

    public function columns()
    {
        return [
        Column::name('users.name')->label('Name'),

        Column::name('users.email')->label('Email'),

        NumberColumn::name('users.id')->label('Student ID')
        ];
    }
}
