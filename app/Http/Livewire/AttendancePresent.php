<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AttendancePresent extends LivewireDatatable
{
    public $model = User::class;

    public $exportable = true;

    public function builder()
    {
        return AttendanceModel::query()->whereDate('attendance_models.created_at', \Illuminate\Support\Carbon::today())->where('current_team_id', '=', Auth::user()->currentTeam->id)->leftJoin('users', 'users.id', 'attendance_models.student_id');
    }

    public function columns()
    {
        return [
        Column::name('users.name')->label('Name'),

        Column::name('users.email')->label('Email'),

        DateColumn::name('attendance_models.created_at')->label('Date'),

        TimeColumn::name('attendance_models.updated_at')->defaultSort('desc')->label('Time'),

        NumberColumn::name('users.id')->label('Student ID')
        ];
    }
}
