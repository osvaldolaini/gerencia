<?php

namespace App\Livewire\App;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SideBar extends Component
{
    public function render()
    {
        return view('livewire.app.side-bar');
    }
}
