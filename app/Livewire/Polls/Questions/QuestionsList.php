<?php

namespace App\Livewire\Polls\Questions;

use App\Models\Polls\Poll;
use App\Models\Polls\PollOption;
use App\Models\Polls\PollQuestion;
use Livewire\Attributes\On;
use Livewire\Component;


class QuestionsList extends Component
{
    public $breadcrumb = 'Enquete: ';
    public $back = 'poll-list';
    public $route = 'poll';

    public $search;
    public $modal = true;
    public $showJetModal = false;
    public $showModalForm = false;
    public $showModalOptions = false;

    public $rules;
    public $detail;

    public $dataTable;
    public $poll_question;
    public $option;
    public $breadcrumb_question, $breadcrumb_number;

    //Fields
    public $id;
    public $description;
    public $type;
    public $required;
    public $order;
    public $poll_id;
    public $active;

    public function mount(Poll $polls)
    {
        if ($polls->getAttributes()) {
            $this->poll_id      = $polls->id;
            $this->breadcrumb  .= $polls->title;
        }
        $this->reOrder();
        $this->loadItems();
    }

    public function render()
    {
        return view('livewire.polls.questions.questions-list');
    }

    private function reOrder()
    {
        $this->dataTable = PollQuestion::where('poll_id', $this->poll_id)->orderBy('order', 'asc')->get();
        // Enumerar a coluna 'order' de 1 até o último
        foreach ($this->dataTable as $index => $item) {
            // dd()
            $item->order = $index + 1; // Atualizar a coluna 'order'
            $item->save();             // Salvar no banco de dados
        }
    }

    private function loadItems()
    {
        $this->dataTable = PollQuestion::where('poll_id', $this->poll_id)
            ->where('active', 1)
            ->orderBy('order', 'asc')->get();
        // Filtra com base no campo de busca
        $this->dataTable = PollQuestion::where('poll_id', $this->poll_id)
            // ->where('active', 1)
            ->orderBy('order', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'active' => $item->active,
                    'description' => $item->description,
                    'type' => $item->type->value,
                    'type_label' => $item->type->label(),
                    'required' => $item->required,
                    'required_label' => $item->required_label,
                    'order' => $item->order,
                    'order_label' => 'Questão: ' . $item->order,
                    'poll_id' => $item->poll_id,
                ];
            })
            ->toArray();
        // dd($this->dataTable);
    }

    #[On('atualizarOrdem')]
    public function atualizarOrdem($newOrder)
    {
        foreach ($newOrder as $index => $item) {
            $question = PollQuestion::find($item['id']);
            $question->order = $index + 1;
            $question->save();
        }

        $this->openAlert('success', 'Ordem alterada com sucesso.');

        $this->loadItems();
    }
    public function showOptions($id)
    {
        // $this->option = PollQuestion::findOrFail($id);
        // $this->breadcrumb_number = 'Questão ' . $this->option->order . ') ';
        // $this->breadcrumb_question = $this->option->description;
        // $this->showModalOptions = true;

        redirect()->route('option-list', $id);
    }

    public function addQuestion()
    {
        $last = PollQuestion::where('poll_id', $this->poll_id)
            ->orderBy('order', 'desc')
            ->first();
        if ($last) {
            $order = $last->order + 1;
        } else {
            $order = 1;
        }

        PollQuestion::create([
            'active'    => 1,
            'order'     => $order,
            'poll_id'   => $this->poll_id,
            'description'   => $this->description
        ]);
        $this->reOrder();
        $this->loadItems();
    }

    #[On('closeModal')]
    public function closeModal()
    {
        $this->showModalForm = false;
        $this->showModalOptions = false;
        $this->reOrder();
        $this->loadItems();
    }
    //Update
    public function showUpdate($id)
    {
        if ($this->modal) {
            $this->poll_question = PollQuestion::find($id);

            $this->showModalForm = true;
        } else {
            redirect()->route('question-edit', ['poll_question' => $id]);
        }
    }


    //DELETE
    public function showModalDelete($id)
    {
        $this->showJetModal = true;
        if (isset($id)) {
            $this->id = $id;
        } else {
            $this->id = '';
        }
    }
    public function delete($id)
    {
        $data = PollQuestion::where('id', $id)->first();
        $data->active = 0;
        $data->save();
        $this->reOrder();
        $this->loadItems();
        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = PollQuestion::where('id', $id)->first();
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
