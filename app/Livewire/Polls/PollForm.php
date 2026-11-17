<?php

namespace App\Livewire\Polls;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Polls\Poll;

class PollForm extends Component
{
    public $rules;

    public $back = 'poll-list';
    public $route = 'poll';

    public $breadcrumb = 'Enquete';
    //Fields
    public $id;
    public $title;
    public $slug;
    public $description;
    public $start_date;
    public $end_date;

    public function mount(Poll $polls)
    {
        if ($polls->getAttributes()) {
            $this->id           = $polls->id;
            $this->title         = $polls->title;
            $this->description   = $polls->description;
            $this->start_date = $polls->start_date?->format('Y-m-d\TH:i');
            $this->end_date = $polls->end_date?->format('Y-m-d\TH:i');
        }
    }

    public function render()
    {
        return view('livewire.polls.poll-form');
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
            'end_date'   => 'required',
            'title'   => 'required',
            'description'   => 'required',
            'start_date'   => 'required',
        ];
        $this->validate();
        if ($this->id) {
            Poll::updateOrCreate([
                'id'    => $this->id,
            ], [
                'title'         => $this->title,
                'end_date'      => $this->end_date,
                'description'   => $this->description,
                'start_date'    => $this->start_date,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $polls = Poll::create([
                'active'        => 1,
                'title'         => $this->title,
                'end_date'      => $this->end_date,
                'description'   => $this->description,
                'start_date'    => $this->start_date,
            ]);
            $id = $polls->id;
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
