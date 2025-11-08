<?php

namespace App\Livewire\Faults;

use App\Models\Fault\SecondCall;
use Livewire\Component;

class SecondChanceForm extends Component
{
    public $id;
    public $number;
    public $discipline;

    public function mount(SecondCall $second_call)
    {
        if ($second_call->getAttributes()) {
            $this->id            = $second_call->id;
            $this->number        = $second_call->number;
            $this->discipline    = $second_call->discipline;
        }
    }

    public function render()
    {
        return view('livewire.faults.second-chance-form');
    }

    public function updatedNumber()
    {
        SecondCall::updateOrCreate([
            'id'            => $this->id,
        ], [
            'number'            => $this->number,
        ]);
    }
    public function updatedDiscipline()
    {
        SecondCall::updateOrCreate([
            'id'    => $this->id,
        ], [
            'discipline'            => $this->discipline,
        ]);
    }
}
