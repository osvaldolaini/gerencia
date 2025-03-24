<?php

namespace App\Livewire\User\Alerts;

use App\Models\Admin\AlertsUser;
use Livewire\Component;

class Checks extends Component
{
    public $alertsUser;
    public function mount(AlertsUser $alertsUser)
    {
        $this->alertsUser = $alertsUser;
        // dd($this->alertsUser);
    }
    public function render()
    {
        return view('livewire.user.alerts.checks');
    }
    public function check()
    {
        $this->alertsUser->see =  !$this->alertsUser->see;
        $this->alertsUser->save();
        $this->dispatch('user-alerts');
    }
}
