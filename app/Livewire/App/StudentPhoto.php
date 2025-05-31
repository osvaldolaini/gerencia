<?php

namespace App\Livewire\App;

use App\Models\Peoples;
use Livewire\Component;
use Livewire\WithFileUploads;

class StudentPhoto extends Component
{
    public $student;
    public $foto;
    use WithFileUploads;
    public function mount(Peoples $student)
    {
        $this->student = $student;
    }
    public function render()
    {
        return view('livewire.app.student-photo');
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
