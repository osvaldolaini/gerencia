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
    <div class="grid w-full grid-cols-8">
        <div class="w-full col-span-1">
            <div class="p-0 tooltip tooltip-top" wire:click='print()' data-tip="Lista em pdf" wire:ignore>
                <button
                    class="px-3 py-2 text-gray-800 transition-colors duration-200 rounded-sm dark:text-white whitespace-nowrap">
                    <x-layout.svg.pdf class="w-8 h-8 text-white"></x-layout.svg.pdf>
                </button>
            </div>
        </div>
    </div>
    <div class="flex justify-center mb-5">
        {{-- @livewire('message-alert-modal') --}}
        <span wire:click="showNewLegionary()"
            class="flex items-center justify-between px-3 py-1 text-white transition-colors duration-200 bg-green-500 border border-gray-500 rounded-md cursor-pointer hover:text-white dark:hover:bg-blue-500 hover:hover:bg-blue-500 whitespace-nowrap">
            <x-layout.svg.plus class="w-4 h-4 mr-0 lg:mr-2"></x-layout.svg.plus>
            Inserir novo legionário
        </span>
    </div>
    <div class="mt-5 space-y-4">
        <!-- Lista de itens arrastáveis -->
        <div>
            @foreach ($students as $item)
                <div class="mb-10 rounded-md cursor-pointer">
                    <h2 id="w-full text-center items-center">
                        <div type="button"
                            class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <div class="grid grid-cols-8 gap-2 mx-2 ">
                                <div class="pl-2 col-span-full sm:col-span-1">
                                    @if ($item?->student->id)
                                        @if ($item?->student->logo_path)
                                            <img src="{{ url('storage/student/' . $item?->student->id . '/' . $item?->student->logo_path) }}"
                                                class="mx-auto rounded-md">
                                        @else
                                            <x-application-logo width="h-12"></x-application-logo>
                                        @endif
                                    @else
                                        <x-application-logo width="h-12"></x-application-logo>
                                    @endif
                                </div>
                                <div class="col-span-full sm:col-span-6">
                                    <div class="grid grid-cols-3">
                                        <div class="col-span-2">
                                            <h1
                                                class="flex text-3xl font-bold {{ $item?->student->sex == 'F' ? 'text-red-500' : 'text-blue-500' }}">
                                                Al. {{ $item?->student->nick ?? $item?->oldSudents?->nick }}

                                            </h1>
                                            <h2>
                                                <span class="flex badge {{ $item->color }}">
                                                    Comportamento: {{ $item?->grau }}
                                                </span>
                                            </h2>

                                            <div class="max-w-xs">
                                                <p>
                                                    Nº. {{ $item?->student->number ?? $item?->oldSudents?->number }}
                                                </p>
                                                <p>
                                                    Série:
                                                    {{ $item->grade ?? 'sem turma' }}
                                                </p>
                                                <p>
                                                    Ano de entrada: {{ $item->year ?? 'Não informado' }}
                                                </p>
                                                <p>
                                                    Local de entrada: {{ $item->local ?? 'Não informado' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-span-1">
                                            <div class="max-w-xs">
                                                <p>
                                                    Incluído em: {{ $item->bi_date }}
                                                </p>
                                                <p>
                                                    Aditamento nº:
                                                    {{ $item->supplement_number }}
                                                </p>
                                                <p>
                                                    BI nº: {{ $item->bi_number }}
                                                </p>
                                            </div>
                                            @if ($item->active == 2)
                                                <div class="max-w-xs text-red-500">
                                                    <p>
                                                        Removido em: {{ $item->off_bi_date }}
                                                    </p>
                                                    <p>
                                                        Aditamento nº:
                                                        {{ $item->off_supplement_number }}
                                                    </p>
                                                    <p>
                                                        BI nº: {{ $item->off_bi_number }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="space-y-2 col-span-full sm:col-span-1">
                                    @if ($item->active == 2)
                                        <span class="btn btn-sm btn-info' }}">
                                            Removid{{ $item?->student->sex == 'F' ? 'a' : 'o' }}
                                        </span>
                                    @else
                                        <span wire:click="showEditLegionary({{ $item->id }})"
                                            class="btn btn-outline dark:btn-accent btn-sm }}">Editar
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="inline-block w-4 h-4 cursor-pointer stroke-current"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </span>
                                        <span wire:click="showModalRem({{ $item->id }})"
                                            class="btn btn-outline dark:btn-accent btn-sm }}">Remover
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                class="inline-block w-4 h-4 cursor-pointer stroke-current"
                                                viewBox="-14.68 0 122.88 122.88" version="1.1" id="Layer_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                style="enable-background:new 0 0 93.52 122.88" xml:space="preserve">
                                                <g>

                                                    <path
                                                        d="M0.46,0h13.33c0.25,0,0.46,0.21,0.46,0.46v44.21l0.29-0.3l0.08-0.08c3.18-3.48,5.78-6.26,9.1-8.14 c3.36-1.9,7.4-2.84,13.42-2.58l0.01,0c2.15,0.03,4.69,0.26,6.78,0.46c0.97,0.09,1.84,0.17,2.59,0.22 c10.16,0.67,14.92,6.01,18.62,10.17c1.63,1.84,3.05,3.42,4.57,4.15c0.72,0.34,1.85-0.14,3.14-0.68c0.78-0.33,1.6-0.68,2.47-0.91 c0.56-0.21,0.87-0.33,1.11-0.42c0.31-0.12,0.52-0.2,0.64-0.24l9.24-3.66l0.04-0.01c1.24-0.42,2.68-0.16,3.95,0.59 c0.89,0.53,1.71,1.31,2.3,2.26c0.59,0.96,0.95,2.1,0.94,3.36c-0.01,1.81-0.81,3.83-2.82,5.83c-0.09,0.09-0.19,0.15-0.3,0.18 l-9.26,3.67l0,0l-0.86,0.3c-4.96,1.76-8.55,3.03-14.84,1.48c-0.05-0.01-0.09-0.03-0.13-0.05c-4.4-1.71-6.68-4.08-8.9-6.4 l-0.33-0.34l-2.81,17.91c2.51,1.58,5.02,2.75,7.39,3.86c7.2,3.36,13.12,6.12,14.39,17.43c0.23,2.03,0.12,3.94,0.01,6.02l0,0.03 c-0.02,0.3-0.03,0.63-0.07,1.4l-0.88,21.91c-0.02,0.43-0.38,0.76-0.8,0.75l-11.13,0.03c-0.43,0-0.78-0.35-0.78-0.78 c0.12-7.55,0.34-15.46,0.73-23l0.06-1.02c0.06-1.18,0.12-2.27,0.06-3.29c-0.06-0.97-0.24-1.88-0.64-2.75l-0.11-0.23 c-0.45-0.98-0.86-1.88-1.48-2.17c-1.23-0.57-3.18-1.28-5.4-2.01c-2.54-0.84-5.38-1.68-7.88-2.39c-1.84,6.08-4.33,13.44-7,20.43 c-2.39,6.24-4.92,12.21-7.27,16.74c-0.14,0.28-0.44,0.44-0.73,0.42l-11.69,0.06c-0.43,0-0.78-0.34-0.78-0.77 c0-0.1,0.02-0.2,0.06-0.29l0,0c2.34-5.75,5.1-13.22,7.75-20.81c2.71-7.77,5.31-15.69,7.23-22.05c-1.14-1.4-2.23-2.96-2.97-4.68 c-0.82-1.9-1.22-3.96-0.81-6.17l4.01-21.66l-0.23-0.01c-1.39-0.06-2.55-0.11-3.88,0.47c-1.82,0.8-3.26,2.42-4.86,4.22 c-0.65,0.73-1.32,1.49-2.09,2.27l-0.05,0.05c-0.57,0.59-1.17,1.2-1.73,1.77l-7.08,7.15c-0.11,0.11-0.24,0.18-0.38,0.21v59.84 c0,0.25-0.21,0.46-0.46,0.46H0.46c-0.25,0-0.46-0.21-0.46-0.46V0.46C0,0.21,0.21,0,0.46,0L0.46,0z M47.34,6.41 c3.18-1.09,6.51-0.78,9.31,0.59c2.8,1.37,5.08,3.82,6.17,7c1.09,3.18,0.78,6.51-0.59,9.31c-1.37,2.8-3.82,5.08-7,6.17 c-3.18,1.09-6.51,0.78-9.31-0.59c-2.8-1.37-5.08-3.82-6.17-7c-1.09-3.18-0.78-6.51,0.59-9.31C41.71,9.78,44.15,7.5,47.34,6.41 L47.34,6.41z M3.07,39.71h3.08v14.75H3.07V39.71L3.07,39.71z" />

                                                </g>

                                            </svg>
                                        </span>
                                        <span wire:click="showModalDel({{ $item->id }})"
                                            class="btn btn-outline dark:btn-accent btn-sm }}">Excluir
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="inline-block w-4 h-4 cursor-pointer stroke-current"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </span>
                                    @endif


                                </div>

                            </div>
                        </div>
                    </h2>
                </div>
            @endforeach

        </div>
    </div>
    {{-- MODAL  --}}

    <x-dialog-modal wire:model="showModal" maxWidth="4xl">
        <x-slot name="title">Novo legionário </x-slot>
        <x-slot name="content">
            @if ($legionary)
                @livewire('student-corps.legion-of-honor-edit', ['legionary' => $legionary], key($legionary->id))
            @else
                @livewire('student-corps.legion-of-honor-insert')
            @endif

        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>
    {{-- MODAL DELETE --}}
    <x-confirmation-modal wire:model="showModalDelete">
        <x-slot name="title">
            Excluir Legionario
        </x-slot>
        <x-slot name="content">
            @if ($legionary)
                <h2 class="h2">Deseja realmente excluir
                    {{ $legionary?->student->sex == 'F' ? 'a legionária' : 'o legionário' }}
                    {{ $legionary?->student?->nick }} ({{ $legionary?->student?->number }})</h2>
                <p>Não será possível reverter esta ação!</p>
            @endif

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalDelete')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="removeStudents()" wire:loading.attr="disabled">
                Apagar registro
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
    {{-- MODAL REMOVER --}}
    <x-confirmation-modal wire:model="showModalRemove">
        <x-slot name="title">
            Excluir Legionario
        </x-slot>
        <x-slot name="content">
            @if ($legionary)
                <h2 class="h2">Deseja realmente remover
                    {{ $legionary?->student->sex == 'F' ? 'a legionária' : 'o legionário' }}
                    {{ $legionary?->student?->nick }} ({{ $legionary?->student?->number }})</h2>
                <p>Não será possível reverter esta ação!</p>
                <form>
                    <x-layout.tabs>
                        <x-slot name="nav">
                            <x-slot name="svg">
                                <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </x-slot>
                            <x-slot name="title">Legião de honra</x-slot>

                        </x-slot>
                        <x-slot name="content">
                            <div id="tab1" x-show="activeTab === '#tab1'" class="block">

                                <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                                    <div class="col-span-full ">

                                        @if ($legionary)
                                            <div role="alert" class="w-full col-span-1 shadow-xl alert ">
                                                <figure>
                                                    <img src="{{ url('storage/student/' . $legionary?->student->id . '/' . $legionary?->student->code_image . '_list.png') }}"
                                                        class="mx-auto rounded ">
                                                </figure>
                                                <div>
                                                    <h3 class="font-bold">Al. {{ $legionary?->student->nick }}</h3>
                                                    <div class="text-xs">T. {{ $legionary?->student->class }}</div>
                                                </div>
                                            </div>
                                            <div
                                                class="grid grid-cols-4 col-span-1 gap-2 mb-1 sm:grid-cols-4 sm:gap-3 sm:mb-5">
                                                <div class="col-span-full sm:col-span-1">
                                                    <label
                                                        class="block text-sm font-medium text-gray-900 dark:text-white"
                                                        for="title">
                                                        *Nota p/Bol Nr</label>
                                                    <input type="number" wire:model="off_supplement_number"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    @error('off_supplement_number')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-span-full sm:col-span-1">
                                                    <label
                                                        class="block text-sm font-medium text-gray-900 dark:text-white"
                                                        for="title">
                                                        *BI Nr</label>
                                                    <input type="number" wire:model="off_bi_number"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    @error('off_bi_number')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-span-full sm:col-span-2">
                                                    <label
                                                        class="block text-sm font-medium text-gray-900 dark:text-white"
                                                        for="title">
                                                        *Data publicação</label>
                                                    <input type="date" wire:model="off_bi_date"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    @error('off_bi_date')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>


                                                <div class="col-span-full sm:col-span-full ">
                                                    <label
                                                        class="block text-sm font-medium text-gray-900 dark:text-white"
                                                        for="title">
                                                        Relato
                                                    </label>
                                                    <textarea wire:model="off_bi_text" rows="10"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>
                                                    @error('text')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </x-slot>
                    </x-layout.tabs>
                </form>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalDelete')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="removeStudents()" wire:loading.attr="disabled">
                Apagar registro
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
    @section('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('openPdfLegion', ({
                    pdfPath
                }) => {
                    window.open(pdfPath, '_blank');
                })
            })
        </script>
    @endsection

</div>
