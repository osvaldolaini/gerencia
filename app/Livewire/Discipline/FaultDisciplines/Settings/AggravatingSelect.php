<?php

namespace App\Livewire\Discipline\FaultDisciplines\Settings;

use Livewire\Component;


class AggravatingSelect extends Component
{
    public array $selectedAggravating = [];
    public array $aggravatingOptions;

    public function mount($aggravating)
    {
        if (!is_array($aggravating)) {
            $aggravating = [];
        }
        $this->aggravatingOptions = collect(\App\Enums\Aggravating::cases())
            ->reject(fn($case) => in_array($case->value, $aggravating)) // Remove os que já estão em $aggravating
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();

        $this->selectedAggravating = collect(\App\Enums\Aggravating::cases())
            ->filter(fn($case) => in_array($case->value, $aggravating))
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();

        ksort($this->selectedAggravating); // Ordena os itens pela chave (crescente)
    }

    public function addAggravating($value)
    {
        if (isset($this->aggravatingOptions[$value])) {
            $this->selectedAggravating[$value] = $this->aggravatingOptions[$value];
            unset($this->aggravatingOptions[$value]); // Remove da select
        }

        ksort($this->selectedAggravating); // Reordena a lista selecionada

        $this->dispatch('updateAggravating', array_keys($this->selectedAggravating));
    }

    public function removeAggravating($value)
    {
        if (isset($this->selectedAggravating[$value])) {
            $this->aggravatingOptions[$value] = $this->selectedAggravating[$value];
            unset($this->selectedAggravating[$value]);
        }
        ksort($this->selectedAggravating); // Reordena a lista selecionada
        $this->dispatch('updateAggravating', array_keys($this->selectedAggravating));
    }

    public function render()
    {
        return view('livewire.discipline.fault-disciplines.settings.aggravating-select');
    }
}
