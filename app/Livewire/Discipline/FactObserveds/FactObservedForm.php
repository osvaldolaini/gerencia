<?php

namespace App\Livewire\Discipline\FactObserveds;

use App\Models\Peoples;
use Livewire\Component;
use App\Enums\MilitaryRank;

use Livewire\Attributes\On;
use App\Models\Discipline\FactObserved;
use App\Models\Settings\Companies;
use Illuminate\Support\Str;

class FactObservedForm extends Component
{
    public $rules;

    public $back = 'fact-observed-list';
    public $route = 'fact-observed';

    public $breadcrumb = 'Fato observado';
    //Fields
    public $id;
    public $number;
    public $year;
    public $cia;
    public $company_id;
    public $cmt_cia;
    public $cmt_cia_posto;
    public $people_id;
    public $al_number;
    public $al_nick;
    public $al_name;
    public $student_id;
    public $al_class;
    public $school_classes_id;
    public $fact;
    public $fact_hour;
    public $fact_date;
    public $fact_type;
    public $fact_observer;
    public $fact_observer_function;
    public $fact_observer_id;
    public $student;

    public $repeat;
    public $repeat_number;

    public $sim_date;
    public $sincomil_date;

    public $faults;

    public $students;

    public $f_date;


    public function render()
    {
        return view('livewire.discipline.fact-observeds.fact-observed-form');
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

    #[On('updatePeople')]
    public function updatePeople($id)
    {
        $this->fact_observer_id = $id;
        $people                 = Peoples::find($id);
        $this->fact_observer    = (MilitaryRank::fromDb($people->posto_grad)?->nick() ?? '') . ' ' . $people->nick;
        $this->fact_observer_function    = $people->function;
    }

    #[On('updateFaults')]
    public function updateFaults($faults)
    {
        $this->faults = $faults;
    }
    #[On('updateStudents')]
    public function updateStudents($students)
    {
        $this->students = $students;
    }

    public function real_save()
    {
        $this->rules = [
            'fact'                     => 'required',
            'fact_hour'                => 'required',
            'fact_date'                => 'required',
            'fact_type'                => 'required',
            'fact_observer'            => 'required',
            'fact_observer_function'   => 'required',
        ];
        if ($this->fact_type == 'negativo') {
            $this->rules['faults'] = 'required';
        }


        $this->validate();

        foreach ($this->students as $key => $value) {
            $this->student_id       = $value['id'];
            $people                 = Peoples::find($this->student_id);
            $this->al_nick          = $people->nick;
            $this->al_name          = $people->name;
            $this->al_number        = $people->number;
            $this->al_class         = $people->al_class->title;
            $this->school_classes_id = $people->al_class->id;
            $this->cia              = $people->al_class->classGrade->company->name;
            $this->company_id       = $people->al_class->classGrade->company->id;

            $comandant = Companies::find($this->company_id)->comandant;

            $fo = FactObserved::firstOrCreate(
                [
                    'student_id' => $this->student_id,
                    'fact_date'  => $this->fact_date,
                    'fact'       => $this->fact,
                ],
                [
                    'active' => 1,
                    'cia' => $this->cia,
                    'company_id' => $this->company_id,
                    'cmt_cia' => $comandant->name ?? '',
                    'cmt_cia_posto' => MilitaryRank::fromDb($comandant->posto_grad)?->label() ?? '',
                    'al_nick' => $this->al_nick,
                    'al_name' => $this->al_name,
                    'al_number' => $this->al_number,
                    'al_class' => $this->al_class,
                    'school_classes_id' => $this->school_classes_id,
                    'fact_hour' => $this->fact_hour,
                    'fact_type' => $this->fact_type,
                    'faults' => $this->faults === '' ? null : $this->faults,
                    'fact_observer' => $this->fact_observer,
                    'fact_observer_function' => $this->fact_observer_function,
                    'fact_observer_id' => $this->fact_observer_id,
                    'code' => Str::uuid(),
                ]
            );

            $id = $fo->id;

            $msg = 'Registro criado com sucesso.';
        }

        logger('Executando método salvar');
        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
