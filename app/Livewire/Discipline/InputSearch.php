<?php

namespace App\Livewire\Discipline;

use Livewire\Component;
use App\Models\Peoples;

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
            $this->results = Peoples::select('id', 'name', 'number', 'nick', 'sex', 'logo_path')
                ->where('name', 'LIKE', '%' . $this->inputSearch . '%')
                ->orwhere('number', 'LIKE', '%' . $this->inputSearch . '%')
                ->where('type', 1)
                ->where('active', 1)
                ->limit(5)
                ->get();
        }

        return view('livewire.discipline.input-search');
    }
}
