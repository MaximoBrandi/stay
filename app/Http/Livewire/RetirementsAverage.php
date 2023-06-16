<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\retirement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use App\Http\Controllers\DateController;

class RetirementsAverage extends LivewireDatatable
{
    public $model = User::class;
    public $course;
    public $counting = 0;
    public $exportable = true;
    private $averageRetirement;

    public function builder()
    {
        $dateController = new DateController($this->course);

        if (Auth::user()->privilege->privilege_grade == 3) {
            $this->course = Auth::user()->current_team_id;
        }

        $this->counting = 0;

        $this->averageRetirement = $dateController->AverageRetirement($this->course);

        return User::query()->whereIn('id', array_keys($this->averageRetirement));
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        Column::name('id')->label('Student ID'),

        Column::callback(['id'], function ($id) {
            $array = array_values($this->averageRetirement)[$this->counting];

            $this->counting++;

            return $array;
        })->label('Retirements'),
        ];
    }
}
