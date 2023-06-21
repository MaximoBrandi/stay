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

class AbsentDay extends LivewireDatatable
{
    public $model = User::class;
    public $course;
    public $counting = 0;
    private $absentDay;
    public $exportable = true;

    public function builder()
    {
        if (Auth::user()->privilege->privilege_grade == 3) {
            $this->course = Auth::user()->current_team_id;
        }

        $this->absentDay = (new DateController($this->course))->AbsentDay($this->course);

        $this->counting = 0;

        return User::query()->whereIn('id', $this->absentDay[0]);
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        NumberColumn::name('id')->label('Student ID'),

        NumberColumn::callback(['id'], function ($id) {
            $pistacho = $this->absentDay[1][$this->counting];

            $this->counting++;

            return $pistacho;
        })->defaultSort('desc')->label('Absents'),
        ];
    }
}
