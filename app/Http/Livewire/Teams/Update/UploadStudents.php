<?php

namespace App\Http\Livewire\Teams\Update;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\UsersImport;
use App\Mail\OpenAccount;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Privileges;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UploadStudents extends Component
{
    use WithFileUploads;
    public $excel;
    public $team;
    public $course;
    private $loginLink = "http://localhost:8000/login";
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

            $temporaryPassword = $this->team[$key][2];

            if (!config('app.debug')) {
                Mail::to($student)->send(new OpenAccount($temporaryPassword, $this->loginLink));
            }
        }

        $this->emit('saved');
    }
    public function download()
    {
        return Storage::download('public/StudentsUploadExample.xlsx');
    }
    public function render()
    {
        return view('livewire.teams.update.upload-students');
    }
}
