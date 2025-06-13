<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use App\Models\Peoples;
use App\Models\Settings\Companies;
use App\Models\Settings\SchoolClassesYears;
use App\Models\Settings\SchoolGrades;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Str;

class SchoolFaultForm extends Component
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


    public function mount(SchoolFaults $school_faults)
    {
        $companiesAccess = Auth::user()->json_companies;
        if (in_array('all', $companiesAccess)) {
            $this->companies = Companies::where('active', 1)->get();
        } else {
            $this->companies = Companies::where('active', 1)->whereIn('id', Auth::user()->json_companies)->get();
        }

        if ($school_faults->getAttributes()) {
            $this->id                       = $school_faults->id;
            $this->student_id               = $school_faults->student_id;
            $this->date                     = $school_faults->date_view;
            $this->companies_id             = $school_faults->companies_id;
            $this->school_grades_id         = $school_faults->school_grades_id;
            $this->school_classes_id        = $school_faults->school_classes_id;
            $this->school_classes_year_id   = $school_faults->school_classes_year_id;
            $this->qtd                      = $school_faults->qtd;
        }
    }
    public function render()
    {
        return view('livewire.faults.school-fault-form');
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
        $id = $this->real_save();
        if ($id) {
            redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        }
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route($this->route . '-list')->with('success', 'Registro criado com sucesso.');
    }


    public function real_save()
    {
        $this->rules = [
            'date'                      => 'required',
            'qtd'                       => 'required',
            'companies_id'              => 'required',
            'school_grades_id'          => 'required',
            'school_classes_id'         => 'required',
        ];

        $this->validate();
        // dd($this->validate());

        if ($this->id) {
            SchoolFaults::updateOrCreate([
                // 'id'    => $this->id,
                'student_id'            => $this->student_id,
                'date'                  => $this->date,
            ], [
                // 'name'                  => $this->name,
                'id'                    => $this->id,
                'student_id'            => $this->student_id,
                'date'                  => $this->date,
                'companies_id'          => $this->companies_id,
                'school_grades_id'      => $this->school_grades_id,
                'school_classes_id'     => $this->school_classes_id,
                'school_classes_year_id' => $this->school_classes_year_id,
                'qtd'                   => $this->qtd,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            foreach ($this->students as $key => $value) {
                $this->student_id       = $value['id'];

                SchoolFaults::updateOrCreate([
                    // 'id'    => $this->id,
                    'student_id'            => $this->student_id,
                    'date'                  => $this->date,
                ], [
                    // 'name'                  => $this->name,
                    'active'                => 1,
                    'id'                    => $this->id,
                    'student_id'            => $this->student_id,
                    'date'                  => $this->date,
                    'companies_id'          => $this->companies_id,
                    'school_grades_id'      => $this->school_grades_id,
                    'school_classes_id'     => $this->school_classes_id,
                    'school_classes_year_id' => $this->school_classes_year_id,
                    'qtd'                   => $this->qtd,
                ]);

                // SchoolFaults::create([
                //     'active'                => 1,
                //     // 'name'                  => $this->name,
                //     'id'                    => $this->id,
                //     'student_id'            => $this->student_id,
                //     'date'                  => $this->date,
                //     'companies_id'          => $this->companies_id,
                //     'school_grades_id'      => $this->school_grades_id,
                //     'school_classes_id'     => $this->school_classes_id,
                //     'school_classes_year_id' => $this->school_classes_year_id,
                //     'qtd'                   => $this->qtd,
                //     'code'                  => Str::uuid(),
                // ]);

                $msg = 'Registro criado com sucesso.';
            }
        }

        $this->openAlert('success', $msg);
        // return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
