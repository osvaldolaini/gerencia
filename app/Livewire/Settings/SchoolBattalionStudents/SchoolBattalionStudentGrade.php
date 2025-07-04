<?php

namespace App\Livewire\Settings\SchoolBattalionStudents;

use App\Models\Settings\Companies;
use App\Models\Settings\SchoolBattalions;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SchoolBattalionStudentGrade extends Component
{
    public $school_years;
    public $school_grade;
    public $companies;
    public $school_battalions;
    public $school_classes_year_id;

    public function mount(SchoolBattalions $school_battalion)
    {
        $this->school_battalions = $school_battalion;
        $this->school_grade = SchoolGrades::where('active', 1)->orderby('nick', 'desc')->get();
        $this->school_classes_year_id = SchoolClassesYears::where('active', 1)->first()->id;
        $companiesAccess = Auth::user()->json_companies;
        if (in_array('all', $companiesAccess)) {
            $this->companies = Companies::where('active', 1)->get();
        } else {
            $this->companies = Companies::where('active', 1)->whereIn('id', Auth::user()->json_companies)->get();
        }
    }

    public function render()
    {
        return view('livewire.settings.school-battalion-students.school-battalion-student-grade');
    }
}
