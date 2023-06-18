<?php

namespace App\Http\Livewire;

use App\Models\retirement;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;

class RetirementsTable extends LivewireDatatable
{
    public $model = retirement::class;

    public function builder()
    {
        return retirement::query()->where('student_id', '=', Auth::user()->id)->leftJoin('users', 'users.id', 'retirements.student_id');
    }

    public function columns()
    {
        return [
        Column::name('users.name')->label('Name'),

        DateColumn::name('created_at')->label('Time')
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
