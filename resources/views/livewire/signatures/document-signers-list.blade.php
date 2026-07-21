<div x-init>
    @php
        use App\Enums\SignatureRole;
        use App\Enums\MilitaryRank;
    @endphp
    <x-layout.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
        </x-slot>

    </x-layout.breadcrumb>
    <x-layout.search>
        <x-slot name="button">
            <button wire:click="showCreate()"
                class="flex items-center justify-center p-3 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg lg:px-5 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <svg class="w-4 h-4 mr-0 lg:mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                <span class="">Novo </span>
            </button>
        </x-slot>
    </x-layout.search>
    <div>
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }

            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>

        <div class="flex-row gap-4 py-3 overflow-x-auto ">
            @foreach ($dataTable as $item)
                <div
                    class="p-5 my-2 transition-all duration-300 bg-white border border-gray-200 shadow-sm rounded-3xl dark:border-blue-800 dark:bg-zinc-950 hover:shadow-lg">
                    <div class="flex flex-col items-center justify-between">

                        <!-- CENTRO -->
                        <div class="grid flex-1 w-full grid-cols-6 gap-5 ">
                            <div
                                class="flex items-center justify-center col-span-1 text-2xl font-extrabold text-center border border-blue-600 rounded-md dark:text-white">
                                {{ $item->role->nick() }}
                            </div>
                            <!-- Dia -->
                            <div class="grid flex-1 grid-cols-1 col-span-4 gap-5 ">
                                <div>
                                    <p class="text-sm text-gray-400 dark:text-zinc-500">
                                        Função
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-700 dark:text-zinc-200">
                                        {{ $item->role->label() }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400 dark:text-zinc-500">
                                        Militar
                                    </p>

                                    <p class="mt-1 font-semibold text-gray-700 dark:text-zinc-200">
                                        {{ MilitaryRank::fromDb($item->user?->people->posto_grad)?->label() ?? '' }}
                                        {{ $item->user?->people->name }} ( {{ $item->user?->people->nick }} )
                                    </p>
                                </div>


                            </div>

                            <!-- DIREITA -->
                            <div class="flex items-end justify-end col-span-1 gap-3 text-right">
                                {{-- @if (in_array('active', auth()->user()->jsonActivities)) --}}
                                @if (in_array('active', auth()->user()->jsonActivities))
                                    <x-layout.table-toggle-active id='{{ $item->id }}'
                                        active='{{ $item->status }}'></x-layout.table-toggle-active>
                                @endif

                                {{-- @endif --}}
                                {{-- <button
                                    class="px-5 py-3 font-medium text-gray-700 transition bg-gray-100 rounded-2xl hover:bg-gray-200 dark:bg-zinc-900 dark:hover:bg-zinc-800 dark:text-zinc-200">

                                    Detalhes

                                </button> --}}

                            </div>
                        </div>


                    </div>

                </div>
            @endforeach

        </div>
    </div>



    {{-- MODAL DELETE --}}
    <x-confirmation-modal wire:model="showJetModal">
        <x-slot name="title">
            Excluir registro
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja realmente excluir o registro?</h2>
            <p>Não será possível reverter esta ação!</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showJetModal')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="delete({{ $id }})" wire:loading.attr="disabled">
                Apagar registro
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    {{-- MODAL READ --}}
    <x-dialog-modal wire:model="showModalForm">
        <x-slot name="title">Detalhes</x-slot>
        <x-slot name="content">
            <dl class="text-gray-900 divide-y divide-gray-200 max-w dark:text-white dark:divide-gray-700">
                @if ($detail)
                    @foreach ($detail as $item => $value)
                        @if ($value)
                            @if ($item == 'Foto')
                                <figure class="w-48">
                                    <img class="photo" src="{{ $value }}" alt="Movie" />
                                </figure>
                            @else
                                <div class="flex flex-col pb-1">
                                    <dt class="text-gray-500 md:text-lg dark:text-gray-400">{{ $item }}:
                                    </dt>
                                    <dd class="text-lg font-semibold">
                                        {{ $value }}
                                    </dd>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endif
            </dl>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalView')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    {{-- MODAL FORM --}}

    <x-dialog-modal wire:model="showModalForm" maxWidth="4xl">
        <x-slot name="title">{{ $breadcrumb }} </x-slot>
        <x-slot name="content">
            @if ($signatures)
                @livewire('signatures.document-signers-form', ['signatures' => $signatures], key($signatures->id))
            @else
                @livewire('signatures.document-signers-form')
            @endif
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>


</div>
