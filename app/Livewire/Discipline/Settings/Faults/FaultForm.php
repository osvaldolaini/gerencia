<?php

namespace App\Livewire\Discipline\Settings\Faults;

use App\Models\Discipline\Settings\Faults;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class FaultForm extends Component
{
    public $rules;

    public $back = 'faults-list';
    public $route = 'faults';

    public $breadcrumb = 'Falta';
    //Fields
    public $id;
    public $title;
    public $number;

    public function mount(Faults $faults)
    {
        if ($faults->getAttributes()) {
            $this->id           = $faults->id;
            $this->title        = $faults->title;
            $this->number       = $faults->number;
        }
    }

    public function render()
    {
        return view('livewire.discipline.settings.faults.fault-form');
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
            'title' => 'required|' . Rule::unique('faults')->ignore($this->id),
            'number' => 'required'
        ];
        $this->validate();
        if ($this->id) {
            Faults::updateOrCreate([
                'id'    => $this->id,
            ], [
                'title' => $this->title,
                'number' => $this->number,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $faults = Faults::create([
                'active'    => 1,
                'title'     => $this->title,
                'number'    => $this->number,
                'code'      => Str::uuid(),
            ]);
            $id = $faults->id;
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
