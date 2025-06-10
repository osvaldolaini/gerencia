<?php

namespace App\Livewire\Peoples;

use Livewire\Component;
use App\Models\Peoples;
use App\Enums\MilitaryRank;

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
        $this->people = (MilitaryRank::fromDb($people->posto_grad)?->label() ?? '')
            . ' ' . $people->nick;

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
                $this->people = (MilitaryRank::fromDb($people->posto_grad)?->label() ?? '')
                    . ' ' . $people->nick;
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
            // $this->results = Peoples::select('id', 'name', 'nick', 'sex', 'function', 'posto_grad', 'logo_path')
            //     ->where('type', 1)
            //     ->where('active', 1)
            //     ->where('nick', 'LIKE', '%' . $this->inputSearch . '%')
            //     ->limit(10)
            //     ->get();
            if ($this->field) {
                # code...
            }
        }

        return view('livewire.peoples.input-search');
    }
}
