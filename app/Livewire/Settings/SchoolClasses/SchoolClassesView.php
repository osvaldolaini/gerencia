<?php

namespace App\Livewire\Settings\SchoolClasses;

use App\Models\Settings\Companies;
use App\Models\Settings\SchoolGrades;
use Livewire\Component;

class SchoolClassesView extends Component
{
    public $company;
    public $id;
    public $classes;
    public $print;

    public function mount(SchoolGrades $school_grades)
    {
        if ($school_grades->getAttributes()) {
            $this->id      = $school_grades->id;
            $this->company = $school_grades->getCompany;
            $this->classes = $school_grades->getClasses;
            $this->print = $school_grades->getClasses->pluck('id')->toArray();
        }
    }
    public function render()
    {
        return view('livewire.settings.school-classes.school-classes-view');
    }
    public function removeClass($id)
    {
        unset($id, $this->print);
        dd($this->print);
    }
}
