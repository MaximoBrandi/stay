<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Team;

class UpdatePreceptor extends Component
{
    public $preceptor;

    public $oldPreceptor;
    public $team;
    public function setPreceptor($user){

        $this->team->owner->id = User::find($user)->id;

        $this->preceptor = User::find($user)->id;

    }

    public function saveCoursePreceptor(){
        $this->team->forceFill([
            'user_id' => $this->preceptor->id,
        ])->save();

        $this->preceptor->switchTeam($this->team);

        $this->oldPreceptor->current_team_id = 0;
    }
    public function render()
    {
        if (!isset($preceptor)) {
            $this->preceptor = $this->team->owner;
        }

        $this->oldPreceptor = $this->team->owner;

        return view('livewire.update-preceptor');
    }
}
