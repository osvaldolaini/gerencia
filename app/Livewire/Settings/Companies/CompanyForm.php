<?php

namespace App\Livewire\Settings\Companies;

use App\Models\Settings\Companies;
use Livewire\Component;
use Illuminate\Validation\Rule;

class CompanyForm extends Component
{
    public $rules;

    public $back = 'companies-list';
    public $route = 'company';

    public $breadcrumb = 'Companias';
    //Fields
    public $id;
    public $name;
    public $nick;

    public function mount(Companies $companies)
    {
        if ($companies->getAttributes()) {
            $this->id           = $companies->id;
            $this->name         = $companies->name;
            $this->nick         = $companies->nick;
        }
    }

    public function render()
    {
        return view('livewire.settings.companies.company-form');
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
        redirect()->route('companies-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'name' => 'required|' . Rule::unique('companies')->ignore($this->id),
        ];
        $this->validate();
        if ($this->id) {
            Companies::updateOrCreate([
                'id'    => $this->id,
            ], [
                'name' => $this->name,
                'nick' => $this->nick,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $students = Companies::create([
                'active'    => 1,
                'name'      => $this->name,
                'nick'      => $this->nick,
                'type'      => 1,
            ]);
            $id = $students->id;
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
