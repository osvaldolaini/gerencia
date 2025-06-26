<?php

namespace App\Livewire\Discipline\Panel;

use App\Models\Discipline\FactObserved;
use App\Models\Discipline\FaultDiscipline;
use Livewire\Component;

class DisciplinePanelCard extends Component
{
    public $fo;
    public $fafd;
    public function render()
    {
        $this->fo = FactObserved::where("active", 1)->where('fact_date', 'LIKE', '%' . date('Y') . '%')->get();
        $this->fafd = FaultDiscipline::where('year', 'LIKE', '%' . date('Y') . '%')->get();
        return view('livewire.discipline.panel.discipline-panel-card');
    }
}
