<div>
    <div class="flex justify-center mb-5">
        {{-- @livewire('message-alert-modal') --}}
        <span wire:click="showNewActivity()"
            class="flex items-center justify-between px-3 py-1 text-white transition-colors duration-200 bg-green-500 border border-gray-500 rounded-md cursor-pointer hover:text-white dark:hover:bg-blue-500 hover:hover:bg-blue-500 whitespace-nowrap">
            <x-layout.svg.plus class="w-4 h-4 mr-0 lg:mr-2"></x-layout.svg.plus>
            Inserir atividade extra
        </span>
    </div>
    <div class="overflow-x-auto dark:text-white">
        <table class="table dark:text-white">
            <!-- head -->
            <thead>
                <tr class="dark:text-white">
                    <th>ATIVIDADE</th>
                    <th>GIP</th>
                    <th>PONTO EXTRA</th>
                    <th>APAGAR</th>
                    <th>INSERIDO / EDITADO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studentActivities as $extra)
                    <tr>
                        <td>
                            {{ $extra?->activity?->title }}
                        </td>
                        <td>
                            {{ $extra->gip }}
                        </td>
                        <td>

                        </td>
                        <td>
                            <div class="p-0 tooltip tooltip-top" data-tip="Apagar">
                                <button wire:click="showModalDelete({{ $extra->id }})"
                                    class="px-3 py-2 -ml-1 transition-colors duration-200 dark:hover:bg-red-500 hover:hover:bg-red-500 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <th>
                            {{ $extra->created_by }}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
    <x-dialog-modal wire:model="showModalForm" maxWidth="4xl">
        <x-slot name="title">Inserir atividade extra </x-slot>
        <x-slot name="content">
            <form>
                <div role="tabpanel"
                    class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                    <div class="grid grid-cols-4 gap-2 mb-1 ">

                        <div class="col-span-full sm:col-span-3 ">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Atividade
                            </label>
                            <select wire:model="extra_activities_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="">Selecione...</option>
                                @foreach ($activities as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('extra_activities_id')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-full sm:col-span-1">
                            <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                Ganhar GIP
                            </label>
                            <x-layout.toggle-true-false id="gip"
                                active="{{ $gip }}"></x-layout.toggle-true-false>
                            @error('gip')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>

        </x-slot>
        <x-slot name="footer">
            <div class="px-4 text-right">
                <button type="submit" wire:click="addActivity"
                    class="text-white
                                bg-green-700 hover:bg-green-800
                                focus:ring-4 focus:outline-none focus:ring-green-300
                                font-medium rounded-lg text-sm px-5 py-2.5
                                text-center dark:bg-green-600 dark:hover:bg-green-700
                                dark:focus:ring-green-800">
                    Salvar e sair
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
