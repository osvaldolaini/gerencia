<?php

namespace App\Livewire\App;

use App\Models\Admin\Settings\Settings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $fo = false;
    public $fault = false;
    // Define o layout a ser usado
    protected $layout = 'app';

    public $config;
    public $darkMode;

    public function mount()
    {
        $this->config = Settings::find(1);
        $this->darkMode = Auth::user()->dark;
    }
    public function render()
    {
        return view('livewire.app.dashboard')->layout('layouts.' . $this->layout);
    }
    public function fo_form()
    {
        $this->fo = true;
    }
    public function fault_form()
    {
        $this->fault = true;
    }

    //configs user
    public function toggleDarkMode()
    {
        $user = Auth::user();
        $user->dark = !$user->dark;
        $user->save();

        $this->darkMode = $user->dark;
        $this->dispatch('darkModeToggled', $this->darkMode);
    }
}
