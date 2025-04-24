<?php

namespace App\Livewire\Students;

use App\Models\Peoples;
use Livewire\Component;

class StudentHistory extends Component
{
    public $student;
    public $read;
    public $showReadModal = false;
    public $activeTab = 'fafd';

    public function mount(Peoples $student)
    {
        $this->student = $student;
    }
    public function render()
    {
        return view('livewire.students.student-history');
    }
    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    //VER
    public function showRead(Peoples $student)
    {
        $this->showReadModal = true;
        $this->read = '';
        // dd($student);
        if ($student) {
            $this->read = $student;
        }
    }
}
