<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\AttendanceModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use App\Http\Controllers\DateController;

class DisengageStudents extends LivewireDatatable
{
    public $model = User::class;
    public $course;
    public $exportable = true;
    private $dateController;

    public function builder()
    {
        if (Auth::user()->privilege->privilege_grade == 3) {
            $this->course = Auth::user()->current_team_id;
        }

        $this->dateController = new DateController($this->course);

        return User::query()->whereIn('id', $this->dateController->Libres($this->course));
    }

    public function columns()
    {
        return [
        Column::name('name')->label('Name'),

        Column::name('email')->label('Email'),

        Column::name('id')->label('Student ID'),

        Column::callback(['id'], function ($id) {
            $pistacho = $this->dateController->Ausentes($id);

            return $pistacho;
        })->label('Absents')

        ];
    }
}
