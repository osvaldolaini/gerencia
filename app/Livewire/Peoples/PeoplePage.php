<?php

namespace App\Livewire\Peoples;

use App\Models\Peoples;
use Livewire\Component;

class PeoplePage extends Component
{
    public $peoples;
    public function mount(Peoples $peoples)
    {
        if ($peoples) {
            $this->peoples = $peoples;
        }
    }
    public function render()
    {
        return view('livewire.peoples.people-page');
    }
}
