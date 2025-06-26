<?php

namespace App\Livewire\Extracurricular\ExtraModalities;

use App\Models\Extracurricular\ExtraModalities;
use Livewire\Component;

class ExtraModalityPage extends Component
{
    public $extra_modalities;
    public function mount(ExtraModalities $extra_modalities)
    {
        if ($extra_modalities) {
            $this->extra_modalities = $extra_modalities;
        }
    }
    public function render()
    {
        return view('livewire.extracurricular.extra-modalities.extra-modality-page');
    }
}
