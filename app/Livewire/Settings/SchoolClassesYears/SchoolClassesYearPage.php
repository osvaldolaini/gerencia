<?php

namespace App\Livewire\Settings\SchoolClassesYears;

use App\Models\Settings\SchoolClassesYears;
use Livewire\Component;

class SchoolClassesYearPage extends Component
{
    public $school_classes_years;
    public function mount(SchoolClassesYears $school_classes_years)
    {
        if ($school_classes_years) {
            $this->school_classes_years = $school_classes_years;
        }
    }

    public function render()
    {
        return view('livewire.settings.school-classes-years.school-classes-year-page');
    }
}
