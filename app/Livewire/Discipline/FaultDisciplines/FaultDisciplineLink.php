<?php

namespace App\Livewire\Discipline\FaultDisciplines;

use App\Models\Discipline\FaultDiscipline;
use Livewire\Component;

class FaultDisciplineLink extends Component
{
    public $next;
    public $previous;
    public function mount(FaultDiscipline $fault_discipline)
    {

        $this->next = FaultDiscipline::where('active', 1)
            ->where('id', '>', $fault_discipline->id)
            ->orderBy('id', 'asc')
            ->first();

        // Buscar o item anterior ativo com ID menor que o atual
        $this->previous = FaultDiscipline::where('active', 1)
            ->where('id', '<', $fault_discipline->id)
            ->orderBy('id', 'desc')
            ->first();
        // dd($this->previous, $this->next);
    }
    public function render()
    {
        return view('livewire.discipline.fault-disciplines.fault-discipline-link');
    }
}
