<?php

namespace App\Livewire\Students;

use App\Models\Peoples;
use Livewire\Component;

class StudentEmails extends Component
{
    public $emails;

    public function mount(Peoples $student)
    {
        $this->emails =  $student->emails;
    }
    public function render()
    {
        return view('livewire.students.student-emails');
    }
}
