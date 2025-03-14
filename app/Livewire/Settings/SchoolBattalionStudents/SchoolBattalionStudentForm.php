<?php

namespace App\Livewire\Settings\SchoolBattalionStudents;

use App\Models\Peoples;
use App\Models\Settings\SchoolBattalionStudents;
use Livewire\Component;

use Livewire\Attributes\On;

class SchoolBattalionStudentForm extends Component
{
    public $rules;

    public $route = 'school-battalion-students-grade';

    public $breadcrumb = 'Ano ';
    //Fields
    public $id;
    public $posto_grad;
    public $people_id;
    public $year;


    public $people;
    public $school_grades;

    public function mount(SchoolBattalionStudents $school_battalion_student)
    {
        if ($school_battalion_student->getAttributes()) {
            $this->id           = $school_battalion_student->id;
            $this->people_id    = $school_battalion_student->people_id;
            $this->posto_grad   = $school_battalion_student->posto_grad;
            $this->breadcrumb   .= $school_battalion_student->grade->name;
            $this->school_grades = $school_battalion_student->grade->id;
        }
    }
    #[On('updatePeople')]
    public function updatePeople($id)
    {
        $this->people_id = $id;
        $this->people = Peoples::find($id)->name;
    }

    public function render()
    {
        return view('livewire.settings.school-battalion-students.school-battalion-student-form');
    }

    public function save()
    {
        $id = $this->real_save();
        if ($id) {
            redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        }
    }
    public function save_out()
    {
        $this->real_save();
        $this->dispatch('closeModal');
        $this->dispatch('updateItens', 'success', 'Registro editado com sucesso.');
        // redirect()->route('school-classes-years-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'posto_grad' => 'required',
        ];
        $this->validate();
        SchoolBattalionStudents::updateOrCreate([
            'id'    => $this->id,
        ], [
            'posto_grad' => $this->posto_grad,
            'people_id'  => $this->people_id,
        ]);

        $id = false;
        $msg = 'Registro editado com sucesso.';

        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
