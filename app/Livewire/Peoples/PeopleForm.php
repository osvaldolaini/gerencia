<?php

namespace App\Livewire\Peoples;

use App\Models\Peoples;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PeopleForm extends Component
{
    public $rules;

    public $back = 'peoples-list';
    public $route = 'peoples';

    public $breadcrumb = 'Efetivo';
    //Fields
    public $id;
    public $name;
    public $nick;
    public $posto_grad;
    public $function;
    public $sex;

    public function mount(Peoples $peoples)
    {
        if ($peoples->getAttributes()) {
            $this->id           = $peoples->id;
            $this->name         = $peoples->name;
            $this->nick         = $peoples->nick;
            $this->posto_grad   = $peoples->posto_grad;
            $this->function   = $peoples->function;
            $this->sex          = $peoples->sex;
        }
    }

    public function render()
    {
        return view('livewire.peoples.people-form');
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
            'sex'   => 'required',
            'name'   => 'required',
            'nick'   => 'required',
            'posto_grad'   => 'required',
            'function'   => 'required',
        ];
        $this->validate();
        if ($this->id) {
            Peoples::updateOrCreate([
                'id'    => $this->id,
            ], [
                'name' => $this->name,
                'nick' => $this->nick,
                'posto_grad' => $this->posto_grad,
                'function' => $this->function,
                'sex' => $this->sex,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $peoples = Peoples::create([
                'active'    => 1,
                'name'      => $this->name,
                'nick'      => $this->nick,
                'sex'       => $this->sex,
                'posto_grad' => $this->posto_grad,
                'function'  => $this->function,
                'type'      => 0,
                'code'      => Str::uuid(),
            ]);
            $id = $peoples->id;
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
