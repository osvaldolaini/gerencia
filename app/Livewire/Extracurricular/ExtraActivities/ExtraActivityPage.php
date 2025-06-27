<?php

namespace App\Livewire\Extracurricular\ExtraActivities;

use App\Models\Extracurricular\ExtraActivities;
use Livewire\Component;

class ExtraActivityPage extends Component
{
    public $extra_activity;
    public function mount(ExtraActivities $extra_activity)
    {
        if ($extra_activity) {
            $this->extra_activity = $extra_activity;
        }
    }
    public function render()
    {
        return view('livewire.extracurricular.extra-activities.extra-activity-page');
    }
}
