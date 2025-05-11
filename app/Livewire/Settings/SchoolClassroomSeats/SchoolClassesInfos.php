<?php

namespace App\Livewire\Settings\SchoolClassroomSeats;

use App\Models\Settings\SchoolClasses;
use Livewire\Component;

use Illuminate\Support\Str;

class SchoolClassesInfos extends Component
{
    public $rules;
    public $school_classes_id;
    public $rows;
    public $columns;
    public $door_side;



    public function mount(SchoolClasses $school_classes)
    {
        if ($school_classes->getAttributes()) {
            $this->school_classes_id = $school_classes->id;
            $this->rows = $school_classes->rows;
            $this->columns = $school_classes->columns;
            $this->door_side = $school_classes->door_side;
        }
    }
    public function render()
    {
        return view('livewire.settings.school-classroom-seats.school-classes-infos');
    }
    public function update()
    {
        $this->rules = [
            'columns' => 'min:1|max:1|required',
            'rows' => 'min:1|max:1|required',
            'door_side' => 'required',
        ];
        $this->validate();
        $class = SchoolClasses::updateOrCreate([
            'id'    => $this->school_classes_id,
        ], [
            'rows' => $this->rows,
            'columns' => $this->columns,
            'door_side' => $this->door_side,
        ]);

        $msg = 'Registro editado com sucesso.';


        $this->dispatch('resetSeats');
        $this->openAlert('success', $msg);
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
