<?php

namespace App\Livewire\Settings\SchoolClassesYears;

use App\Models\Settings\SchoolClassesYears;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class SchoolClassesYearForm extends Component
{
    public $rules;

    public $back = 'school-classes-years-list';
    public $route = 'school-classes-years';

    public $breadcrumb = 'Turmas / Ano';
    //Fields
    public $id;
    public $year;

    public function mount(SchoolClassesYears $school_classes_years)
    {
        if ($school_classes_years->getAttributes()) {
            $this->id           = $school_classes_years->id;
            $this->year         = $school_classes_years->year;
        }
    }

    public function render()
    {
        return view('livewire.settings.school-classes-years.school-classes-year-form');
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
        redirect()->route($this->route . '-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'year' => 'min:4|max:4|
            required|' . Rule::unique('school_classes_years')->ignore($this->id),
        ];
        $this->validate();
        if ($this->id) {
            SchoolClassesYears::updateOrCreate([
                'id'    => $this->id,
            ], [
                'year' => $this->year,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $school_classes_years = SchoolClassesYears::create([
                'active'    => 1,
                'year'      => $this->year,
                'code'      => Str::uuid(),
            ]);
            $id = $school_classes_years->id;
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
