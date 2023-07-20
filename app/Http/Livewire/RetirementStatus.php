<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\retirement;
use App\Models\Team;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;

class RetirementStatus extends LivewireDatatable
{
    public $model = User::class;

    public $exportable = true;
    public Team $course;

    public function builder()
    {
        return retirement::query()->whereDate('retirements.created_at', Carbon::today())->leftJoin('users', 'users.id', 'retirements.student_id')->where('users.current_team_id', '=', $this->course);
    }

    public function columns()
    {
        return [
        Column::name('users.name')->label('Name'),

        Column::name('users.email')->label('Email'),

        DateColumn::name('retirements.created_at')->label('Date'),

        TimeColumn::name('retirements.updated_at')->defaultSort('desc')->label('Time'),

        NumberColumn::name('users.id')->label('Student ID')
        ];
    }
}
