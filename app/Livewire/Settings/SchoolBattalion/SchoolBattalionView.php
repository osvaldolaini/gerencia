<?php

namespace App\Livewire\Settings\SchoolBattalion;

use App\Models\Settings\Companies;
use App\Models\Settings\SchoolBattalions;
use Livewire\Component;

class SchoolBattalionView extends Component
{
    public $school_battalion;
    public $companies;
    public function mount(SchoolBattalions $school_battalion)
    {
        $this->school_battalion = $school_battalion;
        $this->companies = Companies::where('active', 1)->get();
    }
    public function render()
    {
        return view('livewire.settings.school-battalion.school-battalion-view');
    }
}
