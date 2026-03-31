<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use App\Models\Discipline\FaultDiscipline;
use App\Models\Peoples;
use Livewire\Component;
use App\Enums\MilitaryRank;

use Livewire\Attributes\On;

use App\Enums\Penalty;
use App\Models\Discipline\FactObserved;
use App\Models\Discipline\Settings\Faults;
use App\Models\Settings\SchoolClassesYears;

class FaultDisciplineEdit extends Component
{
    public $rules;

    public $back = 'fault-discipline-list';
    public $route = 'fault-discipline';

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
    public $al_sex;
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

    public $delivered_date;
    public $justification_date;
    public $repeat;
    public $repeat_number;
    public $solution;
    public $solution_date;
    public $decision;
    public $dacision_days = 0.0;
    public $first = 0.0;
    public $grau;

    public $sim_date;
    public $sincomil_date;
    public $bi_text;
    public $bi_number;
    public $supplement_number;
    public $b_date;
    public $bi_date;
    public $s_date;

    public $mitigating;
    public $aggravating;
    public $faults;

    public $students;

    public $sugestion;
    public $days;
    public $f_date;


    public $old_faults;
    public $relatedFaults;
    public $student_grau;

    public $note;

    public function mount(FaultDiscipline $fault_discipline)
    {
        $year = now()->year;
        $year = SchoolClassesYears::where("active", 1)->first()->year;
        if ($fault_discipline->getAttributes()) {
            $this->student_grau = $fault_discipline->students->adjusted_grau;
            $this->note = $fault_discipline->note;

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
            $this->al_name                  = $fault_discipline->al_name;
            $this->al_sex                   = $fault_discipline->students->sex;
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
            $this->delivered_date           = $fault_discipline->delivered_date;
            $this->justification_date       = $fault_discipline->justification_date;

            $this->decision                 = $fault_discipline->decision;
            $this->dacision_days            = $fault_discipline->dacision_days;
            $this->first                    = $fault_discipline->first;
            $this->repeat                   = $fault_discipline->repeat;
            $this->repeat_number            = $fault_discipline->repeat_number;
            $this->solution                 = $fault_discipline->solution;
            $this->solution_date            = $fault_discipline->solution_date;
            $this->grau                     = $fault_discipline->grau * $fault_discipline->dacision_days;

            $this->mitigating         = $fault_discipline->json_mitigating;
            $this->aggravating        = $fault_discipline->json_aggravating;
            $this->faults             = $fault_discipline->json_faults;

            $this->f_date           = $fault_discipline->f_date;

            $this->sim_date         = $fault_discipline->sim_date;
            $this->sincomil_date    = $fault_discipline->sincomil_date;
            $this->bi_text          = $fault_discipline->bi_text;
            $this->bi_number        = $fault_discipline->bi_number;
            $this->supplement_number = $fault_discipline->supplement_number;

            $this->b_date           = $fault_discipline->b_date;
            $this->bi_date          = $fault_discipline->bi_date;
            $this->s_date           = $fault_discipline->s_date;

            if ($this->decision) {
                $this->days = Penalty::from($this->decision)->days();
                $this->grau = $fault_discipline->grau ?? Penalty::from($this->decision)->degree();
            }

            if ($this->solution) {
                $this->sugestion = $fault_discipline->solution;
            }
            $this->breadcrumb = 'Faltas disciplinar nº ' . $this->number . '/' . $this->year;

            $this->old_faults = FaultDiscipline::where('id', '!=', $fault_discipline->id)->where('al_number', $this?->students?->number)->get();


            // Array de faltas da linha atual
            $faultsArray = json_decode($fault_discipline->faults);

            // Busca outras linhas do mesmo aluno
            $this->relatedFaults = FaultDiscipline::where('student_id', $fault_discipline->student_id)
                ->where('id', '!=', $fault_discipline->id)
                ->whereYear('fact_date', $year)
                ->get()
                ->flatMap(function ($row) {
                    $decoded = json_decode($row->faults);
                    return is_array($decoded) ? $decoded : [];
                })
                ->filter(function ($fault) use ($faultsArray) {
                    return is_array($faultsArray) && in_array($fault, $faultsArray);
                })
                ->unique()
                ->values()
                ->all();
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
            'delivered_date'           => $this->delivered_date,
            'justification_date'       => $this->justification_date,
            'aggravating'              => $this->aggravating,
            'mitigating'               => $this->mitigating,
            'repeat'                   => $this->repeat,
            'repeat_number'            => $this->repeat_number,
            'solution'                 => $this->solution,
            'solution_date'            => $this->solution_date,
            'decision'                 => $this->decision,
            'dacision_days'            => $this->dacision_days,
            'first'                    => $this->first,
            'grau'                     => Penalty::from($this->decision)->degree(),
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
        if ($property === 'decision') {
            $this->days = Penalty::from($this->decision)->days();
            if ($this->days == 0.0) {
                $this->grau = Penalty::from($this->decision)->degree();
                $this->dacision_days = 0.0;
            } else {
                $this->grau = Penalty::from($this->decision)->degree() * floatval($this->dacision_days);
            }
        }
        if ($property === 'dacision_days') {
            if ($this->dacision_days > 0 and $this->dacision_days) {
                if ($this->decision == 'retirada_cm') {
                    $this->grau = Penalty::from($this->decision)->degree() * floatval($this->dacision_days);
                } else {
                    $this->grau = Penalty::from($this->decision)->degree();
                }
            } else {

                $this->grau = Penalty::from($this->decision)->degree();
            }
        }
    }
    public function sugestionText()
    {
        $gender = ($this->students->sex == 'F' ? 'a' : 'o');
        $this->sugestion = 'Diante do exposto, ' . $gender . ' alun' . $gender . ' em tela incidiu em falta disciplinar por, ';
        foreach ($this->faults as $key => $value) {
            $this->sugestion .= strtolower(Faults::find($value)->title) . ' ';
        }
        $this->sugestion .= 'Na ocasião ' . $this->fact;

        // $this->sugestion .= ' não sendo reincidente em falta desta natureza, de acordo com o Regimento Interno dos Colégios Militares (RICM)';

        $this->solution = $this->sugestion;
    }
    public function modalJustify()
    {
        $this->seeModalJustify = true;
    }
    public function justify()
    {
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
            'delivered_date'           => $this->delivered_date,
            'justification_date'       => $this->justification_date,
            'aggravating'              => $this->aggravating,
            'mitigating'               => $this->mitigating,
            'repeat'                   => $this->repeat,
            'repeat_number'            => $this->repeat_number,
            'solution'                 => 'O fato foi considerado justificado e o FO foi removido',
            'solution_date'            => date('d/m/Y'),
            'decision'                 => 'justificado',
            'dacision_days'            => 0,
            'grau'                     => 0.0,
            'bi_text'                  => 'O fato foi considerado justificado e o FO foi removido',

        ]);

        $data = FactObserved::where('fafd_id', $this->id)->first();
        $data->active = 0;
        $data->save();


        $msg = 'O fato foi considerado justificado e o FO foi removido com sucesso.';

        redirect()->route($this->route . '-list')->with('success', $msg);
    }
}
