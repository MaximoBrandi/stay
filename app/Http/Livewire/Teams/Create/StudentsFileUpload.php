<?php

namespace App\Http\Livewire\Teams\Create;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Privileges;

class StudentsFileUpload extends Component
{
    use WithFileUploads;

    public $excel;
    public $team;
    public $preceptor;
    public $courseName;
    public $shift;

    public function save()
    {
        $this->team = Excel::toArray(new UsersImport, $this->excel)[0];

        $this->emit('saved');
    }

    public function setPreceptor($id){
        $this->preceptor = $id;
    }
    public function setCourseName($courseName){
        $this->courseName = $courseName;
    }
    public function setShift($shift){
        $this->shift = $shift;
    }

    public function createTeam(){
        $preceptor = User::find($this->preceptor);

        $preceptor->switchTeam($team = $preceptor->ownedTeams()->create([
            'name' => $this->courseName,
            'personal_team' => false,
        ]));

        $team->shift = $this->shift;
        $team->save();

        foreach (User::factory(count($this->team))->create() as $key => $student) {
            $student->name = $this->team[$key][0];
            $student->email = $this->team[$key][1];
            $student->password = bcrypt($this->team[$key][2]);
            $student->current_team_id = $team->id;
            $student->save();

            $team->users()->attach($student, ['role' => 'student']);

            $privilege = new Privileges;
            $privilege->user_id = $student->id;
            $privilege->privilege_grade = 1;
            $privilege->save();
        }

        $this->emit('created');
    }
    public function render()
    {
        return view('livewire.teams.create.students-file-upload');
    }
}
