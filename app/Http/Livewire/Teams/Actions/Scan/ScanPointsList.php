<?php

namespace App\Http\Livewire\Teams\Actions\Scan;

use Livewire\Component;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ScanPointsList extends Component
{
    public $team;

    public function __construct() {
        $this->team = User::whereHas('privilege', function ($query) {
            $query->where('privilege_grade', '=', 2);
        })->get();
    }
    public function render()
    {
        return view('livewire.teams.actions.scan.scan-points-list');
    }
}
