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

class AppFactObservedNegative extends Component
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
    public $school_classes_id;
    public $fact;
    public $fact_hour;
    public $fact_date;
    public $fact_type;
    public $fact_observer;
    public $fact_observer_function;
    public $fact_observer_id;

    public $faults;
    public $students;

    public function mount()
    {
        $user = Auth::user();
        if ($user->people) {
            $this->fact_observer = MilitaryRank::from($user->people->posto_grad)->label() . ' ' . $user->people->nick;
            $this->fact_observer_function = $user->people->function;
            $this->fact_observer_id = $user->people->id;
        }
    }


    public function render()
    {
        return view('livewire.app.fact-observeds.app-fact-observed-negative');
    }
    #[On('updateFaults')]
    public function updateFaults($faults)
    {
        $this->faults = $faults;
    }

    #[On('foUpdateStudents')]
    public function updateStudents($students)
    {
        $this->students = $students;
        // dd($this->students);
    }


    public function save()
    {
        $this->rules = [
            'fact'                     => 'required',
            'fact_hour'                => 'required',
            'fact_date'                => 'required',
            // 'faults'                   => 'required'
        ];
        // dd($this->validate());

        $this->validate();

        if ($this->faults == '') {
            // dd($this->faults);
            $this->dispatch('openAlert', 'error', 'Selecione uma falta disciplinar');
        } else {
            $user = Auth::user();
            foreach ($this->students as $key => $value) {
                $this->student_id       = $value['id'];
                $people                 = Peoples::find($this->student_id);

                $this->al_nick          = $people->nick;
                $this->al_name          = $people->name;
                $this->al_number        = $people->number;
                $this->al_class         = $people->al_class->title;
                $this->school_classes_id = $people->al_class->id;
                $this->cmt_cia_posto    = MilitaryRank::from(intval($people->al_class->classGrade->company->comandant->posto_grad))->label();
                $this->cmt_cia          = $people->al_class->classGrade->company->comandant->name;
                $this->cia              = $people->al_class->classGrade->company->name;
                $this->company_id       = $people->al_class->classGrade->company->id;

                // dd($people->al_class->classGrade->company->comandant->posto_grad);
                $fo = FactObserved::create([
                    'active'    => 1,
                    'cia'                      => $this->cia,
                    'company_id'               => $this->company_id,
                    'cmt_cia_posto'            => $this->cmt_cia_posto,
                    'cmt_cia'                  => $this->cmt_cia,
                    'student_id'               => $this->student_id,
                    'al_nick'                  => $this->al_nick,
                    'al_name'                  => $this->al_name,
                    'al_number'                => $this->al_number,
                    'al_class'                 => $this->al_class,
                    'school_classes_id'        => $this->school_classes_id,
                    'fact'                     => $this->fact,
                    'fact_hour'                => $this->fact_hour,
                    'fact_date'                => $this->fact_date,
                    'fact_type'                => 'negativo',
                    'faults'                   => $this->faults,
                    'fact_observer'            => $this->fact_observer,
                    'fact_observer_function'   => $this->fact_observer_function,
                    'fact_observer_id'         => $this->fact_observer_id,
                    'code'      => Str::uuid(),
                ]);
                $id = $fo->id;

                $msg = 'FO- criado com sucesso.';
            }
            return redirect('aplicativo')->with('success', $msg);
        }
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }

    #[On('resetAll')]
    public function resetAll()
    {
        $this->reset(['fact', 'fact_date', 'fact_hour']);
    }
}
