<?php

namespace App\Livewire\Polls;

use App\Models\Polls\Poll;
use App\Models\Polls\PollVote;
use Livewire\Component;

class PollListVotes extends Component
{
    public $breadcrumb = 'Enquete: ';
    public $back = 'poll-list';
    public $route = 'poll';

    public $poll_id;
    public $dataTable;

    public $selectedVote = false;

    public function mount(Poll $polls)
    {
        if ($polls->getAttributes()) {
            $this->poll_id      = $polls->id;
            $this->breadcrumb  .= $polls->title;
            $this->dataTable = PollVote::where('poll_id', $polls->id)->get();
        }
    }


    public function showVote($voteId)
    {
        $vote = PollVote::with([
            'answers.question',
            'answers.option',
        ])
            ->where('poll_id', $this->poll_id)
            ->findOrFail($voteId);

        $questions = Poll::findOrFail($this->poll_id)
            ->questions()
            ->where('active', 1)
            ->orderBy('order')
            ->get();

        $this->selectedVote = [
            'student_name' => $vote->student_name,
            'student_number' => $vote->student_number,
            'school_class_name' => $vote->school_class_name,
            'voted_at' => $vote->voted_at
                ? \Carbon\Carbon::parse($vote->voted_at)->format('d/m/Y H:i')
                : '-',

            'answers' => $questions->map(function ($question) use ($vote) {

                $answers = $vote->answers
                    ->where('poll_question_id', $question->id);

                if ($question->type->value === 'text') {
                    $response = $answers
                        ->pluck('answer_text')
                        ->filter()
                        ->implode("\n");
                } else {
                    $response = $answers
                        ->map(fn($answer) => $answer->option?->option)
                        ->filter()
                        ->implode(', ');
                }

                return [
                    'question' => $question->description,
                    'type' => $question->type->value,
                    'response' => $response ?: 'Não respondeu',
                ];
            })->values()->toArray(),
        ];
    }

    public function closeVoteModal()
    {
        $this->selectedVote = null;
    }

    public function render()
    {

        return view('livewire.polls.poll-list-votes');
    }
}
