<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\retirement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class RetirementStatus extends LivewireDatatable
{
    public $model = User::class;

    public $exportable = true;
    public $course;

    public function builder()
    {
        return retirement::query()->whereDate('retirements.created_at', Carbon::today())->leftJoin('users', 'users.id', 'retirements.student_id')->where('users.current_team_id', '=', $this->course);
    }

    public function columns()
    {
        return [
        Column::name('users.name')->label('Name'),

        Column::name('users.email')->label('Email'),

        DateColumn::name('attendance_models.created_at')->label('Date'),

        TimeColumn::name('attendance_models.updated_at')->label('Time'),

        NumberColumn::name('users.id')->label('Student ID')
        ];
    }
}
