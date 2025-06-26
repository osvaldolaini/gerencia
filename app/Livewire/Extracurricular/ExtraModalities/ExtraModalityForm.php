<?php

namespace App\Livewire\Extracurricular\ExtraModalities;

use App\Models\Extracurricular\ExtraModalities;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class ExtraModalityForm extends Component
{
    public $rules;

    public $back = 'extra-modality-list';
    public $route = 'extra-modality';

    public $breadcrumb = 'Modalidade';
    //Fields
    public $id;
    public $title;

    public function mount(ExtraModalities $extra_modality)
    {
        if ($extra_modality->getAttributes()) {
            $this->id           = $extra_modality->id;
            $this->title        = $extra_modality->title;
        }
    }

    public function render()
    {
        return view('livewire.extracurricular.extra-modalities.extra-modality-form');
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
            'title' => 'required|' . Rule::unique('extra_modalities')->ignore($this->id),

        ];
        $this->validate();
        if ($this->id) {
            ExtraModalities::updateOrCreate([
                'id'    => $this->id,
            ], [
                'title' => $this->title,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $extra_modality = ExtraModalities::create([
                'active'    => 1,
                'title'     => $this->title,
                'code'      => Str::uuid(),
            ]);
            $id = $extra_modality->id;
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
