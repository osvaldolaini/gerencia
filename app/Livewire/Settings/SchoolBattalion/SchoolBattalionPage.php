<?php

namespace App\Livewire\Settings\SchoolBattalion;

use App\Models\Settings\SchoolBattalions;
use Livewire\Component;

class SchoolBattalionPage extends Component
{

    public $school_battalion;
    public function mount(SchoolBattalions $school_battalion)
    {
        if ($school_battalion) {
            $this->school_battalion = $school_battalion;
        }
    }
    public function render()
    {
        return view('livewire.settings.school-battalion.school-battalion-page');
    }
}
