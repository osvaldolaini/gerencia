<?php

namespace App\Livewire\Students;

use Livewire\Component;
use App\Models\Peoples;
use App\Models\Settings\SchoolClasses;

class InputSearch extends Component
{

    //Search
    public $modalSearch = false;
    public $inputSearch;
    public $results;
    public $people;
    public $field;

    public function openModalSearch()
    {
        $this->modalSearch = true;
    }
    public function selectPeople($id)
    {
        $people = Peoples::find($id);
        $this->people = $people->setTitle();

        $this->inputSearch = '';
        $this->results = '';

        $this->modalSearch = false;
        //envia a id
        $this->dispatch('updatePeople', $people->id, $this->field);
    }
    public function mount($id = null, $field = null)
    {
        if ($id) {
            $people = Peoples::find($id);
            if ($people) {
                $this->people = $people->student_title;
            }
        }
        if ($field) {
            $this->field = $field;
            // dd($this->field);
        }
    }

    public function render()
    {
        if ($this->inputSearch != '') {
            $this->results = Peoples::select('id', 'name', 'number', 'nick', 'sex', 'logo_path')
                ->where('type', 1)
                ->where('nick', 'LIKE', '%' . $this->inputSearch . '%')
                ->orwhere('number', 'LIKE', '%' . $this->inputSearch . '%')
                ->orderBy('nick', 'asc')
                ->limit(10)
                ->get();

            if ($this->field) {
                $pluckStudents = [];
                $classes = SchoolClasses::where('school_grade_id', $this->field)->where('active', 1)->get();
                foreach ($classes as $class) {
                    $pluckStudents = array_merge($pluckStudents, $class->studentsPivot->pluck('people_id')->toArray());
                }
                // dd($pluckStudents);
                $this->results = Peoples::select('id', 'name', 'number', 'nick', 'sex', 'logo_path')
                    ->where('type', 1)
                    ->where('active', 1)
                    ->whereIn('id', $pluckStudents)
                    ->where('nick', 'LIKE', '%' . $this->inputSearch . '%')
                    ->orwhere('number', 'LIKE', '%' . $this->inputSearch . '%')
                    ->orderBy('nick', 'asc')
                    ->limit(10)
                    ->get();
            }
        }

        return view('livewire.students.input-search');
    }
}
