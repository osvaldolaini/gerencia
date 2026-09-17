<?php

namespace App\Livewire\Discipline\Compliments;

use App\Models\Discipline\Compliments;
use Livewire\Component;

class SincomilDate extends Component
{
    public $id;
    public $sim_date;
    public $sincomil_date;

    public function mount(Compliments $compliment)
    {
        if ($compliment->getAttributes()) {
            $this->id               = $compliment->id;
            $this->sim_date         = $compliment->sim_date;
            $this->sincomil_date    = $compliment->sincomil_date;
        }
    }

    public function render()
    {
        return view('livewire.discipline.compliments.sincomil-date');
    }

    public function updatedSincomilDate($faults)
    {
        Compliments::updateOrCreate([
            'id'    => $this->id,
        ], [
            'sincomil_date'            => $this->sincomil_date,
        ]);
    }
}
