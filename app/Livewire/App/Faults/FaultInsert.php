<?php

namespace App\Livewire\App\Faults;

use App\Models\Fault\SchoolFaults;
use App\Models\Peoples;
use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;

class FaultInsert extends Component

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


    public function mount()
    {
        $companiesAccess = Auth::user()->json_companies;
        if (in_array('all', $companiesAccess)) {
            $this->companies = Companies::where('active', 1)->get();
        } else {
            $this->companies = Companies::where('active', 1)->whereIn('id', Auth::user()->json_companies)->get();
        }
    }
    public function render()
    {
        return view('livewire.app.faults.fault-insert');
    }
    #[On('updateStudent')]
    public function updateStudent($id)
    {
        $this->student_id = $id;
        $this->people = Peoples::find($id)->name;
    }
    public function updated($property)
    {
        if ($property === 'companies_id') {
            $this->grades = Companies::find($this->companies_id)->grade->sortBy('nick');
            $this->students = [];
            $this->dispatch('removeAll');
        }
        if ($property === 'school_grades_id') {
            $this->classes = SchoolGrades::find($this->school_grades_id)->getClasses->sortBy('order');
            $this->students = [];
            $this->dispatch('removeAll');
        }
        if ($property === 'school_classes_id') {
            $this->school_classes_year_id = SchoolClassesYears::where('active', 1)->first()->id;
            $this->dispatch('removeAll');
        }
    }
    #[On('updateStudents')]
    public function updateStudents($students)
    {
        $this->students = $students;
    }

    public function save()
    {
        $this->rules = [
            'date'                      => 'required',
            'qtd'                       => 'required',
            'companies_id'              => 'required',
            'school_grades_id'          => 'required',
            'school_classes_id'         => 'required',
        ];

        $this->validate();

        foreach ($this->students as $key => $value) {
            $this->student_id       = $value['id'];

            SchoolFaults::create([
                'active'                => 1,
                // 'name'                  => $this->name,
                'id'                    => $this->id,
                'student_id'            => $this->student_id,
                'date'                  => $this->date,
                'companies_id'          => $this->companies_id,
                'school_grades_id'      => $this->school_grades_id,
                'school_classes_id'     => $this->school_classes_id,
                'school_classes_year_id' => $this->school_classes_year_id,
                'qtd'                   => $this->qtd,
                'code'                  => Str::uuid(),
            ]);

            $msg = 'Falta registrada criado com sucesso.';
        }

        // $this->openAlert('success', $msg);

        return redirect('aplicativo')->with('success', $msg);
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
