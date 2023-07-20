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

class DisengageStudents extends LivewireDatatable
{
    public $model = User::class;
    public Team $course;
    public $exportable = true;
    private DateController $dateController;

    public function builder()
    {
        if (Auth::user()->privilege->privilege_grade == 3) {
            $this->course = Auth::user()->currentTeam;
        }

        $this->dateController = new DateController($this->course, true);

        return User::query()->whereIn('id', $this->dateController->Libres());
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        NumberColumn::name('id')->defaultSort('desc')->label('Student ID'),

        NumberColumn::callback(['id'], function ($id) {
            $pistacho = $this->dateController->Ausentes($id);

            return $pistacho;
        })->label('Absents')

        ];
    }
}

// 292 ms
