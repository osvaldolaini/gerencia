<?php

namespace App\Livewire\Students;

use App\Models\Peoples;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class StudentForm extends Component
{
    public $rules;

    public $back = 'student-list';
    public $route = 'student';

    public $breadcrumb = 'Estudante';
    //Fields
    public $id;
    public $name;
    public $nick;
    public $number;
    public $sex;

    public function mount(Peoples $students)
    {
        if ($students->getAttributes()) {
            $this->id           = $students->id;
            $this->name         = $students->name;
            $this->nick         = $students->nick;
            $this->number       = $students->number;
            $this->sex          = $students->sex;
        }
    }

    public function render()
    {
        return view('livewire.students.student-form');
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
            // 'number' => 'max:5|required|' . Rule::unique('peoples')->ignore($this->id),
            'sex'   => 'required',
            'name'   => 'required',
            'nick'   => 'required',
        ];
        $this->validate();
        if ($this->id) {
            Peoples::updateOrCreate([
                'id'    => $this->id,
            ], [
                'name' => $this->name,
                'nick' => $this->nick,
                'number' => $this->number,
                'sex' => $this->sex,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $students = Peoples::create([
                'active'    => 1,
                'name'      => $this->name,
                'nick'      => $this->nick,
                'sex'       => $this->sex,
                'number'    => $this->number,
                'type'      => 1,
                'code'      => Str::uuid(),
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
