<div>

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
    <x-layout.table>
        <x-slot name="head">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr scope="col" class="text-gray-500 dark:text-gray-400">

                    <th scope="col" wire:click="addSort('title')"
                        class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                        <x-layout.table-sort-button :sorts='$sorts' field="title">
                            Título
                        </x-layout.table-sort-button>
                    </th>
                    <th scope="col"
                        class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                        Modalidade
                    </th>
                    <th scope="col"
                        class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                        Alunos
                    </th>
                    <th scope="col"
                        class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                        Lista em pdf
                    </th>
                    <th scope="col"
                        class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                        Opções
                    </th>
                </tr>
            </thead>
        </x-slot>
        <x-slot name="body">
            <tbody class="p-0 m-0 bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                @foreach ($dataTable as $item)
                    <tr>
                        <td class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                            {{ $item->title }}
                        </td>
                        <td class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            {{ $item->modality->title }}
                        </td>
                        <td class="items-center px-4 py-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                            <a href="{{ route('students-activities', $item->id) }}"
                                class="flex justify-center px-3 py-2 mx-auto transition-colors duration-200 hover:text-gray-400 whitespace-nowrap">
                                <svg class="w-6 h-6" viewBox="0 -1.5 20.412 20.412" xmlns="http://www.w3.org/2000/svg">
                                    <g id="check-lists" transform="translate(-1.588 -2.588)">
                                        <path id="primary" d="M7,4,4.33,7,3,5.5" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <path id="primary-2" data-name="primary" d="M3,11.5,4.33,13,7,10" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" />
                                        <path id="primary-3" data-name="primary" d="M3,17.5,4.33,19,7,16" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" />
                                        <path id="primary-4" data-name="primary" d="M11,6H21M11,12H21M11,18H21"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </a>
                        </td>
                        <td class="items-center px-4 py-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                            <div class="flex p-0 tooltip tooltip-top" wire:click='list({{ $item->id }})'
                                data-tip="Alunos" wire:ignore>
                                <button
                                    class="px-3 py-2 text-gray-800 transition-colors duration-200 rounded-sm dark:text-white whitespace-nowrap">
                                    <x-layout.svg.pdf></x-layout.svg.pdf>
                                </button>
                            </div>
                        </td>

                        <td class="w-1/6 px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            <x-layout.table-options id='{{ $item->id }}' active='{{ $item->status }}'>
                            </x-layout.table-options>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-slot>

        <x-slot name="link">
            {{ $dataTable->links() }}
        </x-slot>
    </x-layout.table>

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
            @if ($extra_activity)
                @livewire('extracurricular.extra-activities.extra-activity-form', ['extra_activity' => $extra_activity], key($extra_activity->id))
            @else
                @livewire('extracurricular.extra-activities.extra-activity-form')
            @endif
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>
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
