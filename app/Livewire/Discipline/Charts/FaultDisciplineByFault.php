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
        $dados = FactObserved::query()
            ->where('active', 1)
            ->whereNotNull('faults')
            ->pluck('faults'); // pegamos apenas esse campo

        $contagem = [];

        foreach ($dados as $json) {
            $artigos = json_decode($json, true); // transforma em array PHP

            if (!is_array($artigos)) {
                continue; // ignora casos inválidos
            }

            foreach ($artigos as $art) {
                if ($art) {
                    $contagem[$art] = ($contagem[$art] ?? 0) + 1;
                }
            }
        }

        // Ordenar pelos números dos artigos
        ksort($contagem);

        $this->labels = array_map(fn($num) => 'Nº. ' . $num, array_keys($contagem));
        $this->data = array_values($contagem);
    }


    public function render()
    {
        return view('livewire.discipline.charts.fault-discipline-by-fault');
    }
}
