<?php

namespace App\Livewire\App\Faults;


use App\Models\Fault\SchoolFaults;
use App\Models\Peoples;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;

class FaultInsertSimple extends Component

{
    public $rules;

    public $back = 'school-faults-list';
    public $route = 'school-faults';

    public $breadcrumb = 'Faltas';
    //Fields
    public $id;
    public $student_id;
    public $date;
    public $companies_id;
    public $school_grades_id;
    public $school_classes_id;
    public $school_classes_year_id;
    public $qtd;

    public $people;

    public $companies;
    public $grades;
    public $classes;
    public $students;
    public $justified;
    public $text;

    public function render()
    {
        return view('livewire.app.faults.fault-insert-simple');
    }
    #[On('updateStudent')]
    public function updateStudent(Peoples $student)
    {
        $this->student_id = $student->id;
        $this->classes = $student->al_class;
        $this->grades = $this->classes->classGrade;
        $this->companies = $this->grades->company;
    }

    public function save()
    {
        $this->rules = [
            'date'                      => 'required',
            'qtd'                       => 'required',
        ];

        $this->validate();


        SchoolFaults::updateOrCreate([
            // 'id'    => $this->id,
            'student_id'            => $this->student_id,
            'date'                  => $this->date,
        ], [
            'active'                => 1,
            'id'                    => $this->id,
            'student_id'            => $this->student_id,
            'justified'             => $this->justified,
            'text'                  => $this->text,
            'date'                  => $this->date,
            'companies_id'          => $this->companies->id,
            'school_grades_id'      => $this->grades->id,
            'school_classes_id'     => $this->classes->id,
            'school_classes_year_id' => $this->classes->school_classes_year_id,
            'qtd'                   => $this->qtd,
            'code'                  => Str::uuid(),
        ]);
        // SchoolFaults::create([
        //     'active'                => 1,
        //     'id'                    => $this->id,
        //     'student_id'            => $this->student_id,
        //     'justified'             => $this->justified,
        //     'text'                  => $this->text,
        //     'date'                  => $this->date,
        //     'companies_id'          => $this->companies->id,
        //     'school_grades_id'      => $this->grades->id,
        //     'school_classes_id'     => $this->classes->id,
        //     'school_classes_year_id' => $this->classes->school_classes_year_id,
        //     'qtd'                   => $this->qtd,
        //     'code'                  => Str::uuid(),
        // ]);

        $msg = 'Falta registrada criado com sucesso.';

        // $this->openAlert('success', $msg);

        return redirect('aplicativo')->with('success', $msg);
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    #[On('resetAll')]
    public function resetAll()
    {
        $this->reset(['student_id', 'date', 'qtd', 'companies_id', 'school_grades_id', 'school_classes_id']);
    }
}
