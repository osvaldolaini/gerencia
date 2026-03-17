<?php

namespace App\Livewire\Discipline\FaultDisciplines\Settings;

use App\Models\Discipline\Settings\Faults;
use Livewire\Component;


class FaultsSelect extends Component
{
    public array $selectedFaults = [];
    public array $faultsOptions;
    public $fault;

    public function mount($faults)
    {
        if (!$faults) {
            $faults = [];
        }
        $allFaults = Faults::where('active', 1)->get(); // Obtém todos os registros ativos

        $this->faultsOptions = $allFaults
            ->reject(fn($case) => in_array($case->number, $faults)) // Remove os já selecionados
            ->mapWithKeys(fn($case) => [$case->number => $case->title]) // Usa 'number' como chave
            ->toArray();

        $this->selectedFaults = $allFaults
            ->filter(fn($case) => in_array($case->number, $faults))
            ->mapWithKeys(fn($case) => [$case->number => $case->title]) // Usa 'number' como chave
            ->toArray();

        ksort($this->selectedFaults); // Ordena os selecionados
    }

    public function addFaults($value)
    {
        if (isset($this->faultsOptions[$value])) {
            $this->selectedFaults[$value] = $this->faultsOptions[$value];
            unset($this->faultsOptions[$value]); // Remove da select
        }

        ksort($this->selectedFaults); // Reordena a lista selecionada$chaves = array_keys($array);
        $this->fault = 0;
        ksort($this->faultsOptions); // Reordena a lista selecionada
        $this->dispatch('updateFaults', array_keys($this->selectedFaults));
    }

    public function removeFaults($value)
    {
        if (isset($this->selectedFaults[$value])) {
            $this->faultsOptions[$value] = $this->selectedFaults[$value];
            unset($this->selectedFaults[$value]); // Remove da seleção
        }

        $this->fault = 0;
        ksort($this->faultsOptions); // Reordena a lista selecionada
        ksort($this->selectedFaults); // Reordena a lista selecionada
        $this->dispatch('updateFaults', array_keys($this->selectedFaults));
    }


    public function render()
    {
        return view('livewire.discipline.fault-disciplines.settings.faults-select');
    }
}
