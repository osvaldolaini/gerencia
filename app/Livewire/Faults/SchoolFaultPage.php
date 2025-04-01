<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SchoolFaults;
use Livewire\Component;

class SchoolFaultPage extends Component
{
    public $school_faults;
    public function mount(SchoolFaults $school_faults)
    {
        if ($school_faults) {
            $this->school_faults = $school_faults;
        }
    }
    public function render()
    {
        return view('livewire.faults.school-fault-page');
    }
}
