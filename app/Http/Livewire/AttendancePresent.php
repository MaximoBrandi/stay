<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;

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

        Column::name('users.id')->label('Student ID')
        ];
    }
}
