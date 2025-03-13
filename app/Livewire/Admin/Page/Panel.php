<?php

namespace App\Livewire\Admin\Page;

use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use Livewire\Component;

class Panel extends Component
{
    public $school_years;
    public $school_grade;
    public $companies;
    public function mount()
    {
        $this->school_years = SchoolClassesYears::where('active', 1)->first();
        $this->school_grade = SchoolGrades::where('active', 1)->orderby('nick', 'desc')->get();
        $this->companies = Companies::where('active', 1)->get();
    }
    public function render()
    {
        return view('livewire.admin.page.panel');
    }
}
