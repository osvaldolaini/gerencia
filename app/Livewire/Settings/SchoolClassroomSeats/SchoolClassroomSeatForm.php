<?php

namespace App\Livewire\Settings\SchoolClassroomSeats;

use App\Models\Settings\SchoolClasses;
use Livewire\Component;

class SchoolClassroomSeatForm extends Component
{
    public $breadcrumb = 'Turma: ';
    public $school_classes;
    //Fields
    public $school_classes_id;
    public $row;
    public $columns;
    public $door_side;

    public function mount(SchoolClasses $school_classes)
    {
        if ($school_classes->getAttributes()) {
            $this->row = $school_classes;
            $this->school_classes_id = $school_classes->id;
            $this->title        = $school_classes->title;
            $this->year         = $school_classes->school_classes_year_id;
            $this->breadcrumb .= $this->title . ' / ' . $school_classes->classYears->year;

            $school_classes_year_id = $school_classes->classYears->id;
        }
    }
    public function render()
    {
        return view('livewire.settings.school-classroom-seats.school-classroom-seat-form');
    }
}
