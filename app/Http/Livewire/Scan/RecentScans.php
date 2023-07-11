<?php

namespace App\Http\Livewire\Scan;

use Carbon\Carbon;
use App\Models\AttendanceModel;
use App\Models\Team;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;

class RecentScans extends LivewireDatatable
{


    public function builder()
    {
        return AttendanceModel::query()->orderByDesc('created_at')->whereDate('attendance_models.created_at', Carbon::today())->with('user')->limit(10);

    }

    public function columns()
    {
        return [
            Column::name('user.name')->label('Name'),

            Column::callback(['user.profile_photo_path', 'user.name'], function ($id, $name) {

                return "<img class=\"w-8 h-8 rounded-full object-cover\" src=".$id." alt=".$name.">";
            })->label('Profile picture'),

            Column::callback(['id'], function ($id) {
                    return "Attendance";
            })->label('Type'),

            Column::callback(['user.current_team_id'], function ($id) {
                    return Team::find($id)->name;
            })->label('Course'),

            DateColumn::name('created_at')->label('Date'),

            TimeColumn::name('updated_at')->label('Time')->defaultSort('desc')
        ];
    }
}
