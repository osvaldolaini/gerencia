<?php

namespace App\Livewire\Extracurricular\StudentActivities;

use App\Models\Peoples;
use Livewire\Component;

class StudentActivityList extends Component
{
    public $activities;
    public $student;
    public function mount(Peoples $student)
    {
        $this->student  =  $student;
        $this->activities   = $this->student->activities->sortByDesc('title');
    }

    public function render()
    {
        return view('livewire.extracurricular.student-activities.student-activity-list');
    }
}
