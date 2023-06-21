<?php

namespace App\Http\Livewire\Teams\Update;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Privileges;
use App\Models\Team;

class UploadStudents extends Component
{
    use WithFileUploads;
    public $excel;
    public $team;
    public $course;
    public function save()
    {
        $this->team = Excel::toArray(new UsersImport, $this->excel)[0];

        foreach (User::factory(count($this->team))->create() as $key => $student) {
            $student->name = $this->team[$key][0];
            $student->email = $this->team[$key][1];
            $student->password = bcrypt($this->team[$key][2]);
            $student->current_team_id = $this->course->id;
            $student->save();

            $this->course->users()->attach($student, ['role' => 'student']);

            $privilege = new Privileges;
            $privilege->user_id = $student->id;
            $privilege->privilege_grade = 1;
            $privilege->save();
        }

        $this->emit('saved');
    }
        public function render()
    {
        return view('livewire.teams.update.upload-students');
    }
}
