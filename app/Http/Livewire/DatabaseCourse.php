<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DatabaseCourse extends Component
{
    public $course;
    public $initialized = false;
    public function initialize()
    {
        $this->initialized = true;
    }
    public function render()
    {
        return view('livewire.database-course');
    }
    public function handleClick()
    {
        // This will prevent the component from reinitializing
        $this->emit('click.prevent');
    }
}
