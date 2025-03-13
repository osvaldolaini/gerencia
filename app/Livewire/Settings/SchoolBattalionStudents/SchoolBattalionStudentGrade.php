<?php

namespace App\Livewire\Settings\SchoolBattalionStudents;

use App\Models\Settings\Companies;
use App\Models\Settings\SchoolBattalions;
use App\Models\Settings\SchoolGrades;
use Livewire\Component;

class SchoolBattalionStudentGrade extends Component
{
    public $school_years;
    public $school_grade;
    public $companies;
    public $school_battalions;

    public function mount(SchoolBattalions $school_battalions)
    {
        $this->school_battalions = $school_battalions;
        $this->school_grade = SchoolGrades::where('active', 1)->orderby('nick', 'desc')->get();
        $this->companies = Companies::where('active', 1)->get();
    }

    public function render()
    {
        return view('livewire.settings.school-battalion-students.school-battalion-student-grade');
    }
}
