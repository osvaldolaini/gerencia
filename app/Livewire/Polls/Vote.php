<?php

namespace App\Livewire\Polls;

use App\Enums\PollQuestionType;
use App\Models\Peoples;
use App\Models\Polls\Poll;
use App\Models\Polls\PollAnswer;
use App\Models\Polls\PollVote;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

use Livewire\Attributes\Locked;

use Illuminate\Database\QueryException;


use App\Models\Admin\Settings\Settings as Configs;

class Vote extends Component
{
    #[Locked]
    public $slug;

    // Etapas: identification, voting, finished
    public $step = 'identification';

    // Identificação do aluno
    public $studentNumber = '';
    public $studentName = '';
    public $studentClass = '';

    // Aluno validado
    #[Locked]
    public $studentId;
    public $studentNameConfirmed;
    #[Locked]
    public $studentClassId;
    public $studentClassConfirmed;

    #[Locked]
    public $configs;

    // Respostas
    public $answers = [];

    public $successMessage = '';

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->configs = Configs::find(1);

        abort_unless($this->getPoll(), 404);
    }

    /*
    |--------------------------------------------------------------------------
    | Enquete
    |--------------------------------------------------------------------------
    */

    private function getPoll()
    {
        return Poll::where('slug', $this->slug)
            ->with([
                'questions' => fn($query) => $query
                    ->where('active', 1)
                    ->orderBy('order'),

                'questions.options' => fn($query) => $query
                    ->orderBy('order'),
            ])
            ->first();
    }

    private function pollIsOpen($poll): bool
    {
        if (!$poll || !$poll->active) {
            return false;
        }

        if ($poll->start_date && now()->lt($poll->start_date)) {
            return false;
        }

        if ($poll->end_date && now()->gt($poll->end_date)) {
            return false;
        }

        return true;
    }

    private function getQuestionType($question): string
    {
        return $question->type instanceof PollQuestionType
            ? $question->type->value
            : $question->type;
    }

    /*
    |--------------------------------------------------------------------------
    | Identificação do aluno
    |--------------------------------------------------------------------------
    */

    public function identifyStudent()
    {
        $this->validate([
            'studentNumber' => ['required', 'string', 'max:30'],
            'studentName' => ['required', 'string', 'max:255'],
            'studentClass' => ['required', 'string', 'max:100'],
        ], [
            'studentNumber.required' => 'Informe seu número.',
            'studentName.required' => 'Informe seu nome completo.',
            'studentClass.required' => 'Informe sua turma.',
        ]);

        $poll = $this->getPoll();

        if (!$this->pollIsOpen($poll)) {
            throw ValidationException::withMessages([
                'studentNumber' => 'Esta votação não está disponível.',
            ]);
        }

        $student = Peoples::where('number', trim($this->studentNumber))
            ->where('active', 1)
            ->first();

        if (!$student) {
            throw ValidationException::withMessages([
                'studentNumber' => 'Aluno não encontrado.',
            ]);
        }

        // Ajustar o atributo caso o nome completo tenha outro nome no model.
        if (
            mb_strtolower(trim($student->name)) !==
            mb_strtolower(trim($this->studentName))
        ) {
            throw ValidationException::withMessages([
                'studentName' => 'O nome informado não corresponde ao cadastro.',
            ]);
        }

        // Utiliza o accessor getAlClassAttribute().
        $studentClass = $student->al_class;

        $schoolClass = $studentClass
            ? $studentClass
            : null;

        if (!$schoolClass) {
            throw ValidationException::withMessages([
                'studentClass' => 'Não foi possível identificar sua turma atual.',
            ]);
        }

        $className = $schoolClass->title;

        if (
            mb_strtolower(trim($className)) !==
            mb_strtolower(trim($this->studentClass))
        ) {
            throw ValidationException::withMessages([
                'studentClass' => 'A turma informada não corresponde ao cadastro.',
            ]);
        }

        // Verifica se já participou.
        $alreadyVoted = PollVote::where('poll_id', $poll->id)
            ->where('people_id', $student->id)
            ->exists();

        if ($alreadyVoted) {
            throw ValidationException::withMessages([
                'studentNumber' => 'Você já participou desta votação.',
            ]);
        }

        // Guarda somente os dados confirmados pelo servidor.
        $this->studentId = $student->id;
        $this->studentNameConfirmed = $student->name;
        $this->studentClassId = $schoolClass->id;
        $this->studentClassConfirmed = $className;

        // Inicializa as respostas.
        $this->answers = [];

        foreach ($poll->questions as $question) {
            $this->answers[$question->id] =
                $this->getQuestionType($question) === 'multiple_choice'
                ? []
                : '';
        }

        // Avança para a votação.
        $this->step = 'voting';
    }

    /*
    |--------------------------------------------------------------------------
    | Voltar para identificação
    |--------------------------------------------------------------------------
    */

    public function backToIdentification()
    {
        if ($this->step !== 'voting') {
            return;
        }

        $this->step = 'identification';

        $this->studentId = null;
        $this->studentNameConfirmed = null;
        $this->studentClassId = null;
        $this->studentClassConfirmed = null;

        $this->answers = [];
    }

    /*
    |--------------------------------------------------------------------------
    | Validação das respostas
    |--------------------------------------------------------------------------
    */

    private function validateAnswers($poll)
    {
        foreach ($poll->questions as $question) {

            $questionId = $question->id;
            $type = $this->getQuestionType($question);

            $answer = $this->answers[$questionId] ?? null;

            $hasAnswer = match ($type) {
                'multiple_choice' => is_array($answer) && count($answer) > 0,
                default => !is_array($answer) && trim((string) $answer) !== '',
            };

            if ($question->required && !$hasAnswer) {
                throw ValidationException::withMessages([
                    "answers.$questionId" => 'Esta pergunta é obrigatória.',
                ]);
            }

            if (!$hasAnswer) {
                continue;
            }

            if ($type === 'text') {

                if (!is_string($answer) || mb_strlen($answer) > 10000) {
                    throw ValidationException::withMessages([
                        "answers.$questionId" => 'Resposta inválida.',
                    ]);
                }

                continue;
            }

            $selectedIds = $type === 'multiple_choice'
                ? $answer
                : [$answer];

            if (
                !is_array($selectedIds) ||
                count($selectedIds) !== count(array_unique($selectedIds))
            ) {
                throw ValidationException::withMessages([
                    "answers.$questionId" => 'Seleção inválida.',
                ]);
            }

            $validOptionIds = $question->options
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->all();

            foreach ($selectedIds as $optionId) {

                if (!in_array((string) $optionId, $validOptionIds, true)) {
                    throw ValidationException::withMessages([
                        "answers.$questionId" => 'Alternativa inválida.',
                    ]);
                }
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Registrar voto
    |--------------------------------------------------------------------------
    */

    public function vote()
    {
        if ($this->step !== 'voting' || !$this->studentId) {
            return;
        }

        $poll = $this->getPoll();

        if (!$poll || !$this->pollIsOpen($poll)) {
            $this->step = 'identification';

            throw ValidationException::withMessages([
                'vote' => 'Esta votação não está mais disponível.',
            ]);
        }

        // Busca novamente o aluno no banco.
        $student = Peoples::where('id', $this->studentId)
            ->where('active', 1)
            ->first();

        if (!$student) {
            throw ValidationException::withMessages([
                'vote' => 'Não foi possível confirmar os dados do aluno.',
            ]);
        }

        // Confere novamente a turma atual do aluno.
        $studentClass = $student->al_class;
        $schoolClass = $studentClass ? $studentClass : null;

        if (!$schoolClass || $schoolClass->id != $this->studentClassId) {
            throw ValidationException::withMessages([
                'vote' => 'A turma informada não corresponde ao cadastro atual do aluno.',
            ]);
        }

        // Impede uma segunda votação.
        $alreadyVoted = PollVote::where('poll_id', $poll->id)
            ->where('people_id', $student->id)
            ->exists();

        if ($alreadyVoted) {
            throw ValidationException::withMessages([
                'vote' => 'Este aluno já participou desta votação.',
            ]);
        }

        // Valida as respostas antes de gravar.
        $this->validateAnswers($poll);

        try {
            DB::transaction(function () use ($poll, $student, $schoolClass) {

                $vote = PollVote::create([
                    'poll_id'           => $poll->id,
                    'people_id'         => $student->id,
                    'student_name'      => $student->name,
                    'student_number'    => $student->number,
                    'school_class_id'   => $schoolClass->id,
                    'school_class_name' => $schoolClass->title,
                    'voted_at'          => now(),
                ]);

                foreach ($poll->questions as $question) {

                    $answer = $this->answers[$question->id] ?? null;

                    if ($question->type->value === 'text') {

                        if (filled($answer)) {
                            PollAnswer::create([
                                'poll_vote_id'     => $vote->id,
                                'poll_question_id' => $question->id,
                                'poll_option_id'   => null,
                                'answer_text'      => trim($answer),
                            ]);
                        }

                        continue;
                    }

                    $selectedOptions = $question->type->value === 'multiple_choice'
                        ? (array) $answer
                        : [$answer];

                    foreach ($selectedOptions as $optionId) {

                        if (blank($optionId)) {
                            continue;
                        }

                        PollAnswer::create([
                            'poll_vote_id'     => $vote->id,
                            'poll_question_id' => $question->id,
                            'poll_option_id'   => $optionId,
                            'answer_text'      => null,
                        ]);
                    }
                }
            });
        } catch (QueryException $e) {

            // Proteção adicional pelo índice UNIQUE do banco.
            if (str_contains($e->getMessage(), 'poll_votes_unique_student')) {
                throw ValidationException::withMessages([
                    'vote' => 'Este aluno já participou desta votação.',
                ]);
            }

            throw $e;
        }

        $this->successMessage = 'Seu voto foi registrado com sucesso!';
        $this->step = 'finished';
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $poll = $this->getPoll();

        return view('livewire.polls.vote', [
            'poll' => $poll,
            'isOpen' => $this->pollIsOpen($poll),
        ])->layout('layouts.vote');
    }
}
