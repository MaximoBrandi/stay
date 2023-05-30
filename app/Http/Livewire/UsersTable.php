<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;

class UsersTable extends LivewireDatatable
{
    public $model = AttendanceModel::class;

    public function builder()
    {
        return AttendanceModel::query()->where('student_id', '=', Auth::user()->id)->leftJoin('users', 'users.id', 'attendance_models.student_id');
    }

    public function columns()
    {
        return [
        Column::name('users.name')->label('Name'),

        DateColumn::name('created_at')->label('Time')
        ];
    }
}
