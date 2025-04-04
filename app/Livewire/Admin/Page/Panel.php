<?php

namespace App\Livewire\Admin\Page;

use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Panel extends Component
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
            $companiesAccess = Auth::user()->json_companies;
            if (in_array('all', $companiesAccess)) {
                $this->companies = Companies::where('active', 1)->get();
            } else {
                $this->companies = Companies::where('active', 1)->whereIn('id', Auth::user()->json_companies)->get();
            }
        }

        if (Auth::user()->panel == 'user') {
            $this->redirect('aplicativo');
        }
    }
    public function render()
    {
        return view('livewire.admin.page.panel');
    }
}
