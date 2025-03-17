<?php

namespace App\Livewire\Discipline\FaultDisciplines\Settings;

use Livewire\Component;


class MitigatingSelect extends Component
{
    public array $selectedMitigating = [];
    public array $mitigatingOptions;

    public function mount($mitigating)
    {
        if (!is_array($mitigating)) {
            $mitigating = [];
        }
        // dd($mitigating);
        $this->mitigatingOptions = collect(\App\Enums\Mitigating::cases())
            ->reject(fn($case) => in_array($case->value, $mitigating)) // Remove os que já estão em $mitigating
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();

        $this->selectedMitigating = collect(\App\Enums\Mitigating::cases())
            ->filter(fn($case) => in_array($case->value, $mitigating))
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();

        ksort($this->selectedMitigating); // Ordena os itens pela chave (crescente)
    }

    public function addMitigating($value)
    {
        if (isset($this->mitigatingOptions[$value])) {
            $this->selectedMitigating[$value] = $this->mitigatingOptions[$value];
            unset($this->mitigatingOptions[$value]); // Remove da select
        }

        ksort($this->selectedMitigating); // Reordena a lista selecionada
        $this->dispatch('updateMitigating', array_keys($this->selectedMitigating));
    }

    public function removeMitigating($value)
    {
        if (isset($this->selectedMitigating[$value])) {
            $this->mitigatingOptions[$value] = $this->selectedMitigating[$value];
            unset($this->selectedMitigating[$value]);
        }
        ksort($this->selectedMitigating); // Reordena a lista selecionada
        $this->dispatch('updateMitigating', array_keys($this->selectedMitigating));
    }

    public function render()
    {
        return view('livewire.discipline.fault-disciplines.settings.mitigating-select');
    }
}
