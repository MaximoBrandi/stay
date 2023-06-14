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

class RetirementStatus extends LivewireDatatable
{
    public $model = User::class;
    public $curso;
    public $counting = 0;
    public $exportable = true;

    public function builder()
    {
        if (Auth::user()->privilege->privilege_grade == 3) {
            $this->curso = Auth::user()->current_team_id;
        }

        $this->counting = 0;

        $array = array_keys((new DateController)->AverageRetirement($this->curso));

        return User::query()->whereIn('id', $array);
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        Column::name('id')->label('Student ID'),

        Column::callback(['id'], function ($id) {
            $array = array_values((new DateController)->AverageRetirement($this->curso))[$this->counting];

            $this->counting++;

            return $array;
        })->label('Retirements'),
        ];
    }
}
