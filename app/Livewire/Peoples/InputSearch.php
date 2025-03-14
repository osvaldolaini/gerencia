<?php

namespace App\Livewire\Peoples;

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
                ->where('name', 'LIKE', '%' . $this->inputSearch . '%')
                ->limit(5)
                ->get();
            if ($this->field) {
                # code...
            }
        }

        return view('livewire.peoples.input-search');
    }
}
