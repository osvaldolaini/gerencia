<?php

namespace App\Livewire\Discipline\Compliments;

use App\Models\Peoples;
use Livewire\Component;
use App\Enums\MilitaryRank;

use Livewire\Attributes\On;

use App\Enums\ComplimentType;
use App\Models\Admin\Settings\Settings;
use App\Models\Discipline\Compliments;
use App\Models\Discipline\FactObserved;

class ComplimentEdit extends Component
{

    public $rules;

    public $back = 'compliment-list';
    public $route = 'compliment';

    public $seeModalJustify = false;

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

    public $compliment_type;
    public $solution_date;
    public $solution;

    public $grau;

    public $sim_date;
    public $sincomil_date;
    public $bi_text;
    public $bi_number;
    public $supplement_number;
    public $b_date;
    public $bi_date;
    public $s_date;

    public $students;

    public $sugestion;
    public $fo;
    public $f_date;


    public $old_faults;
    public $relatedFaults;

    public $note;

    public function mount(Compliments $compliments)
    {
        // dd($compliment);
        if ($compliments->getAttributes()) {
            $this->note = $compliments->note;

            $this->students                 = $compliments->students;
            $this->id                       = $compliments->id;
            $this->number                   = $compliments->number;
            $this->year                     = $compliments->year;
            $this->cia                      = $compliments->cia;
            $this->company_id               = $compliments->company_id;
            $this->cmt_cia                  = $compliments->cmt_cia;
            $this->cmt_cia_posto            = $compliments->cmt_cia_posto;
            $this->people_id                = $compliments->people_id;
            $this->al_number                = $compliments->al_number;
            $this->al_nick                  = $compliments->al_nick;
            $this->al_name                  = $compliments->al_name;
            $this->student_id               = $compliments->student_id;
            $this->al_class                 = $compliments->al_class;
            $this->school_classes_id        = $compliments->school_classes_id;
            $this->fact                     = $compliments->fact;
            $this->fact_hour                = $compliments->fact_hour;
            $this->fact_date                = $compliments->fact_date;
            $this->fact_type                = $compliments->fact_type;
            $this->fact_observer            = $compliments->fact_observer;
            $this->fact_observer_function   = $compliments->fact_observer_function;
            $this->fact_observer_id         = $compliments->fact_observer_id;

            $this->solution                 = $compliments->solution;
            $this->compliment_type           = $compliments->compliment_type;
            $this->solution_date            = $compliments->solution_date;
            $this->grau                     = $compliments->grau;
            $this->f_date           = $compliments->f_date;

            $this->sim_date         = $compliments->sim_date;
            $this->sincomil_date    = $compliments->sincomil_date;
            $this->bi_text          = $compliments->bi_text;
            $this->bi_number        = $compliments->bi_number;
            $this->supplement_number = $compliments->supplement_number;

            $this->b_date           = $compliments->b_date;
            $this->bi_date          = $compliments->bi_date;
            $this->s_date           = $compliments->s_date;
            $this->fo               = $compliments->fo;

            if ($this->compliment_type) {
                $this->grau = ComplimentType::from($this->compliment_type)->degree();
            }

            if ($this->solution) {
                $this->sugestion = $compliments->solution;
            }
            $this->breadcrumb = 'Elogio nº ' . $this->number . '/' . $this->year;
        }
    }

    public function render()
    {
        return view('livewire.discipline.compliments.compliment-edit');
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

        $this->validate();
        Compliments::updateOrCreate([
            'id'    => $this->id,
        ], [
            'fact'                     => $this->fact,
            'fact_hour'                => $this->fact_hour,
            'fact_date'                => $this->fact_date,
            'fact_type'                => $this->fact_type,
            'fact_observer'            => $this->fact_observer,
            'fact_observer_function'   => $this->fact_observer_function,
            'fact_observer_id'         => $this->fact_observer_id,

            'compliment_type'          => $this->compliment_type,
            'solution_date'            => $this->solution_date,
            'solution'                 => $this->solution,
            'grau'                     => $this->grau,
            'bi_date'                  => $this->bi_date,
            'bi_text'                  => $this->bi_text,
            'supplement_number'        => $this->supplement_number,
            'bi_number'                => $this->bi_number,
            'sincomil_date'            => $this->sincomil_date,
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
    //Decision
    public function updated($property)
    {
        if ($property === 'compliment_type') {
            $this->grau = ComplimentType::from($this->compliment_type)->degree();
        }
    }
    public function sugestionText()
    {
        if ($this->compliment_type) {
            $this->sugestion = 'Em ' . $this->f_date . ', Al Nr ' . $this->al_number . ', ' . $this->students->name . ', turma ' . $this->al_class . ' - ';
            $this->sugestion .= "Por " . $this->fact;
            $this->sugestion .= ' (FO positivo nº ' . $this->fo->number . '/' . $this->fo->year . ').';
            $this->sugestion .= ' Medida disciplinar: Elogio ' . ComplimentType::from($this->compliment_type)->label() . '.';

            $this->solution = $this->sugestion;
        }
    }
}
