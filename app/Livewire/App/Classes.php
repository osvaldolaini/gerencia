<?php

namespace App\Livewire\App;

use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Classes extends Component
{
    public $school_years;
    public $school_grade;
    public $companies;
    public $school_classes_year_id;

    public function mount()
    {
        if (SchoolClassesYears::where('active', 1)->first()) {
            $this->school_years = SchoolClassesYears::where('active', 1)->first();
            $this->school_classes_year_id           = $this->school_years->id;
            $this->school_grade = SchoolGrades::where('active', 1)->orderby('nick', 'desc')->get();
            $this->companies = Companies::where('active', 1)->get();
        }
    }
    public function render()
    {
        return view('livewire.app.classes');
    }
}
