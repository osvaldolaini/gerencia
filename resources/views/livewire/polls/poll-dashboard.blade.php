<div wire:poll.30s class="space-y-6">

    {{-- CABEÇALHO --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ url()->previous() }}" class="hover:text-primary">
                    Enquetes
                </a>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span>Painel de resultados</span>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                {{ $poll->title }}
            </h1>

            @if ($poll->description)
                <p class="text-sm text-gray-500 mt-1">
                    {{ $poll->description }}
                </p>
            @endif
        </div>

        <div class="flex flex-wrap gap-2">

            <a href="{{ route('polls.vote', ['slug' => $poll->slug]) }}" target="_blank"
                class="btn btn-outline dark:btn-accent btn-sm">
                <svg class="w-6 h-6" viewBox="0 0 24 24">
                    <title>link</title>
                    <path fill="currentColor"
                        d="M11 17H7q-2.075 0-3.537-1.463T2 12t1.463-3.537T7 7h4v2H7q-1.25 0-2.125.875T4 12t.875 2.125T7 15h4zm-3-4v-2h8v2zm5 4v-2h4q1.25 0 2.125-.875T20 12t-.875-2.125T17 9h-4V7h4q2.075 0 3.538 1.463T22 12t-1.463 3.538T17 17z" />
                </svg>
                Abrir votação
            </a>
            <a href="{{ route('poll-list-votes', $poll->id) }}" class="btn btn-outline dark:btn-accent btn-sm">
                <svg class="w-6 h-6" viewBox="0 -1.5 20.412 20.412" xmlns="http://www.w3.org/2000/svg">
                    <g id="check-lists" transform="translate(-1.588 -2.588)">
                        <path id="primary" d="M7,4,4.33,7,3,5.5" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <path id="primary-2" data-name="primary" d="M3,11.5,4.33,13,7,10" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <path id="primary-3" data-name="primary" d="M3,17.5,4.33,19,7,16" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <path id="primary-4" data-name="primary" d="M11,6H21M11,12H21M11,18H21" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </g>
                </svg>
                Ver votantes
            </a>

            <button type="button" onclick="window.location.reload()" class="btn btn-primary btn-sm">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <title>refresh</title>
                    <path fill="currentColor"
                        d="M12 20q-3.35 0-5.675-2.325T4 12t2.325-5.675T12 4q1.725 0 3.3.712T18 6.75V4h2v7h-7V9h4.2q-.8-1.4-2.187-2.2T12 6Q9.5 6 7.75 7.75T6 12t1.75 4.25T12 18q1.925 0 3.475-1.1T17.65 14h2.1q-.7 2.65-2.85 4.325T12 20" />
                </svg>
                Atualizar
            </button>

        </div>
    </div>

    {{-- INDICADORES --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- VOTOS --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total de votos</p>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                        {{ number_format($totalVotes, 0, ',', '.') }}
                    </h2>
                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Participações registradas</p>
        </div>

        {{-- TURMAS --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Turmas participantes</p>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                        {{ $totalClasses }}
                    </h2>
                </div>

                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                    <i class="fa-solid fa-school text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Turmas com votos registrados</p>
        </div>

        {{-- PERGUNTAS --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Perguntas</p>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white mt-2">
                        {{ $poll->questions->count() }}
                    </h2>
                </div>

                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-clipboard-list text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Perguntas ativas na enquete</p>
        </div>

        {{-- ÚLTIMO VOTO --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Último voto</p>
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white mt-2">
                        {{ $lastVote ? \Carbon\Carbon::parse($lastVote)->format('d/m/Y') : 'Nenhum voto' }}
                    </h2>
                </div>

                <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">
                {{ $lastVote ? \Carbon\Carbon::parse($lastVote)->format('H:i') : 'Aguardando participação' }}
            </p>
        </div>

    </div>

    {{-- RESULTADOS DAS PERGUNTAS --}}
    <div class="space-y-5">

        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                Resultados da votação
            </h2>
            <p class="text-sm text-gray-500">
                Distribuição das respostas por pergunta.
            </p>
        </div>

        @forelse($questionResults as $index => $result)

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">

                <div class="p-5 border-b border-gray-100 dark:border-gray-700">

                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

                        <div class="flex gap-3">
                            <div
                                class="w-9 h-9 shrink-0 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                {{ $index + 1 }}
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-white">
                                    {{ $result['question']->description }}
                                </h3>

                                <p class="text-xs text-gray-500 mt-1">
                                    @if ($result['type'] === 'single_choice')
                                        Escolha única
                                    @elseif($result['type'] === 'multiple_choice')
                                        Múltipla escolha
                                    @else
                                        Resposta aberta
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="text-sm text-gray-500 shrink-0">
                            <strong class="text-gray-800 dark:text-white">
                                {{ $result['total'] }}
                            </strong>
                            {{ $result['total'] === 1 ? 'resposta' : 'respostas' }}
                        </div>

                    </div>
                </div>

                <div class="p-5">

                    @if ($result['type'] === 'text')
                        {{-- RESPOSTAS ABERTAS --}}
                        @forelse($result['texts'] as $answer)
                            <div class="border-b border-gray-100 dark:border-gray-700 last:border-0 py-3 first:pt-0">

                                <p class="text-gray-700 dark:text-gray-200">
                                    {{ $answer->answer_text }}
                                </p>

                                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-gray-400">

                                    @if ($answer->pollVote)
                                        <span>
                                            <i class="fa-solid fa-user mr-1"></i>
                                            {{ $answer->pollVote->student_name }}
                                        </span>

                                        <span>
                                            Nº {{ $answer->pollVote->student_number }}
                                        </span>

                                        <span>
                                            {{ $answer->pollVote->school_class_name }}
                                        </span>
                                    @endif

                                </div>
                            </div>

                        @empty

                            <p class="text-sm text-gray-400 text-center py-6">
                                Nenhuma resposta registrada até o momento.
                            </p>
                        @endforelse
                    @else
                        {{-- RESULTADO DAS ALTERNATIVAS --}}
                        <div class="space-y-5">

                            @forelse($result['options'] as $option)
                                <div>

                                    <div class="flex items-center justify-between gap-3 mb-2">

                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                            {{ $option['description'] }}
                                        </span>

                                        <span class="text-sm text-gray-500 whitespace-nowrap">
                                            <strong class="text-gray-800 dark:text-white">
                                                {{ $option['total'] }}
                                            </strong>
                                            ({{ number_format($option['percentage'], 1, ',', '.') }}%)
                                        </span>

                                    </div>

                                    <div class="w-full h-3 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">

                                        <div class="h-full rounded-full bg-blue-600 transition-all duration-500"
                                            style="width: {{ min($option['percentage'], 100) }}%"></div>

                                    </div>

                                </div>

                            @empty

                                <p class="text-sm text-gray-400 text-center py-6">
                                    Esta pergunta ainda não possui alternativas.
                                </p>
                            @endforelse

                        </div>

                        @if ($result['type'] === 'multiple_choice')
                            <p class="text-xs text-gray-400 mt-5">
                                Em perguntas de múltipla escolha, um participante pode selecionar mais de uma
                                alternativa. Por isso, a soma dos percentuais pode ultrapassar 100%.
                            </p>
                        @endif
                    @endif

                </div>

            </div>

        @empty

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-10 text-center">
                <i class="fa-solid fa-clipboard-question text-4xl text-gray-300"></i>
                <p class="font-semibold text-gray-700 dark:text-gray-200 mt-4">
                    Nenhuma pergunta cadastrada
                </p>
                <p class="text-sm text-gray-400 mt-1">
                    Cadastre perguntas para visualizar os resultados.
                </p>
            </div>
        @endforelse

    </div>

    {{-- PARTICIPAÇÃO POR TURMA --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">

        <div class="p-5 border-b border-gray-100 dark:border-gray-700">
            <h2 class="font-bold text-gray-800 dark:text-white">
                Participação por turma
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Quantidade de alunos que participaram de cada turma.
            </p>
        </div>

        <div class="p-5">

            @forelse($classes as $class)
                <div class="flex items-center gap-4 py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between gap-3 mb-2">
                            <span class="font-medium text-sm text-gray-700 dark:text-gray-200">
                                {{ $class->school_class_name }}
                            </span>

                            <span class="text-sm font-semibold text-gray-800 dark:text-white">
                                {{ $class->total }}
                                {{ $class->total == 1 ? 'voto' : 'votos' }}
                            </span>
                        </div>

                        <div class="w-full h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full"
                                style="width: {{ $totalVotes > 0 ? ($class->total / $totalVotes) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <span class="text-xs text-gray-400 w-12 text-right">
                        {{ $totalVotes > 0 ? number_format(($class->total / $totalVotes) * 100, 1, ',', '.') : 0 }}%
                    </span>

                </div>

            @empty

                <p class="text-sm text-gray-400 text-center py-6">
                    Ainda não existem votos registrados.
                </p>
            @endforelse

        </div>

    </div>

</div>
