<?php

namespace App\Livewire\App\Battalion;

use App\Models\Settings\SchoolBattalionStudents;
use App\Models\Settings\SchoolGrades;
use Livewire\Component;

class StudentsGrade extends Component
{
    public $battalion;
    public $title;
    public $grade;
    public $seeModelBattalion = false;

    public function mount($grade)
    {
        $this->grade = $grade;
    }
    public function render()
    {
        return view('livewire.app.battalion.students-grade');
    }
    public function seeBattalion($grade)
    {
        $this->dispatch('seeBattalion', $grade);
    }
}
