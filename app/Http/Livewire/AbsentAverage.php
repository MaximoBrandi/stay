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
use Illuminate\Support\Benchmark;

class AbsentAverage extends LivewireDatatable
{
    public $model = User::class;
    public Team $course;
    public int $counting = 0;
    public $exportable = true;
    private array $averageAbsent;

    public function builder()
    {
        $dateController = new DateController($this->course, true);

        if (Auth::user()->privilege->privilege_grade == 3) {
            $this->course = Auth::user()->currentTeam;
        }

        $this->counting = 0;

        $this->averageAbsent = $dateController->AverageAbsent();

        return User::query()->whereIn('id', array_keys($this->averageAbsent));
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        NumberColumn::name('id')->label('Student ID'),

        NumberColumn::callback(['id'], function ($id) {
            $array = array_values($this->averageAbsent)[$this->counting];

            $this->counting++;

            return $array;
        })->label('Absents'),
        ];
    }
}


//468ms
