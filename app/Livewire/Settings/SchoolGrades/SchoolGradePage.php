<?php

namespace App\Livewire\Settings\SchoolGrades;

use App\Models\Settings\SchoolGrades;
use Livewire\Component;

class SchoolGradePage extends Component
{
    public $school_grades;
    public function mount(SchoolGrades $school_grades)
    {
        if ($school_grades) {
            $this->school_grades = $school_grades;
        }
    }

    public function render()
    {
        return view('livewire.settings.school-grades.school-grade-page');
    }
}
