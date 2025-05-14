<?php

namespace App\Livewire\Discipline\FactObserveds;

use App\Models\Discipline\FactObserved;
use App\Models\Peoples;
use Livewire\Component;
use App\Enums\MilitaryRank;

use Livewire\Attributes\On;

use App\Enums\Penalty;
use App\Models\Discipline\Settings\Faults;

class FactObservedEdit extends Component
{
    public $rules;

    public $back = 'fact-observed-list';
    public $route = 'fact-observed';

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
    public $fafd;

    public $sim_date;
    public $sincomil_date;

    public $faults;

    public $students;

    public $f_date;

    public function mount(FactObserved $fact_observed)
    {
        if ($fact_observed->getAttributes()) {

            $this->students                 = $fact_observed->students;
            $this->id                       = $fact_observed->id;
            $this->number                   = $fact_observed->number;
            $this->year                     = $fact_observed->year;
            $this->cia                      = $fact_observed->cia;
            $this->company_id               = $fact_observed->company_id;
            $this->cmt_cia                  = $fact_observed?->company?->comandant?->name ?? '';
            $this->cmt_cia_posto            = MilitaryRank::fromDb($fact_observed?->company?->comandant?->posto_grad)?->label() ?? '';
            $this->people_id                = $fact_observed->people_id;
            $this->al_number                = $fact_observed->al_number;
            $this->al_nick                  = $fact_observed->al_nick;
            $this->al_name                  = $fact_observed->al_name;
            $this->student_id               = $fact_observed->student_id;
            $this->al_class                 = $fact_observed->al_class;
            $this->school_classes_id        = $fact_observed->school_classes_id;
            $this->fact                     = $fact_observed->fact;
            $this->fact_hour                = $fact_observed->fact_hour;
            $this->fact_date                = $fact_observed->fact_date;
            $this->fact_type                = $fact_observed->fact_type;
            $this->fact_observer            = $fact_observed->fact_observer;
            $this->fact_observer_function   = $fact_observed->fact_observer_function;
            $this->fact_observer_id         = $fact_observed->fact_observer_id;
            $this->fafd                 = $fact_observed->fafd;

            $this->faults             = $fact_observed->json_faults;

            $this->f_date           = $fact_observed->f_date;

            $this->sim_date         = $fact_observed->sim_date;
            $this->sincomil_date    = $fact_observed->sincomil_date;


            $this->breadcrumb = 'Fato observado nº ' . $this->number . '/' . $this->year;
        }
    }


    public function render()
    {
        return view('livewire.discipline.fact-observeds.fact-observed-edit');
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

    public function real_save()
    {
        $this->rules = [
            'fact'                     => 'required',
            'fact_hour'                => 'required',
            'fact_date'                => 'required',
            'fact_type'                => 'required',
            // 'faults'                   => 'required',
            'fact_observer'            => 'required',
            'fact_observer_function'   => 'required',
        ];

        if ($this->fact_type == 'positivo') {
            $this->faults = NULL;
        }

        $this->validate();
        $fact = FactObserved::updateOrCreate([
            'id'    => $this->id,
        ], [
            'student_id'               => $this->student_id,
            'al_nick'                  => $this->al_nick,
            'al_name'                  => $this->al_name,
            'al_number'                => $this->al_number,
            'al_class'                 => $this->al_class,
            'fact'                     => $this->fact,
            'fact_hour'                => $this->fact_hour,
            'fact_date'                => $this->fact_date,
            // 'faults'                   => $this->faults,
            'fact_observer'            => $this->fact_observer,
            'fact_observer_function'   => $this->fact_observer_function,
            'fact_observer_id'         => $this->fact_observer_id,
            'fafd'                     => $this->fafd,
            'sincomil_date'            => $this->sincomil_date,
        ]);

        if ($this->fact_type == 'negativo') {
            $fact->faults = $this->faults;
            $fact->save();
        }

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
