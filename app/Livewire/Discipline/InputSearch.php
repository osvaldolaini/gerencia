<?php

namespace App\Livewire\Discipline;

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

    public $pluckStudent;

    public function mount($class_id = null)
    {
        if ($class_id) {
            $this->pluckStudent = SchoolClasses::find($class_id)->studentsPivot->where('active', 1)->pluck('people_id')->toArray();
        }
    }
    public function openModalSearch()
    {
        $this->modalSearch = true;
    }
    public function selectPeople($id)
    {
        $people = Peoples::find($id);
        $this->people = '';

        $this->inputSearch = '';
        $this->results = '';

        $this->modalSearch = false;
        //envia a id
        $this->dispatch('updateStudent', $people->id);
    }

    public function render()
    {
        if ($this->inputSearch != '') {

            if ($this->pluckStudent) {
                $this->results = Peoples::select('id', 'name', 'number', 'nick', 'sex', 'logo_path')
                    ->where('name', 'LIKE', '%' . $this->inputSearch . '%')
                    ->whereIn('id', $this->pluckStudent)
                    ->orwhere('number', 'LIKE', '%' . $this->inputSearch . '%')
                    ->where('type', 1)
                    ->where('active', 1)
                    ->limit(5)
                    ->get();
            } else {
                $this->results = Peoples::select('id', 'name', 'number', 'nick', 'sex', 'logo_path')
                    ->where('name', 'LIKE', '%' . $this->inputSearch . '%')
                    ->orwhere('number', 'LIKE', '%' . $this->inputSearch . '%')
                    ->where('type', 1)
                    ->where('active', 1)
                    ->limit(5)
                    ->get();
            }
        }

        return view('livewire.discipline.input-search');
    }
}
