<?php

namespace App\Livewire\Discipline\FactObserveds;

use App\Models\Peoples;
use Livewire\Component;

use Livewire\Attributes\On;

class FactObservedStudents extends Component
{
    public $selectedStudents = [];
    public function render()
    {
        return view('livewire.discipline.fact-observeds.fact-observed-students');
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
