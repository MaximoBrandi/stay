<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use App\Http\Controllers\DateController;
use App\Models\Team;

class AbsentDay extends LivewireDatatable
{
    public $model = User::class;
    public Team $course;
    public int $counting = 0;
    private array $absentDay;
    public $exportable = true;

    public function builder()
    {
        if (Auth::user()->privilege->privilege_grade == 3) {
            $this->course = Auth::user()->currentTeam;
        }

        $this->absentDay = (new DateController($this->course))->AbsentDay();

        $this->counting = 0;

        return User::query()->whereIn('id', array_keys($this->absentDay));
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        NumberColumn::name('id')->label('Student ID'),

        NumberColumn::callback(['id'], function ($id) {
            $pistacho = array_values($this->absentDay)[$this->counting];

            $this->counting++;

            return $pistacho;
        })->defaultSort('desc')->label('Absents'),
        ];
    }
}

// 4811 ms
