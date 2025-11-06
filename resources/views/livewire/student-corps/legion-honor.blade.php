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
                    <x-layout.svg.pdf></x-layout.svg.pdf>
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
                                            class="btn btn-sm btn-success }}">Editar
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
                                            class="btn btn-sm btn-error }}">Remover da Legião

                                        </span>
                                        <span wire:click="showModalDel({{ $item->id }})"
                                            class="btn btn-sm btn-info }}">Excluir
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
            <h2 class="h2">Deseja realmente excluir
                {{ $legionary?->student->sex == 'F' ? 'a legionária' : 'o legionário' }}
                {{ $legionary?->student?->nick }} ({{ $legionary?->student?->number }})</h2>
            <p>Não será possível reverter esta ação!</p>
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
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                                    for="title">
                                                    *Nota p/Bol Nr</label>
                                                <input type="number" wire:model="off_supplement_number"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                @error('off_supplement_number')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-span-full sm:col-span-1">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                                    for="title">
                                                    *BI Nr</label>
                                                <input type="number" wire:model="off_bi_number"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                @error('off_bi_number')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-span-full sm:col-span-2">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                                    for="title">
                                                    *Data publicação</label>
                                                <input type="date" wire:model="off_bi_date"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                @error('off_bi_date')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="col-span-full sm:col-span-full ">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white"
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
                Livewire.on('openPdfInNewTabClasses', ({
                    pdfPath
                }) => {
                    window.open(pdfPath, '_blank');
                })
            })
        </script>
    @endsection

</div>
