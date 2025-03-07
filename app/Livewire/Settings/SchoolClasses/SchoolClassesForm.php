<?php

namespace App\Livewire\Settings\SchoolClasses;

use App\Models\Settings\SchoolClasses;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class SchoolClassesForm extends Component
{
    public $rules;

    public $back = 'school-classes-year-list';
    public $route = 'school-classes';

    public $breadcrumb = 'Turma';
    //Fields
    public $id;
    public $title;
    public $year;

    public function mount(SchoolClasses $school_classes)
    {
        // dd($school_classes);
        if ($school_classes->getAttributes()) {
            $this->id           = $school_classes->id;
            $this->title        = $school_classes->title;
            $this->year         = $school_classes->school_classes_year_id;
        }
    }

    public function render()
    {
        return view('livewire.settings.school-classes.school-classes-form');
    }

    public function save()
    {
        $id = $this->real_save();
        if ($id) {
            redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        }
    }
    public function save_out()
    {
        $this->real_save();
        $this->dispatch('closeModal');
        $this->dispatch('see_excluded', 'success', 'Registro criado com sucesso.');
        // redirect()->route('school-classes-years-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'title' => 'min:3|max:3|required',
        ];
        $this->validate();
        if ($this->id) {
            SchoolClasses::updateOrCreate([
                'id'    => $this->id,
            ], [
                'title' => $this->title,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $school_classes = SchoolClasses::create([
                'active'    => 1,
                'title'      => $this->title,
                'code'      => Str::uuid(),
            ]);
            $id = $school_classes->id;
            $msg = 'Registro criado com sucesso.';
        }

        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
