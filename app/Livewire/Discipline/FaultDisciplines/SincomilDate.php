<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use App\Models\Discipline\FaultDiscipline;

use Livewire\Component;

class SincomilDate extends Component
{
    public $id;
    public $sim_date;
    public $sincomil_date;

    public function mount(FaultDiscipline $fault_discipline)
    {
        if ($fault_discipline->getAttributes()) {
            $this->id               = $fault_discipline->id;
            $this->sim_date         = $fault_discipline->sim_date;
            $this->sincomil_date    = $fault_discipline->sincomil_date;
        }
    }

    public function render()
    {
        return view('livewire.discipline.fault-disciplines.sincomil-date');
    }

    public function updatedSincomilDate($faults)
    {
        FaultDiscipline::updateOrCreate([
            'id'    => $this->id,
        ], [
            'sincomil_date'            => $this->sincomil_date,
        ]);
    }
}
