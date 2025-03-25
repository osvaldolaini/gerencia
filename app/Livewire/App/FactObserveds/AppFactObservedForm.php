<?php

namespace App\Livewire\App\FactObserveds;

use App\Enums\Penalty;
use App\Models\Discipline\FactObserved;
use App\Models\Discipline\Settings\Faults;
use App\Models\Peoples;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Enums\MilitaryRank;
use App\Enums\FunctionsObserver;


use Livewire\Attributes\On;

use Illuminate\Support\Str;
use Livewire\Component;

class AppFactObservedForm extends Component
{

    public $rules;
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
    public $fact;
    public $fact_hour;
    public $fact_date;
    public $fact_type;
    public $fact_observer;
    public $fact_observer_function;
    public $fact_observer_id;
    public $student;

    public $faults;
    public $students;

    public function render()
    {
        return view('livewire.app.fact-observeds.app-fact-observed-form');
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

    public function save()
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

        $this->validate();
        $user = Auth::user();
        foreach ($this->students as $key => $value) {
            $this->student_id       = $value['id'];
            $people                 = Peoples::find($this->student_id);
            $this->al_nick          = $people->nick;
            $this->al_name          = $people->name;
            $this->al_number        = $people->number;
            $this->al_class         = $people->al_class->title;
            $this->cia              = $people->al_class->classGrade->company->name;
            $this->company_id       = $people->al_class->classGrade->company->id;

            $fo = FactObserved::create([
                'active'    => 1,
                'cia'                      => $this->cia,
                'company_id'               => $this->company_id,
                'cmt_cia'                  => $this->cmt_cia,
                'student_id'               => $this->student_id,
                'al_nick'                  => $this->al_nick,
                'al_number'                => $this->al_number,
                'al_class'                 => $this->al_class,
                'fact'                     => $this->fact,
                'fact_hour'                => $this->fact_hour,
                'fact_date'                => $this->fact_date,
                'fact_type'                => $this->fact_type,
                'faults'                   => $this->faults,
                'fact_observer'            => MilitaryRank::from($user->people->posto_grad)->label . ' ' . $user->people->nick,
                'fact_observer_function'   => FunctionsObserver::from($user->people->function)->label,
                'fact_observer_id'         => $user->people->id,
                'code'      => Str::uuid(),
            ]);
            $id = $fo->id;

            $msg = 'Registro criado com sucesso.';
        }


        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
