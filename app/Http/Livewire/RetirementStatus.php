<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\retirement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;

class RetirementStatus extends LivewireDatatable
{
    public $model = User::class;

    public $exportable = true;

    public function builder()
    {
        return retirement::query()->whereDate('retirements.created_at', \Illuminate\Support\Carbon::today())->where('current_team_id', '=', Auth::user()->currentTeam->id)->leftJoin('users', 'users.id', 'retirements.student_id')->where('users.id', '>', '3');
    }

    public function columns()
    {
        return [
        Column::name('users.name')->label('Name'),

        Column::name('users.email')->label('Email'),

        Column::name('users.id')->label('Student ID')
        ];
    }
    public function rowClasses($row, $loop)
    {
            return 'divide-x divide-gray-100 text-sm text-gray-100 bg-gray-800';
    }

    public function cellClasses($row, $column)
    {
            return 'text-sm text-white';
    }
}
