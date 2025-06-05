<?php

namespace App\Livewire\App;

use App\Models\Peoples;
use App\Models\Settings\SchoolClassesStudent;
use App\Models\Settings\SchoolGrades;
use Livewire\Component;

class StudentsGrade extends Component
{
    public $school_years;
    public $school_grade;
    public $companies;
    public $school_classes_year_id;

    public $title;
    public $select_grade;
    public $search;
    public $list = [];

    public $showModalView = false;

    public function mount(SchoolGrades $grade, $school_classes_year_id)
    {
        $this->title = $grade->name;
        $this->select_grade = $grade;
        $this->school_classes_year_id = $school_classes_year_id;
    }
    public function render()
    {
        // Obtém os IDs das classes da grade
        $classIds = $this->select_grade->getClasses->pluck('id')->toArray();
        // Busca os estudantes ativos do ano letivo e classes específicas
        $this->list = SchoolClassesStudent::where('active', 1)
            ->with(['students'])
            ->where('school_classes_year_id', $this->school_classes_year_id)
            ->whereIn('school_classes_id', $classIds)
            ->where(function ($query) {
                $query->orWhereHas('students', function ($q) {
                    $q->where('nick', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('number', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->get();
        return view('livewire.app.students-grade');
    }

    public function seeStudentProfile(Peoples $student)
    {
        $this->dispatch('getStudent', $student);
    }
}
