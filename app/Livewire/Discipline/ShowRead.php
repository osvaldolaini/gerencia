<?php

namespace App\Livewire\Discipline;

use Livewire\Component;

class ShowRead extends Component
{
    public string $model;
    public int $itemId;

    public bool $showReadModal = false;

    public $read;

    public function mount(string $model, int $itemId)
    {
        $this->model = $model;
        $this->itemId = $itemId;
    }

    public function showRead()
    {
        $model = app($this->model);

        $this->read = $model->findOrFail($this->itemId);

        $this->showReadModal = true;
    }

    public function render()
    {
        return view('livewire.discipline.show-read');
    }
}
