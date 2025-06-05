<?php

namespace App\Livewire\App;

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
    public $grade;
    public $search;
    public $list = [];

    public $showModalView = false;

    public function mount(SchoolGrades $grade, $school_classes_year_id)
    {

        // Obtém os IDs das classes da grade
        $classIds = $grade->getClasses->pluck('id')->toArray();
        $this->title = $grade->name;
        $this->grade = $grade;

        // Busca os estudantes ativos do ano letivo e classes específicas
        $this->list = SchoolClassesStudent::where('active', 1)
            ->with(['students'])
            ->where('school_classes_year_id', $school_classes_year_id)
            ->whereIn('school_classes_id', $classIds)
            ->where(function ($query) {
                $query->orWhereHas('students', function ($q) {
                    $q->where('nick', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('number', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->get();
    }
    public function render()
    {
        return view('livewire.app.students-grade');
    }
    public function seeStudents()
    {
        $this->showModalView = true;
    }
}
