<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use App\Models\Discipline\FaultDiscipline;
use App\Models\Peoples;
use Livewire\Component;

use Livewire\Attributes\On;
use Illuminate\Support\Str;

class FaultDisciplineForm extends Component
{
    public $rules;

    public $back = 'fault-discipline-list';
    public $route = 'fault-discipline';

    public $breadcrumb = 'Faltas disciplinar';
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
    public $faults;
    public $fact_observer;
    public $fact_observer_function;
    public $fact_observer_id;

    public function mount()
    {
        $this->fact_date = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.discipline.fault-disciplines.fault-discipline-form');
    }

    #[On('updatePeople')]
    public function updatePeople($id)
    {
        $this->student_id       = $id;
        $people                 = Peoples::find($id);
        $this->al_nick          = $people->nick;
        $this->al_name          = $people->name;
        $this->al_number        = $people->number;
        $this->al_class         = $people->al_class->title;
        $this->cia              = $people->al_class->classGrade->company->name;
        $this->company_id       = $people->al_class->classGrade->company->id;
        // $this->cmt_cia_posto    = $people->al_class->classGrade->company->id;
    }

    public function save()
    {
        $id = $this->real_save();
        // if ($id) {
        //     redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        // }
    }
    public function save_out()
    {
        $id = $this->real_save();
        // if ($id) {
        //     redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        // }
    }

    public function real_save()
    {
        $this->rules = [
            // 'number'                   => 'required',
            // 'year'                     => 'required',
            'al_nick'               => 'required',
            'al_class'                     => 'required',
            'cia'                => 'required',
            'fact_date'                => 'required',
            'fact_type'                => 'required',
        ];
        $this->validate();

        $fault_discipline = FaultDiscipline::create([
            'active'                   => 1,
            // 'number'                   => $this->number,
            // 'year'                     => $this->year,
            'cia'                      => $this->cia,
            'company_id'               => $this->company_id,
            'cmt_cia'                  => $this->cmt_cia,
            // 'cmt_cia_posto'            => $this->cmt_cia_posto,
            'student_id'               => $this->student_id,
            'al_nick'                  => $this->al_nick,
            'al_number'                => $this->al_number,
            'al_class'                 => $this->al_class,
            // 'fact'                     => $this->fact,
            // 'fact_hour'                => $this->fact_hour,
            // 'fact_date'                => $this->fact_date,
            'fact_type'                => $this->fact_type,
            // 'faults'                   => $this->faults,
            // 'fact_observer_function'   => $this->fact_observer_function,
            // 'fact_observer_id'         => $this->fact_observer_id,
            'code'                     => Str::uuid(),
        ]);
        $id = $fault_discipline->id;
        $msg = 'Registro criado com sucesso.';


        $this->openAlert('success', $msg);
        $this->dispatch('modelClose');
        // return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
