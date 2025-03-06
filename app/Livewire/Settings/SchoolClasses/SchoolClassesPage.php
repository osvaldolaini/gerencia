<?php

namespace App\Livewire\Settings\SchoolClasses;

use App\Models\Settings\SchoolClasses;
use Livewire\Component;

class SchoolClassesPage extends Component
{
    public $school_classes;
    public function mount(SchoolClasses $school_classes)
    {
        if ($school_classes) {
            $this->school_classes = $school_classes;
        }
    }
    public function render()
    {
        return view('livewire.settings.school-classes.school-classes-page');
    }
}
