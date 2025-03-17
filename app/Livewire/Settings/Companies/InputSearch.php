<?php

namespace App\Livewire\Settings\Companies;

use Livewire\Component;
use App\Models\Peoples;

class InputSearch extends Component
{

    //Search
    public $modalSearch = false;
    public $inputSearch;
    public $results;
    public $people;

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
        $this->dispatch('updatePeople', $people->id);
    }
    public function mount($id = null)
    {
        if ($id) {
            $people = Peoples::find($id);
            if ($people) {
                $this->people = $people->student_title;
            }
        }
    }

    public function render()
    {
        if ($this->inputSearch != '') {
            $this->results = Peoples::select('id', 'name', 'number', 'nick', 'sex', 'logo_path')
                ->where('name', 'LIKE', '%' . $this->inputSearch . '%')
                ->where('type', 1)
                ->limit(5)
                ->get();
        }

        return view('livewire.settings.companies.input-search');
    }
}
