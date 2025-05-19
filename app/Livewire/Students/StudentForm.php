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
    public $grau;
    public $entry_date;
    public $english_level;


    public function mount(Peoples $students)
    {
        if ($students->getAttributes()) {
            $this->id           = $students->id;
            $this->name         = $students->name;
            $this->nick         = $students->nick;
            $this->number       = $students->number;
            $this->sex          = $students->sex;
            $this->grau         = number_format($students->grau, 2);
            $this->entry_date   = $students->entry_date;
            $this->english_level  = $students->english_level;
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
            'name'  => 'required',
            'nick'  => 'required',
            'grau'  => 'required|lte:10',
            'entry_date' => 'required'
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
                'grau' => $this->grau,
                'english_level' => $this->english_level,
                'entry_date' => $this->entry_date,
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
                'english_level' => $this->english_level,
                'entry_date' => $this->entry_date,
                'grau'      => $this->grau,
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
    // public function updated($property)
    // {
    //     if ($property === 'grau') {
    //         if ($this->grau > 10.00) {
    //             $this->dispatch('openAlert', 'error', 'O valor não pode ser maior que 10,00');
    //             $this->grau = 0.00;
    //         }
    //     }
    // }
}
