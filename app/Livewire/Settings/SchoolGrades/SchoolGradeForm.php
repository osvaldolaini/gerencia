<?php

namespace App\Livewire\Settings\SchoolGrades;

use App\Models\Settings\Companies;
use App\Models\Settings\SchoolGrades;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class SchoolGradeForm extends Component
{
    public $rules;

    public $back = 'school-grades-list';
    public $route = 'school-grades';

    public $breadcrumb = 'Ano escolar';
    //Fields
    public $id;
    public $name;
    public $nick;
    public $company_id;
    public $companies;

    public function mount(SchoolGrades $school_grades)
    {
        if ($school_grades->getAttributes()) {
            $this->id           = $school_grades->id;
            $this->name         = $school_grades->name;
            $this->nick         = $school_grades->nick;
            $this->company_id   = $school_grades->company_id;
        }
        $this->companies = Companies::where('active', 1)->get();
    }

    public function render()
    {
        return view('livewire.settings.school-grades.school-grade-form');
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
            'company_id' => 'required',
            'name' => 'required|' . Rule::unique('school_grades')->ignore($this->id),
            'nick' => 'min:3|max:3|required|' . Rule::unique('school_grades')->ignore($this->id),
        ];
        $this->validate();
        if ($this->id) {
            SchoolGrades::updateOrCreate([
                'id'    => $this->id,
            ], [
                'name' => $this->name,
                'nick' => $this->nick,
                'company_id' => $this->company_id,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $school_grades = SchoolGrades::create([
                'active'    => 1,
                'name'      => $this->name,
                'nick'      => $this->nick,
                'company_id'      => $this->company_id,
                'code'      => Str::uuid(),
            ]);
            $id = $school_grades->id;
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
