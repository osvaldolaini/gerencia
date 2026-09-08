<div class="relative">

    {{-- Loading --}}
    <div wire:loading.flex wire:target="sortStudents,search,selectCompany,companyId"
        class="absolute inset-0 z-50 items-start justify-center pt-20
               bg-white/60 dark:bg-gray-900/60 backdrop-blur-[2px]
               rounded-xl">
        <div
            class="flex items-center gap-3 px-5 py-3 bg-white border border-gray-200 shadow-lg dark:bg-gray-800 rounded-xl dark:border-gray-700">

            <svg class="w-6 h-6 text-blue-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>

                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>

            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                Atualizando alunos...
            </span>

        </div>
    </div>


    {{-- SUA LISTA ATUAL --}}
    <div class="mt-5 space-y-4">

        {{-- aqui entra exatamente o seu código atual --}}

    </div>

</div>
