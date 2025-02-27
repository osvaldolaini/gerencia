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
                    <th scope="col" wire:click="addSort('name')"
                        class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                        <x-layout.table-sort-button :sorts='$sorts' field="name">
                            Nome
                        </x-layout.table-sort-button>
                    </th>
                    <th scope="col" wire:click="addSort('nick')"
                        class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                        <x-layout.table-sort-button :sorts='$sorts' field="nick">
                            Sigla
                        </x-layout.table-sort-button>
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
                            {{ $item->name }}
                        </td>
                        <td class="w-2/5 px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            {{ $item->nick }}
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
            @if ($companies)
                @livewire('settings.companies.company-form', ['companies' => $companies], key($companies->id))
            @else
                @livewire('settings.companies.company-form')
            @endif
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>


</div>
