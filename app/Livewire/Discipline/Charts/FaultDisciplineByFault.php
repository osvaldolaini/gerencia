<?php

namespace App\Livewire\Discipline\Charts;

use App\Models\Discipline\FactObserved;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FaultDisciplineByFault extends Component
{
    public $labels = [];
    public $data = [];

    public function mount()
    {
        $this->getTopArticles();
    }

    private function getTopArticles()
    {
        $artigos = FactObserved::query()
            ->join('faults', 'faults.id', '=', 'fact_observeds.faults')
            ->where('fact_observeds.active', 1)
            ->whereNotNull('fact_observeds.faults')
            ->groupBy('faults.number')
            ->select('faults.number as artigo_numero', DB::raw('COUNT(*) as total'))
            ->orderBy('faults.number') // ordenar pelo número do artigo
            ->get();

        $this->labels = $artigos->pluck('artigo_numero')->map(fn($num) => 'Art. ' . $num)->toArray();
        $this->data = $artigos->pluck('total')->toArray();
    }

    public function render()
    {
        return view('livewire.discipline.charts.fault-discipline-by-fault');
    }
}
