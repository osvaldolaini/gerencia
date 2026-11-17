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

                <input type="number" wire:model="studentClass" placeholder="901" autocomplete="off" maxlength="3"
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

    <div class="bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 px-6 py-4 text-center">
        <p class="text-xs text-slate-500 dark:text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm6 10H6a2 2 0 01-2-2v-7a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2z" />
            </svg>
            Identificação protegida
        </p>
    </div>

</div>
