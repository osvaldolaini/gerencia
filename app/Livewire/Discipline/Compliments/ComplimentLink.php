<?php

namespace App\Livewire\Discipline\Compliments;

use App\Models\Discipline\Compliments;
use Livewire\Component;

class ComplimentLink extends Component
{
    public $next;
    public $previous;
    public function mount(Compliments $compliments)
    {

        $this->next = Compliments::where('active', 1)
            ->where('id', '>', $compliments->id)
            ->orderBy('id', 'asc')
            ->first();

        // Buscar o item anterior ativo com ID menor que o atual
        $this->previous = Compliments::where('active', 1)
            ->where('id', '<', $compliments->id)
            ->orderBy('id', 'desc')
            ->first();
        // dd($this->previous, $this->next);
    }
    public function render()
    {
        return view('livewire.discipline.compliments.compliment-link');
    }
}
