<?php

namespace App\Livewire\User\Alerts;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class Button extends Component
{
    public $alertsModal = false;
    public $alerts;
    public $allAlerts;

    #[On('user-alerts')]
    public function render()
    {
        $this->alerts = Auth::user()->alerts->where('see', 0);
        $this->allAlerts = Auth::user()->alerts;
        return view('livewire.user.alerts.button');
    }
    public function showAlertModal()
    {
        $this->alertsModal = true;
    }
}
