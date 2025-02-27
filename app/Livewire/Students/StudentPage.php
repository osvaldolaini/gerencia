<?php

namespace App\Livewire\Students;

use App\Models\Peoples;
use Livewire\Component;

class StudentPage extends Component
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
        return view('livewire.students.student-page');
    }
}
