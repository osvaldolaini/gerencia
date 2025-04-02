<?php

namespace App\Livewire\Faults;

use App\Models\Settings\SchoolClasses;
use Livewire\Component;

use App\Models\Peoples;

use Livewire\Attributes\On;

class SchoolFaultStudents extends Component
{
    public $selectedStudents = [];
    public $class_id;
    public function mount($class_id)
    {
        $this->class_id = $class_id;
    }
    public function render()
    {
        return view('livewire.faults.school-fault-students');
    }
    #[On('updateStudent')]
    public function addStudents($student_id)
    {
        $students = Peoples::find($student_id);
        $this->selectedStudents[] = [
            'id' => $students->id,
            'code_image' => $students->code_image,
            'number' => $students->number,
            'nick' => $students->nick,
            'sex' => $students->sex,
            'class' => ($students->al_Class ? $students->al_Class->title : ''),
        ];

        // Disparar evento com a lista atualizada
        $this->dispatch('updateStudents', $this->selectedStudents);
    }

    public function removeStudents($value)
    {
        if (isset($this->selectedStudents[$value])) {
            unset($this->selectedStudents[$value]);
            $this->selectedStudents = array_values($this->selectedStudents); // Reindexa o array
        }

        // Disparar evento com a lista atualizada
        $this->dispatch('updateStudents', $this->selectedStudents);
    }
}
