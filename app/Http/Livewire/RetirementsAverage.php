<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\retirement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;
use App\Http\Controllers\DateController;
use App\Models\Team;

class RetirementsAverage extends LivewireDatatable
{
    public $model = User::class;
    public Team $course;
    public int $counting = 0;
    public $exportable = true;
    private array $averageRetirement;

    public function builder()
    {
        $dateController = new DateController($this->course, true);

        if (Auth::user()->privilege->privilege_grade == 3) {
            $this->course = Auth::user()->currentTeam;
        }

        $this->counting = 0;

        $this->averageRetirement = $dateController->AverageRetirement();

        return User::query()->whereIn('id', array_keys($this->averageRetirement));
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        NumberColumn::name('id')->label('Student ID'),

        NumberColumn::callback(['id'], function ($id) {
            $array = array_values($this->averageRetirement)[$this->counting];

            $this->counting++;

            return $array;
        })->defaultSort('desc')->label('Retirements'),
        ];
    }
}

// 24 ms
