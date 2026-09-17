<div>
    @php
        use Carbon\Carbon;
    @endphp
    <x-layout.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
        </x-slot>
    </x-layout.breadcrumb>
    <div class="grid grid-cols-3">
        <div class="col-span-1">
            <h2 class="flex w-full text-gray-800 dark:text-white">Aguardando:</h2>
            <div class="flex w-full dark:text-white">
                @livewire('discipline.compliments.pdfs.buttons', ['status' => 'aguardando'])
            </div>
        </div>
        <div class="col-span-1">
            <h2 class="flex w-full text-gray-800 dark:text-white">Listas:</h2>
            <div class="flex w-full dark:text-white">
                @livewire('discipline.compliments.pdfs.buttons', ['status' => 'lista'])
            </div>
        </div>
        <div class="col-span-1">
            <h2 class="flex w-full text-gray-800 dark:text-white">Aditamentos:</h2>
            <div class="flex w-full dark:text-white">
                @livewire('discipline.compliments.pdfs.buttons', ['status' => 'aditamentos'])
            </div>
        </div>
        <div class="col-span-1">
            @livewire('settings.companies.select-company')
        </div>
        <div class="col-span-1">
            <h2 class="flex w-full text-gray-800 dark:text-white">Mostrar lançados:</h2>
            @if ($sincomil_date == true)
                <button wire:click='buttonSee' class="text-green-500 btn btn-outline btn-success btn-sm">
                    Mostrar lançados
                    <svg class="relative w-6 h-6 " viewBox="0 -6 32 32" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                            sketch:type="MSPage">
                            <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                transform="translate(-258.000000, -367.000000)" fill="currentColor">
                                <path
                                    d="M280,383 C276.687,383 274,380.313 274,377 C274,373.687 276.687,371 280,371 C283.313,371 286,373.687 286,377 C286,380.313 283.313,383 280,383 L280,383 Z M280,367 L268,367 C262.477,367 258,371.478 258,377 C258,382.522 262.477,387 268,387 L280,387 C285.523,387 290,382.522 290,377 C290,371.478 285.523,367 280,367 L280,367 Z M280,373 C277.791,373 276,374.791 276,377 C276,379.209 277.791,381 280,381 C282.209,381 284,379.209 284,377 C284,374.791 282.209,373 280,373 L280,373 Z"
                                    id="toggle-off" sketch:type="MSShapeGroup">
                                </path>
                            </g>
                        </g>
                    </svg>
                </button>
            @else
                <button wire:click='buttonSee' class="text-red-500 btn btn-outline btn-error btn-sm">
                    Mostrar lançados
                    <svg class="relative w-6 h-6" viewBox="0 -6 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                            sketch:type="MSPage">
                            <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-204.000000, -365.000000)"
                                fill="currentColor">
                                <path
                                    d="M214,379 C211.791,379 210,377.209 210,375 C210,372.791 211.791,371 214,371 C216.209,371 218,372.791 218,375 C218,377.209 216.209,379 214,379 L214,379 Z M214,369 C210.687,369 208,371.687 208,375 C208,378.313 210.687,381 214,381 C217.314,381 220,378.313 220,375 C220,371.687 217.314,369 214,369 L214,369 Z M226,383 L214,383 C209.582,383 206,379.418 206,375 C206,370.582 209.582,367 214,367 L226,367 C230.418,367 234,370.582 234,375 C234,379.418 230.418,383 226,383 L226,383 Z M226,365 L214,365 C208.477,365 204,369.478 204,375 C204,380.522 208.477,385 214,385 L226,385 C231.523,385 236,380.522 236,375 C236,369.478 231.523,365 226,365 L226,365 Z"
                                    id="toggle-on" sketch:type="MSShapeGroup">
                                </path>
                            </g>
                        </g>
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <x-layout.search>
        <x-slot name="button">
            {{-- <button wire:click="showCreate()"
                class="flex items-center justify-center p-3 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg lg:px-5 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <svg class="w-4 h-4 mr-0 lg:mr-2" fill="currentColor" viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                <span class="">Novo </span>
            </button> --}}
        </x-slot>
    </x-layout.search>
    <div class="mt-5 space-y-4">
        <!-- Lista de itens arrastáveis -->
        <div>
            @foreach ($dataTable as $item)
                <div class="mb-10 rounded-md cursor-pointer">
                    <h2 id="w-full text-center items-center">
                        <div type="button"
                            class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <div class="grid grid-cols-8 gap-2 mx-2 ">
                                <div class="flex justify-between pl-2 col-span-full ">
                                    <div class="p-0 tooltip tooltip-top" data-tip="Arraste e solte">
                                        Elogio Nº <span>{{ $item->fact_number }}</span>
                                    </div>
                                </div>
                                <div class="pl-2 col-span-full sm:col-span-1">
                                    @if ($item->student_id)
                                        @if ($item->students?->logo_path)
                                            <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_big.png') }}"
                                                class="mx-auto rounded-md">
                                        @else
                                            <x-application-logo width="h-12"></x-application-logo>
                                        @endif
                                    @else
                                        <x-application-logo width="h-12"></x-application-logo>
                                    @endif
                                </div>
                                <div class="pl-2 col-span-full sm:col-span-2">
                                    <h1 class="text-3xl font-bold">
                                        Al. {{ $item->al_nick }}
                                    </h1>
                                    <div class="max-w-xs">
                                        <p>
                                            nº. {{ $item->al_number }}
                                        </p>
                                        <p>
                                            T. {{ $item->al_class }}
                                        </p>
                                    </div>
                                </div>
                                <div class="pl-2 col-span-full sm:col-span-3">
                                    <ul class="timeline timeline-vertical">
                                        <li>

                                        <li>
                                            <div class="timeline-start">
                                                {{ Carbon::createFromFormat('Y-m-d', $item->fact_date)->format('d/m') }}
                                            </div>
                                            <div class="timeline-middle">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    class="w-5 h-5 {{ $item->fact_date ? 'text-success' : '' }}">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>

                                            <a class="timeline-end timeline-box"
                                                href="{{ route('compliment-edit', $item->id) }}#tab2">
                                                Abertura
                                            </a>

                                            @if ($item->fact_date)
                                                <hr class="bg-success" />
                                            @else
                                                <hr />
                                            @endif
                                        </li>
                                        <li>
                                            @if ($item->fact_date)
                                                @if ($item->fact_date)
                                                    <hr class="bg-success" />
                                                @else
                                                    <hr />
                                                @endif
                                            @else
                                                <hr />
                                            @endif
                                            <div class="timeline-start">
                                                @if ($item->solution_date)
                                                    {{ Carbon::createFromFormat('Y-m-d', $item->solution_date)->format('d/m') }}
                                                @endif

                                            </div>
                                            <div class="timeline-middle">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    class="w-5 h-5 {{ $item->solution_date ? 'text-success' : '' }}">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <a class="timeline-end timeline-box"
                                                href="{{ route('compliment-edit', $item->id) }}#tab3">
                                                Solução
                                            </a>


                                            @if ($item->solution_date)
                                                <hr class="bg-success" />
                                            @else
                                                <hr />
                                            @endif
                                        </li>

                                        <li>
                                            @if ($item->solution_date)
                                                <hr class="bg-success" />
                                            @else
                                                <hr />
                                            @endif
                                            <div class="timeline-start">
                                                @if ($item->bi_date)
                                                    {{ Carbon::createFromFormat('Y-m-d', $item->bi_date)->format('d/m') }}
                                                @endif

                                            </div>
                                            <div class="timeline-middle">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    class="w-5 h-5 {{ $item->bi_date ? 'text-success' : '' }}">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <a class="timeline-end timeline-box"
                                                href="{{ route('compliment-edit', $item->id) }}#tab5">
                                                Publicação
                                            </a>

                                            @if ($item->bi_date)
                                                <hr class="bg-success" />
                                            @else
                                                <hr />
                                            @endif
                                        </li>
                                        <li>
                                            @if ($item->bi_date)
                                                <hr class="bg-success" />
                                            @else
                                                <hr />
                                            @endif
                                            <div class="timeline-start">
                                                @if ($item->sincomil_date)
                                                    {{ Carbon::createFromFormat('Y-m-d', $item->sincomil_date)->format('d/m') }}
                                                @endif
                                            </div>
                                            <div class="timeline-middle">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    class="w-5 h-5 {{ $item->sincomil_date ? 'text-success' : '' }}">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <a class="timeline-end timeline-box"
                                                href="{{ route('compliment-edit', $item->id) }}#tab5">
                                                SINCOMIL
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                                <div class="col-span-full sm:col-span-2">
                                    <div class="justify-start block space-x-2 space-y-2 font-medium duration-200 ">
                                        <x-layout.table-options id='{{ $item->id }}'
                                            active='{{ $item->status }}'>
                                        </x-layout.table-options>
                                    </div>
                                    @if ($item->solution_date)
                                        <div>
                                            <p>Data lançamento SINCOMIL</p>
                                            @livewire('discipline.compliments.sincomil-date', ['compliment' => $item], key($item->id))
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </h2>
                </div>
            @endforeach
            <div class="items-center justify-between py-4">
                {{ $dataTable->links() }}
            </div>
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

            @livewire('discipline.compliments.compliment-form')
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>


</div>
