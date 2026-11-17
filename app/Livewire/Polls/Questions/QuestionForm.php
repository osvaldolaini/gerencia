<?php

namespace App\Livewire\Polls\Questions;

use App\Models\Polls\PollQuestion;
use Livewire\Component;
use App\Enums\PollQuestionType;

class QuestionForm extends Component
{
    public $id;
    public $description;
    public $type;
    public $required;
    public $order;

    public function mount(PollQuestion $poll_question)
    {
        if ($poll_question->getAttributes()) {
            $this->id           = $poll_question->id;
            $this->order        = $poll_question->order;
            $this->description  = $poll_question->description;
            $this->type         = $poll_question->type;
            $this->required     = $poll_question->required;
        }
    }
    public function render()
    {
        return view('livewire.polls.questions.question-form');
    }
    public function save()
    {
        $id = $this->real_save();
    }
    public function save_out()
    {
        $this->real_save();
        $this->dispatch('closeModal');
    }

    public function real_save()
    {
        PollQuestion::updateOrCreate([
            'id'    => $this->id,
        ], [
            'type'         => $this->type,
            'required'      => $this->required,
            'description'   => $this->description,
        ]);

        $id = false;
        $msg = 'Registro editado com sucesso.';

        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
