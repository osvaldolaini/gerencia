<?php

namespace App\Livewire\App\Settings;

use Livewire\Component;
use App\Models\Peoples;

use Livewire\Attributes\On;

class SelectStudents extends Component
{

    //Search
    public $modalSearch = false;
    public $inputSearch;
    public $results;
    public $people;
    public $field;
    public $selectedStudents = [];

    public function openModalSearch()
    {
        $this->modalSearch = true;
    }
    public function selectPeople($id)
    {
        $people = Peoples::find($id);
        // $this->people = $people->setTitle();

        $this->inputSearch = '';
        $this->results = '';

        $this->modalSearch = false;
        //envia a id
        $this->dispatch('appUpdateStudent', $people->id);
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
                ->where('name', 'LIKE', '%' . $this->inputSearch . '%')
                ->orwhere('number', 'LIKE', '%' . $this->inputSearch . '%')
                ->limit(5)
                ->get();
            if ($this->field) {
                # code...
            }
        }

        return view('livewire.app.settings.select-students');
    }
    #[On('appUpdateStudent')]
    public function addStudents($student_id)
    {
        $students = Peoples::find($student_id);
        $this->selectedStudents[] = [
            'id' => $students->id,
            'code_image' => $students->code_image,
            'number' => $students->number,
            'nick' => $students->nick,
            'sex' => $students->sex,
            'class' => ($students->al_Class ? $students->al_Class->title : ''),
        ];

        // Disparar evento com a lista atualizada
        $this->dispatch('foUpdateStudents', $this->selectedStudents);
    }

    public function removeStudents($value)
    {
        if (isset($this->selectedStudents[$value])) {
            unset($this->selectedStudents[$value]);
            $this->selectedStudents = array_values($this->selectedStudents); // Reindexa o array
        }

        // Disparar evento com a lista atualizada
        $this->dispatch('foUpdateStudents', $this->selectedStudents);
    }
}
