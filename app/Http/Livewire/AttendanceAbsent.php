<?php

namespace App\Http\Livewire;

use App\Http\Controllers\DateController;
use App\Models\User;
use App\Models\AttendanceModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\NumberColumn;

class AttendanceAbsent extends LivewireDatatable
{
    public $model = User::class;

    public $exportable = true;

    public function builder()
    {
        return User::query()->where('current_team_id', '=', Auth::user()->currentTeam->id)->whereNotIn('id', ((new DateController(Auth::user()->current_team_id, true))->AusentesHoy(Carbon::today(), true)))->where('users.id', '>', '6');
    }

    public function columns()
    {
        return [
        Column::name('users.name')->label('Name'),

        Column::name('users.email')->label('Email'),

        NumberColumn::name('users.id')->label('Student ID')
        ];
    }
}
