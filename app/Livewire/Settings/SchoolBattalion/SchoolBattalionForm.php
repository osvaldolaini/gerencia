<?php

namespace App\Livewire\Settings\SchoolBattalion;

use App\Models\Settings\SchoolBattalions;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class SchoolBattalionForm extends Component
{
    public $rules;

    public $back = 'school-battalion-list';
    public $route = 'school-battalion';

    public $breadcrumb = 'Batalhão / Ano';
    //Fields
    public $id;
    public $year;

    public function mount(SchoolBattalions $school_battalion)
    {
        if ($school_battalion->getAttributes()) {
            $this->id           = $school_battalion->id;
            $this->year         = $school_battalion->year;
        }
    }

    public function render()
    {
        return view('livewire.settings.school-battalion.school-battalion-form');
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
            required|' . Rule::unique('school_battalions')->ignore($this->id),
        ];
        $this->validate();
        if ($this->id) {
            SchoolBattalions::updateOrCreate([
                'id'    => $this->id,
            ], [
                'year' => $this->year,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $school_battalion = SchoolBattalions::create([
                'active'    => 1,
                'year'      => $this->year,
                'code'      => Str::uuid(),
            ]);
            $id = $school_battalion->id;
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
