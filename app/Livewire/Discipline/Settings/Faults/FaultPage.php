<?php

namespace App\Livewire\Discipline\Settings\Faults;

use App\Models\Discipline\Settings\Faults;
use Livewire\Component;

class FaultPage extends Component
{
    public $faults;
    public function mount(Faults $faults)
    {
        if ($faults) {
            $this->faults = $faults;
        }
    }
    public function render()
    {
        return view('livewire.discipline.settings.faults.fault-page');
    }
}
