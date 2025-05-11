<?php

namespace App\Livewire\Settings\SchoolClassroomSeats;

use App\Models\Settings\ClassroomSeats;
use App\Models\Settings\SchoolClasses;
use Livewire\Attributes\On;
use Livewire\Component;

use App\Models\Peoples;
use App\Models\Settings\SchoolClassesYears;

class SchoolClassroomSeatForm extends Component
{
    public $breadcrumb = 'Turma: ';

    public $school_classes;
    //Fields
    public $school_classes_id;
    public $rows;
    public $columns;
    public $door_side;


    public $title;
    public $year;
    public $otherClasses;

    public $modalSearch = false;
    public $inputSearch;
    public $results;
    public $people;
    public $field;

    public $selectColumn;
    public $selectRow;

    public $seats; // Collection de posições com info do aluno

    public function mount(SchoolClasses $school_classes)
    {
        if ($school_classes->getAttributes()) {
            $school_classes_year_id = $school_classes->classYears->id;
            $this->otherClasses = SchoolClassesYears::find($school_classes_year_id)->classes
                ->where('school_grade_id', $school_classes->school_grade_id);

            $this->title        = $school_classes->title;
            $this->year         = $school_classes->school_classes_year_id;
            $this->school_classes = $school_classes;

            $this->school_classes_id = $school_classes->id;
            $this->field = $school_classes->school_grade_id;
            $this->rows = $school_classes->rows;
            $this->columns = $school_classes->columns;
            $this->door_side = $school_classes->door_side;
            $this->breadcrumb .= $school_classes->title . ' / ' . $school_classes->classYears->year;
        }
    }

    public function render()
    {
        if ($this->inputSearch != '') {
            // $this->results = Peoples::select('id', 'name', 'number', 'nick', 'sex', 'logo_path')
            //     ->where('nick', 'LIKE', '%' . $this->inputSearch . '%')
            //     ->where('type', 1)
            //     ->orderBy('nick', 'asc')
            //     ->limit(5)
            //     ->get();

            if ($this->field) {
                $pluckStudents = [];
                // $classes = SchoolClasses::where('school_grade_id', $this->field)->where('active', 1)->get();
                // foreach ($classes as $class) {
                //     $pluckStudents = array_merge($pluckStudents, $class->studentsPivot->pluck('people_id')->toArray());
                // }
                // dd($pluckStudents);
                $pluckStudents = $this->school_classes->studentsPivot->pluck('people_id')->toArray();
                $this->results = Peoples::select('id', 'name', 'number', 'nick', 'sex', 'logo_path')
                    ->where('nick', 'LIKE', '%' . $this->inputSearch . '%')
                    ->whereIn('id', $pluckStudents)
                    ->orwhere('number', 'LIKE', '%' . $this->inputSearch . '%')
                    ->where('type', 1)
                    ->orderBy('nick', 'asc')
                    ->where('active', 1)
                    ->limit(5)
                    ->get();
            }
        }
        $this->seats = ClassroomSeats::with('students')
            ->where('school_classes_id', $this->school_classes_id)
            ->get();
        // dd($this->seats);

        return view('livewire.settings.school-classroom-seats.school-classroom-seat-form');
    }
    #[On('resetSeats')]
    public function resetSeats()
    {
        $school_classes = SchoolClasses::find($this->school_classes_id);

        $this->rows = $school_classes->rows;
        $this->columns = $school_classes->columns;
        $this->door_side = $school_classes->door_side;
        $this->seats = ClassroomSeats::with('students')
            ->where('school_classes_id', $this->school_classes_id)
            ->get();
        // dd($this->seats);
    }
    public function openModalSearch($r, $c)
    {
        $this->modalSearch = true;
        $this->selectColumn = $c;
        $this->selectRow = $r;
    }
    public function selectPeople($id)
    {
        $people = Peoples::find($id);
        $this->people = $people->setTitle();

        $this->inputSearch = '';
        $this->results = '';

        $this->modalSearch = false;

        ClassroomSeats::updateOrCreate([
            'column'            => $this->selectColumn,
            'row'               => $this->selectRow,
            'school_classes_id' => $this->school_classes_id,
        ], [
            'people_id' => $id,
        ]);
    }
    public function remove(ClassroomSeats $seats)
    {
        $seats->delete();
        $msg = 'Removido com sucesso.';

        $this->dispatch('resetSeats');
        $this->openAlert('success', $msg);
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
