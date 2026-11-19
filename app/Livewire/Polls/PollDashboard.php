<?php

namespace App\Livewire\Polls;

use Livewire\Component;
use App\Models\Polls\Poll;
use App\Models\Polls\PollVote;
use App\Models\Polls\PollAnswer;

class PollDashboard extends Component
{
    public $pollId;
    public $back = 'poll-list';

    public function mount($polls)
    {
        $this->pollId = $polls;
    }

    public function render()
    {
        $poll = Poll::with([
            'questions' => fn($query) => $query
                ->where('active', 1)
                ->orderBy('order'),

            'questions.options' => fn($query) => $query
                ->orderBy('order'),
        ])->findOrFail($this->pollId);

        $votesQuery = PollVote::where('poll_id', $poll->id);

        $totalVotes = (clone $votesQuery)->count();

        $lastVote = (clone $votesQuery)
            ->latest('voted_at')
            ->value('voted_at');

        // Participação por turma
        $classes = (clone $votesQuery)->with('schoolClass')
            ->selectRaw('school_class_id,COUNT(*) as total')
            ->whereNotNull('school_class_id')
            ->groupBy('school_class_id')
            ->orderByDesc('total')
            ->get();


        // Respostas registradas nesta enquete
        $answers = PollAnswer::whereHas('vote', function ($query) use ($poll) {
            $query->where('poll_id', $poll->id);
        })
            ->with('vote')
            ->get();

        // Resultados de cada pergunta
        $questionResults = $poll->questions->map(function ($question) use ($answers, $totalVotes) {

            $questionAnswers = $answers->where('poll_question_id', $question->id);

            $type = $question->type->value;

            if ($type === 'text') {

                return [
                    'question' => $question,
                    'type' => $type,
                    'total' => $questionAnswers
                        ->whereNotNull('answer_text')
                        ->count(),

                    'options' => collect(),
                    'texts' => $questionAnswers
                        ->filter(fn($answer) => filled($answer->answer_text))
                        ->sortByDesc('created_at')
                        ->values(),
                ];
            }

            $options = $question->options->map(function ($option) use ($questionAnswers, $totalVotes) {

                $count = $questionAnswers
                    ->where('poll_option_id', $option->id)
                    ->count();

                return [
                    'id' => $option->id,
                    'description' => $option->option,
                    'total' => $count,
                    'percentage' => $totalVotes > 0
                        ? round(($count / $totalVotes) * 100, 1)
                        : 0,
                ];
            });

            return [
                'question' => $question,
                'type' => $type,
                'total' => $questionAnswers->count(),
                'options' => $options,
                'texts' => collect(),
            ];
        });

        return view('livewire.polls.poll-dashboard', [
            'poll' => $poll,
            'totalVotes' => $totalVotes,
            'totalClasses' => $classes->count(),
            'lastVote' => $lastVote,
            'classes' => $classes,
            'questionResults' => $questionResults,
        ])->layout('layouts.app');
    }
    public function seeData($option)
    {
        $this->dispatch('seeData', $option);
    }
}
