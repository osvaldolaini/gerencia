<?php

namespace App\Livewire\Settings\SchoolBattalionStudents;

use App\Livewire\Settings\SchoolClasses\SchoolClassesStudents;
use Livewire\Component;

class SchoolBattalionStudentPage extends Component
{
    public $school_battalion_student;
    public function mount(SchoolClassesStudents $school_battalion_student)
    {
        if ($school_battalion_student) {
            $this->school_battalion_student = $school_battalion_student;
        }
    }
    public function render()
    {
        return view('livewire.settings.school-battalion-students.school-battalion-student-page');
    }
}
