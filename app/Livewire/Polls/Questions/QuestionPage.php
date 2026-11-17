<?php

namespace App\Livewire\Polls\Questions;

use App\Models\Polls\PollQuestion;
use Livewire\Component;

class QuestionPage extends Component
{
    public $question;
    public function mount(PollQuestion $question)
    {
        if ($question) {
            $this->question = $question;
        }
    }
    public function render()
    {
        return view('livewire.polls.questions.question-page');
    }
}
