<?php

namespace App\Livewire\Extracurricular\ExtraActivities;

use App\Models\Extracurricular\ExtraActivities;
use App\Models\Extracurricular\ExtraModalities;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;

class ExtraActivityForm extends Component
{
    public $rules;

    public $back = 'extra-activity-list';
    public $route = 'extra-activity';

    public $breadcrumb = 'Atividade';
    //Fields
    public $id;
    public $title;
    public $extra_modalities_id;
    public $modalities;

    public function mount(ExtraActivities $extra_activity)
    {
        if ($extra_activity->getAttributes()) {
            $this->id           = $extra_activity->id;
            $this->title        = $extra_activity->title;
            $this->extra_modalities_id        = $extra_activity->extra_modalities_id;
        }
        $this->modalities = ExtraModalities::where("active", 1)->orderBy('title')->get();
    }

    public function render()
    {
        return view('livewire.extracurricular.extra-activities.extra-activity-form');
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
            'title' => 'required|' . Rule::unique('extra_activities')->ignore($this->id),
            'extra_modalities_id' => 'required'
        ];
        $this->validate();

        if ($this->id) {
            ExtraModalities::updateOrCreate([
                'id'    => $this->id,
            ], [
                'title'     => $this->title,
                'extra_modalities_id' => $this->extra_modalities_id,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $extra_activity = ExtraActivities::create([
                'active'    => 1,
                'title'     => $this->title,
                'extra_modalities_id' => $this->extra_modalities_id,
                'code'      => Str::uuid(),
            ]);
            $id = $extra_activity->id;
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
