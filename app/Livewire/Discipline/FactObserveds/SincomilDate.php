<?php

namespace App\Livewire\Discipline\FactObserveds;

use App\Models\Discipline\FactObserved;

use Livewire\Component;

class SincomilDate extends Component
{
    public $id;
    public $sim_date;
    public $sincomil_date;

    public function mount(FactObserved $fact_observed)
    {
        if ($fact_observed->getAttributes()) {
            $this->id                       = $fact_observed->id;
            $this->sim_date         = $fact_observed->sim_date;
            $this->sincomil_date    = $fact_observed->sincomil_date;
        }
    }

    public function render()
    {
        return view('livewire.discipline.fact-observeds.sincomil-date');
    }

    public function updatedSincomilDate($faults)
    {
        FactObserved::updateOrCreate([
            'id'    => $this->id,
        ], [
            'sincomil_date'            => $this->sincomil_date,
        ]);
    }
}
