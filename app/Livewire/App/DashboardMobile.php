<?php

namespace App\Livewire\App;

use Livewire\Component;

class DashboardMobile extends Component
{
    public function render()
    {
        return view('livewire.app.dashboard-mobile');
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
