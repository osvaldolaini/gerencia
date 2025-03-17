<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use App\Models\Discipline\FaultDiscipline;
use App\Models\Peoples;
use Livewire\Component;
use App\Enums\MilitaryRank;

use Livewire\Attributes\On;

class FaultDisciplineEdit extends Component
{
    public $rules;

    public $back = 'fault-discipline-list';
    public $route = 'fault-discipline';

    public $breadcrumb;
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

    public $mitigating;
    public $aggravating;
    public $faults;

    public $students;

    public function mount(FaultDiscipline $fault_discipline)
    {
        if ($fault_discipline->getAttributes()) {
            $this->students                 = $fault_discipline->students;
            $this->id                       = $fault_discipline->id;
            $this->number                   = $fault_discipline->number;
            $this->year                     = $fault_discipline->year;
            $this->cia                      = $fault_discipline->cia;
            $this->company_id               = $fault_discipline->company_id;
            $this->cmt_cia                  = $fault_discipline->cmt_cia;
            $this->cmt_cia_posto            = $fault_discipline->cmt_cia_posto;
            $this->people_id                = $fault_discipline->people_id;
            $this->al_number                = $fault_discipline->al_number;
            $this->al_nick                  = $fault_discipline->al_nick;
            $this->student_id               = $fault_discipline->student_id;
            $this->al_class                 = $fault_discipline->al_class;
            $this->school_classes_id        = $fault_discipline->school_classes_id;
            $this->fact                     = $fault_discipline->fact;
            $this->fact_hour                = $fault_discipline->fact_hour;
            $this->fact_date                = $fault_discipline->fact_date;
            $this->fact_type                = $fault_discipline->fact_type;
            $this->fact_observer            = $fault_discipline->fact_observer;
            $this->fact_observer_function   = $fault_discipline->fact_observer_function;
            $this->fact_observer_id         = $fault_discipline->fact_observer_id;


            $this->mitigating         = $fault_discipline->json_mitigating;
            $this->aggravating        = $fault_discipline->json_aggravating;
            $this->faults             = $fault_discipline->json_faults;

            $this->breadcrumb = 'Faltas disciplinar nº ' . $this->number . '/' . $this->year;
        }
    }

    public function render()
    {
        return view('livewire.discipline.fault-disciplines.fault-discipline-edit');
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
    #[On('updateAggravating')]
    public function updateAggravating($aggravating)
    {
        $this->aggravating = $aggravating;
    }
    #[On('updateMitigating')]
    public function updatemitigating($mitigating)
    {
        $this->mitigating = $mitigating;
    }

    public function real_save()
    {
        $this->rules = [
            'fact'                     => 'required',
            'fact_hour'                => 'required',
            'fact_date'                => 'required',
            'fact_type'                => 'required',
            'faults'                   => 'required',
            'fact_observer'            => 'required',
            'fact_observer_function'   => 'required',
        ];
        // dd($this->mitigating);
        $this->validate();
        FaultDiscipline::updateOrCreate([
            'id'    => $this->id,
        ], [
            'fact'                     => $this->fact,
            'fact_hour'                => $this->fact_hour,
            'fact_date'                => $this->fact_date,
            'fact_type'                => $this->fact_type,
            'faults'                   => $this->faults,
            'fact_observer'            => $this->fact_observer,
            'fact_observer_function'   => $this->fact_observer_function,
            'fact_observer_id'         => $this->fact_observer_id,
            'aggravating'              => $this->aggravating,
            'mitigating'               => $this->mitigating,
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
