<div>
    <button wire:click='showRead()'
        class="flex px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="2.5" stroke="currentColor" />
            <path
                d="M18.2265 11.3805C18.3552 11.634 18.4195 11.7607 18.4195 12C18.4195 12.2393 18.3552 12.366 18.2265 12.6195C17.6001 13.8533 15.812 16.5 12 16.5C8.18799 16.5 6.39992 13.8533 5.77348 12.6195C5.64481 12.366 5.58048 12.2393 5.58048 12C5.58048 11.7607 5.64481 11.634 5.77348 11.3805C6.39992 10.1467 8.18799 7.5 12 7.5C15.812 7.5 17.6001 10.1467 18.2265 11.3805Z"
                stroke="currentColor" />
            <path d="M17.5 3.5H17.7C19.4913 3.5 20.387 3.5 20.9435 4.0565C21.5 4.61299 21.5 5.50866 21.5 7.3V7.5"
                stroke="currentColor" stroke-linecap="round" />
            <path d="M17.5 20.5H17.7C19.4913 20.5 20.387 20.5 20.9435 19.9435C21.5 19.387 21.5 18.4913 21.5 16.7V16.5"
                stroke="currentColor" stroke-linecap="round" />
            <path d="M6.5 3.5H6.3C4.50866 3.5 3.61299 3.5 3.0565 4.0565C2.5 4.61299 2.5 5.50866 2.5 7.3V7.5"
                stroke="currentColor" stroke-linecap="round" />
            <path d="M6.5 20.5H6.3C4.50866 20.5 3.61299 20.5 3.0565 19.9435C2.5 19.387 2.5 18.4913 2.5 16.7V16.5"
                stroke="currentColor" stroke-linecap="round" />
        </svg>
    </button>
    {{-- MODAL READ --}}
    <x-dialog-modal wire:model="showReadModal">
        <x-slot name="title">Detalhes</x-slot>
        <x-slot name="content">
            <dl class="text-left text-gray-900 divide-y divide-gray-200 max-w dark:text-white dark:divide-gray-700">
                @if ($read)
                    <div
                        class="flex flex-col w-full p-6 space-y-4 text-gray-500 divide-y dark:divide-gray-300 dark:bg-gray-800 dark:text-gray-500">
                        <div
                            class="flex flex-col w-full p-6 space-y-4 text-gray-500 divide-y dark:divide-gray-300 dark:text-gray-500">
                            <div class="grid grid-cols-2 text-gray-900 dark:text-gray-100">
                                <span class="dark:text-gray-500">Aluno </span>
                                <span class="dark:text-gray-500">Nr</span>
                                <span class="text-sm font-bold">{{ $read->al_nick }}</span>
                                <span class="text-sm font-bold">{{ $read->al_number }}</span>
                            </div>
                            <div class="grid grid-cols-2 text-gray-900 dark:text-gray-100">
                                <span class="dark:text-gray-500">Data </span>
                                <span class="dark:text-gray-500">Hora</span>
                                <span class="text-sm font-bold">{{ $read->f_date }}</span>
                                <span class="text-sm font-bold">{{ $read->fact_hour }}</span>
                            </div>
                            <div class="grid grid-cols-2 text-gray-900 dark:text-gray-100">
                                <span class="dark:text-gray-500">Observador</span>
                                <span class="dark:text-gray-500">Função</span>
                                <span class="text-sm font-bold">{{ $read->fact_observer }}</span>
                                <span class="text-sm font-bold">{{ strtoupper($read->fact_observer_function) }}</span>
                            </div>
                            <div class="grid grid-cols-2 text-gray-900 dark:text-gray-100">
                                <span class="col-span-2 dark:text-gray-500">Fato</span>
                                <span class="col-span-2 text-xs ">{{ $read->fact }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </dl>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showReadModal')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
