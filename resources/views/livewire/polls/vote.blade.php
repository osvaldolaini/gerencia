<div class="min-h-screen bg-slate-50 dark:bg-slate-950">

    {{-- CABEÇALHO --}}
    <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-5xl mx-auto px-5 py-5 flex items-center justify-between">

            <div class="flex items-center gap-3">
                <div
                    class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg> --}}
                    <x-application-logo width="h-12"></x-application-logo>
                </div>

                <div>
                    <h1 class="font-bold text-slate-800 dark:text-white leading-tight">
                        Votação Escolar
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Sua opinião faz a diferença
                    </p>
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Ambiente de votação
            </div>

        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 py-8 md:py-12">

        {{-- TÍTULO DA ENQUETE --}}
        <div class="text-center mb-8">

            <div
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-300 text-xs font-semibold mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3M4 11h16M5 21h14a1 1 0 001-1V6a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                </svg>
                PESQUISA DE OPINIÃO
            </div>

            <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                {{ $poll->title }}
            </h2>

            @if ($poll->description)
                <p class="max-w-xl mx-auto mt-4 text-slate-500 dark:text-slate-400 leading-relaxed">
                    {{ $poll->description }}
                </p>
            @else
                <p class="max-w-xl mx-auto mt-4 text-slate-500 dark:text-slate-400 leading-relaxed">
                    Queremos ouvir você! Responda às perguntas abaixo e participe desta votação.
                </p>
            @endif

        </div>

        {{-- ENQUETE INDISPONÍVEL --}}
        @if (!$isOpen)

            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-10 text-center shadow-sm">

                <div
                    class="w-20 h-20 mx-auto rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-slate-800 dark:text-white">
                    Votação indisponível
                </h3>

                <p class="mt-2 text-slate-500 dark:text-slate-400">
                    Esta votação ainda não começou ou já foi encerrada.
                </p>

            </div>

            {{-- VOTO FINALIZADO --}}
        @elseif($step === 'finished')
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8 md:p-12 text-center shadow-sm">

                <div class="relative w-24 h-24 mx-auto mb-7">
                    <div
                        class="absolute inset-0 rounded-full bg-emerald-100 dark:bg-emerald-500/10 animate-ping opacity-40">
                    </div>

                    <div
                        class="relative w-24 h-24 rounded-full bg-emerald-100 dark:bg-emerald-500/10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-emerald-600 dark:text-emerald-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <span class="text-xs font-bold tracking-widest text-emerald-600 dark:text-emerald-400 uppercase">
                    Participação registrada
                </span>

                <h3 class="mt-3 text-3xl font-extrabold text-slate-900 dark:text-white">
                    Muito obrigado!
                </h3>

                <p class="mt-4 text-slate-500 dark:text-slate-400 leading-relaxed max-w-md mx-auto">
                    {{ $successMessage }}
                </p>

                <div
                    class="mt-8 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 text-sm text-slate-500 dark:text-slate-400">
                    Sua participação foi registrada. Você não poderá votar novamente nesta enquete.
                </div>

            </div>

            {{-- IDENTIFICAÇÃO --}}
        @elseif($step === 'identification')
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-6 md:p-8">

                    <div class="flex items-start gap-4 mb-7">
                        <div
                            class="w-12 h-12 shrink-0 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0M19 8v6m3-3h-6" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                Identifique-se para continuar
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                Precisamos confirmar seus dados antes de liberar a votação.
                            </p>
                        </div>
                    </div>

                    <form wire:submit="identifyStudent" class="space-y-5">

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Número do aluno
                            </label>

                            <input type="text" wire:model="studentNumber" placeholder="Ex.: 125" autocomplete="off"
                                class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3.5 text-slate-900 dark:text-white placeholder:text-slate-400 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">

                            @error('studentNumber')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Nome completo
                            </label>

                            <input type="text" wire:model="studentName" placeholder="Digite seu nome completo"
                                autocomplete="name"
                                class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3.5 text-slate-900 dark:text-white placeholder:text-slate-400 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">

                            @error('studentName')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Turma
                            </label>

                            <input type="number" wire:model="studentClass" placeholder="901" autocomplete="off"
                                maxlength="3"
                                class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3.5 text-slate-900 dark:text-white placeholder:text-slate-400 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">

                            @error('studentClass')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div
                            class="flex items-start gap-3 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-100 dark:border-amber-500/20 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 shrink-0 text-amber-600 dark:text-amber-400 mt-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3m0 4h.01M10.3 3.86L1.82 18.14A2 2 0 003.53 21h16.94a2 2 0 001.71-2.86L13.7 3.86a2 2 0 00-3.4 0z" />
                            </svg>

                            <p class="text-xs leading-relaxed text-amber-800 dark:text-amber-300">
                                Seus dados serão utilizados exclusivamente para confirmar sua identificação e garantir
                                que cada aluno participe apenas uma vez.
                            </p>
                        </div>

                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full flex items-center justify-center gap-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-5 transition shadow-lg shadow-indigo-600/20 disabled:opacity-60">
                            <span wire:loading.remove wire:target="identifyStudent">
                                Continuar para votação
                                <span class="ml-2">→</span>
                            </span>

                            <span wire:loading wire:target="identifyStudent">
                                Verificando seus dados...
                            </span>
                        </button>

                    </form>

                </div>

                <div
                    class="bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 px-6 py-4 text-center">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm6 10H6a2 2 0 01-2-2v-7a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2z" />
                        </svg>
                        Identificação protegida
                    </p>
                </div>

            </div>
            {{-- @livewire('polls.vote.identification') --}}
            {{-- FORMULÁRIO DE VOTAÇÃO --}}
        @elseif($step === 'voting')
            @php
                $totalQuestions = $poll->questions->count();
            @endphp

            {{-- IDENTIFICAÇÃO DO ALUNO --}}
            <div
                class="mb-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 flex items-center justify-between gap-4">

                <div class="flex items-center gap-3 min-w-0">

                    <div
                        class="w-12 h-12 shrink-0 rounded-full bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-lg">
                        {{ mb_substr($studentNameConfirmed, 0, 1) }}
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-bold text-slate-800 dark:text-white truncate">
                            {{ $studentNameConfirmed }}
                        </p>

                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            {{ $studentClassConfirmed }} · Nº {{ $studentNumber }}
                        </p>
                    </div>

                </div>

                <span
                    class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Identificado
                </span>

            </div>

            {{-- PROGRESSO / INFORMAÇÕES --}}
            <div class="mb-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5">

                <div class="flex items-center justify-between gap-3 mb-3">

                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white">
                            Questionário
                        </h3>

                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            Leia atentamente e escolha suas respostas.
                        </p>
                    </div>

                    <div class="text-right">
                        <span class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400">
                            {{ $totalQuestions }}
                        </span>

                        <p class="text-xs text-slate-400">
                            {{ $totalQuestions === 1 ? 'pergunta' : 'perguntas' }}
                        </p>
                    </div>

                </div>

                <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                    <div class="h-full rounded-full bg-indigo-600 w-full"></div>
                </div>

                <div class="flex flex-wrap items-center gap-4 mt-4 text-xs text-slate-500 dark:text-slate-400">

                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        Obrigatória
                    </span>

                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                        Opcional
                    </span>

                </div>

            </div>

            {{-- PERGUNTAS --}}
            <form wire:submit="vote" class="space-y-6">

                @forelse($poll->questions as $index => $question)
                    @php
                        $type =
                            $question->type instanceof \App\Enums\PollQuestionType
                                ? $question->type->value
                                : $question->type;

                        $typeLabel = match ($type) {
                            'single_choice' => 'Escolha única',
                            'multiple_choice' => 'Múltipla escolha',
                            'text' => 'Resposta aberta',
                            default => 'Pergunta',
                        };

                        $typeIcon = match ($type) {
                            'single_choice' => 'fa-circle-dot',
                            'multiple_choice' => 'fa-list-check',
                            'text' => 'fa-pen-to-square',
                            default => 'fa-circle-question',
                        };
                    @endphp

                    <div wire:key="poll-question-{{ $question->id }}"
                        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">

                        {{-- CABEÇALHO DA PERGUNTA --}}
                        <div class="p-6 md:p-7">

                            <div class="flex items-center justify-between gap-3 mb-5">

                                <span
                                    class="text-xs font-bold tracking-wider text-indigo-600 dark:text-indigo-400 uppercase">
                                    Pergunta {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-1.5 rounded-full bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-300 whitespace-nowrap">

                                    <i class="fa-solid {{ $typeIcon }}"></i>

                                    {{ $typeLabel }}

                                </span>

                            </div>

                            <h3 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white leading-snug">
                                {{ $question->description }}

                                @if ($question->required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </h3>

                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 mb-6">
                                @if ($type === 'single_choice')
                                    Selecione apenas uma alternativa.
                                @elseif($type === 'multiple_choice')
                                    Você pode selecionar mais de uma alternativa.
                                @else
                                    Escreva sua resposta no campo abaixo.
                                @endif

                                @unless ($question->required)
                                    <span class="block mt-1 text-slate-400">
                                        Esta pergunta é opcional.
                                    </span>
                                @endunless
                            </p>

                            {{-- ESCOLHA ÚNICA --}}
                            @if ($type === 'single_choice')
                                <div class="space-y-3">

                                    @forelse($question->options as $option)
                                        <label wire:key="poll-option-{{ $option->id }}"
                                            class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition
                                {{ (string) ($answers[$question->id] ?? '') === (string) $option->id
                                    ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-500/10'
                                    : 'border-slate-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-500/50' }}">

                                            <input type="radio" wire:model="answers.{{ $question->id }}"
                                                value="{{ $option->id }}" class="radio radio-primary">

                                            <span
                                                class="text-sm md:text-base font-medium text-slate-700 dark:text-slate-200">
                                                {{ $option->option }}
                                            </span>

                                        </label>

                                    @empty

                                        <p class="text-sm text-amber-600 dark:text-amber-400">
                                            Esta pergunta ainda não possui alternativas cadastradas.
                                        </p>
                                    @endforelse

                                </div>

                                {{-- MÚLTIPLA ESCOLHA --}}
                            @elseif($type === 'multiple_choice')
                                <div class="space-y-3">

                                    @forelse($question->options as $option)
                                        <label wire:key="poll-option-{{ $option->id }}"
                                            class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition
                                {{ in_array((string) $option->id, array_map('strval', (array) ($answers[$question->id] ?? [])), true)
                                    ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-500/10'
                                    : 'border-slate-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-500/50' }}">

                                            <input type="checkbox" wire:model="answers.{{ $question->id }}"
                                                value="{{ $option->id }}" class="checkbox checkbox-primary">

                                            <span
                                                class="text-sm md:text-base font-medium text-slate-700 dark:text-slate-200">
                                                {{ $option->option }}
                                            </span>

                                        </label>

                                    @empty

                                        <p class="text-sm text-amber-600 dark:text-amber-400">
                                            Esta pergunta ainda não possui alternativas cadastradas.
                                        </p>
                                    @endforelse

                                </div>

                                {{-- RESPOSTA ABERTA --}}
                            @elseif($type === 'text')
                                <textarea wire:model="answers.{{ $question->id }}" rows="5" maxlength="10000"
                                    placeholder="Escreva sua resposta aqui..."
                                    class="w-full rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-4 text-slate-800 dark:text-white placeholder:text-slate-400 outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 resize-y"></textarea>

                                <p class="text-xs text-slate-400 mt-2">
                                    Sua resposta será registrada individualmente.
                                </p>
                            @endif

                            {{-- ERROS DA PERGUNTA --}}
                            @error("answers.{$question->id}")
                                <div class="mt-4 flex items-center gap-2 text-sm text-red-500">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                @empty

                    <div
                        class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-10 text-center">

                        <i class="fa-solid fa-clipboard-question text-4xl text-slate-300 mb-4"></i>

                        <h3 class="font-bold text-slate-800 dark:text-white">
                            Nenhuma pergunta disponível
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            Esta enquete ainda não possui perguntas cadastradas.
                        </p>

                    </div>
                @endforelse

                {{-- AVISO --}}
                @if ($totalQuestions > 0)
                    <div
                        class="flex gap-3 p-4 rounded-2xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20">

                        <i class="fa-solid fa-circle-info text-blue-600 dark:text-blue-400 mt-0.5"></i>

                        <p class="text-xs leading-relaxed text-blue-800 dark:text-blue-300">
                            Confira suas respostas antes de confirmar. Após o envio, não será possível alterar ou
                            realizar uma nova participação nesta enquete.
                        </p>

                    </div>

                    {{-- BOTÃO DE CONFIRMAÇÃO --}}

                    <div class="mt-8 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">

                        {{-- <button type="button" wire:click="backToIdentification" wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl
                                border border-gray-300 dark:border-gray-600
                                text-gray-700 dark:text-gray-200
                                hover:bg-gray-100 dark:hover:bg-gray-700
                                transition disabled:opacity-50">
                            <i class="fa-solid fa-arrow-left"></i>
                            Voltar
                        </button> --}}

                        <button type="button" wire:click="vote"
                            wire:confirm="Confirma o envio do seu voto? Após gravar, não será possível alterar suas respostas."
                            wire:loading.attr="disabled" wire:target="vote" @disabled($poll->questions->isEmpty())
                            class="w-full items-center justify-center gap-2 px-8 py-3 rounded-xl
                                bg-blue-600 hover:bg-blue-700 text-white font-semibold
                                shadow-sm transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="vote">
                                <i class="fa-solid fa-check"></i>
                                Confirmar e gravar voto
                            </span>

                            <span wire:loading wire:target="vote">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                Gravando voto...
                            </span>
                        </button>

                    </div>


                    <p class="text-center text-xs text-slate-400">
                        Sua participação será registrada de forma individual.
                    </p>
                @endif

            </form>

        @endif


        {{-- RODAPÉ --}}
        <footer class="mt-10 text-center">
            <div class="flex items-center justify-center gap-2 text-slate-400 dark:text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm6 10H6a2 2 0 01-2-2v-7a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2z" />
                </svg>
                <span class="text-xs">Participação segura e individual</span>
            </div>

            <p class="text-xs text-slate-400 dark:text-slate-600 mt-2">
                {{ $configs->name }}
            </p>
        </footer>

    </main>

</div>
