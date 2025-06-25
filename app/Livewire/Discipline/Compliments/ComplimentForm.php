<?php

namespace App\Livewire\Discipline\Compliments;

use App\Enums\MilitaryRank;
use App\Models\Discipline\Compliments;
use App\Models\Peoples;
use App\Models\Settings\Companies;
use Livewire\Component;

use Livewire\Attributes\On;
use Illuminate\Support\Str;

class ComplimentForm extends Component
{
    public $rules;

    public $back = 'compliment-list';
    public $route = 'compliment';

    public $breadcrumb = 'Elogios';
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
    public $fact_type = 'positivo';
    public $fact_observer;
    public $fact_observer_function;
    public $fact_observer_id;

    public function mount()
    {
        $this->fact_date = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.discipline.compliments.compliment-form');
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
    }

    public function save_out()
    {
        $id = $this->real_save();
    }

    public function real_save()
    {
        $this->rules = [
            'al_nick'   => 'required',
            'al_class'  => 'required',
            'cia'       => 'required',
        ];
        $this->validate();

        $comandant = Companies::find($this->company_id)->comandant;

        $compliment = Compliments::create([
            'active'                   => 1,
            'cia'                      => $this->cia,
            'company_id'               => $this->company_id,
            'cmt_cia'                  => $comandant->cmt_cia ?? '',
            'cmt_cia_posto'            => MilitaryRank::fromDb($comandant->posto_grad)?->label() ?? '',
            'student_id'               => $this->student_id,
            'al_nick'                  => $this->al_nick,
            'al_name'                  => $this->al_name,
            'al_number'                => $this->al_number,
            'al_class'                 => $this->al_class,
            'fact'                     => $this->fact,
            'fact_hour'                => $this->fact_hour,
            'fact_date'                => $this->fact_date,
            'fact_type'                => $this->fact_type,
            'code'                     => Str::uuid(),
        ]);
        $id = $compliment->id;
        $msg = 'Registro criado com sucesso.';
        $this->dispatch('modalClose');
        $this->openAlert('success', $msg);
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
