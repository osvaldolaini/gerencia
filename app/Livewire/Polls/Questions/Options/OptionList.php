<?php

namespace App\Livewire\Polls\Questions\Options;

use App\Models\Polls\PollOption;
use App\Models\Polls\PollQuestion;
use Livewire\Attributes\On;
use Livewire\Component;

class OptionList extends Component
{
    public $question_id;
    public $dataTable;
    public $search;

    public $breadcrumb_number;
    public $breadcrumb_question;
    public $back = 'poll-list';
    public $route = 'poll';

    public function mount(PollQuestion $question)
    {
        if ($question->getAttributes()) {
            // dd($question->options);
            $this->question_id = $question->id;
            $this->breadcrumb_number = 'Questão ' . $question->order . ') ';
            $this->breadcrumb_question = $question->description;
            $this->reOrder();
            $this->loadItems();
        }
    }
    public function render()
    {
        return view('livewire.polls.questions.options.option-list');
    }

    public function updateOption($id, $option)
    {
        PollOption::where('id', $id)
            ->where('poll_question_id', $this->question_id)
            ->update([
                'option' => $option,
            ]);
    }
    public function save_out()
    {
        $this->dispatch('closeModal');
    }

    private function loadItems()
    {
        // Filtra com base no campo de busca
        $this->dataTable = PollOption::where('poll_question_id', $this->question_id)
            // ->where('active', 1)
            ->orderBy('order', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'active' => $item->active,
                    'option' => $item->option,
                    'order' => $item->order,
                    'order_label' => 'Opção: ' . $item->order,
                ];
            })
            ->toArray();
        // dd($this->dataTable);
    }

    #[On('atualizarOrdemOption')]
    public function atualizarOrdem($newOrder)
    {
        foreach ($newOrder as $index => $item) {
            $question = PollOption::find($item['id']);
            $question->order = $index + 1;
            $question->save();
        }

        $this->openAlert('success', 'Ordem alterada com sucesso.');

        $this->loadItems();
    }

    private function reOrder()
    {
        $this->dataTable = PollOption::where('poll_question_id', $this->question_id)->orderBy('order', 'asc')->get();
        // Enumerar a coluna 'order' de 1 até o último
        foreach ($this->dataTable as $index => $item) {
            // dd()
            $item->order = $index + 1; // Atualizar a coluna 'order'
            $item->save();             // Salvar no banco de dados
        }
    }

    public function addOption()
    {
        $last = PollOption::where('poll_question_id', $this->question_id)
            ->where('active', 1)
            ->orderBy('order', 'desc')
            ->first();
        if ($last) {
            $order = $last->order + 1;
        } else {
            $order = 1;
        }

        PollOption::create([
            'active'    => 1,
            'order'     => $order,
            'poll_question_id'   => $this->question_id,
            'option'   => 'Digite a alternativa'
        ]);
        $this->reOrder();
        $this->loadItems();
    }

    public function delete($id)
    {
        $data = PollOption::where('id', $id)->first();
        $data->active = 0;
        $data->save();
        $this->reOrder();
        $this->loadItems();
        $this->openAlert('success', 'Registro excluido com sucesso.');
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = PollOption::where('id', $id)->first();
        if ($data->active == 1) {
            $data->active = 0;
            $data->save();
        } else {
            $data->active = 1;
            $data->save();
        }

        $this->reOrder();
        $this->loadItems();
        $this->openAlert('success', 'Registro atualizado com sucesso.');
    }

    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
