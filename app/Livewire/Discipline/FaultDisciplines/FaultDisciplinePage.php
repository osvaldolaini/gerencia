<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use App\Models\Discipline\FaultDiscipline;
use Livewire\Component;

class FaultDisciplinePage extends Component
{
    public $fault_discipline;
    public function mount(FaultDiscipline $fault_discipline)
    {
        if ($fault_discipline) {
            $this->fault_discipline = $fault_discipline;
        }
    }
    public function render()
    {
        return view('livewire.discipline.fault-disciplines.fault-discipline-page');
    }
}
