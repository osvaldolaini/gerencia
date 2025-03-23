<?php

namespace App\Livewire\Discipline\FactObserveds;

use App\Models\Discipline\FactObserved;
use Livewire\Component;

class FactObservedLink extends Component
{
    public $next;
    public $previous;
    public function mount(FactObserved $fact_observed)
    {

        $this->next = FactObserved::where('active', 1)
            ->where('id', '>', $fact_observed->id)
            ->orderBy('id', 'asc')
            ->first();

        // Buscar o item anterior ativo com ID menor que o atual
        $this->previous = FactObserved::where('active', 1)
            ->where('id', '<', $fact_observed->id)
            ->orderBy('id', 'desc')
            ->first();
        // dd($this->previous, $this->next);
    }
    public function render()
    {
        return view('livewire.discipline.fact-observeds.fact-observed-link');
    }
}
