<?php

namespace App\Http\Livewire\Teams\Actions;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\CourseImport;
use App\Mail\OpenAccount;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Privileges;
use Illuminate\Support\Facades\Mail;

class UploadCourse extends Component
{
    use WithFileUploads;

    public $excel;
    public $course;
    public $preceptor;
    public $courseName;
    public $shift;
    private $teams;
    private $teamcount;
    public function save()
    {
        $this->course = Excel::toArray(new CourseImport, $this->excel);

        $this->teams = array();

        foreach ($this->course[0] as $key => $value) {
            if ($this->course[1][$key][1] == "null") {
                $preceptor = User::find($this->course[1][$key][0]);

                $preceptor->switchTeam($team = $preceptor->ownedTeams()->create([
                    'name' => $value[0],
                    'personal_team' => false,
                ]));

                $team->shift = $value[1];
                array_push($this->teams, $team);
                $team->save();
            } else {
                $preceptor = User::factory(1)->create()[0];
                $preceptor->name =  $this->course[1][$key][0];
                $preceptor->email =  $this->course[1][$key][1];

                $preceptor->switchTeam($team = $preceptor->ownedTeams()->create([
                    'name' => $value[0],
                    'personal_team' => false,
                ]));

                $team->shift = $value[1];
                $team->save();

                array_push($this->teams, $team);

                $preceptor->current_team_id = $team->id;
                $preceptor->save();

                $privilege = new Privileges;
                $privilege->user_id = $preceptor->id;
                $privilege->privilege_grade = 3;
                $privilege->save();
            }
        }

        $this->teamcount = 0;

        foreach ($this->course[2] as $key => $student) {
            if ($student[0] == "JUMP") {
                $team = $this->teams[$this->teamcount];
                $this->teamcount++;
            } else {
                $studentModel = User::factory(1)->create()[0];

                $studentModel->name = $student[0];
                $studentModel->email = $student[1];
                $studentModel->current_team_id = $team->id;
                $studentModel->save();

                $team->users()->attach($studentModel, ['role' => 'student']);

                $privilege = new Privileges;
                $privilege->user_id = $studentModel->id;
                $privilege->privilege_grade = 1;
                $privilege->save();
            }
        }

        $this->emit('saved');
    }
    public function render()
    {
        return view('livewire.teams.actions.upload-course');
    }
}
