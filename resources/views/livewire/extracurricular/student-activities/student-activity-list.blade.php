<div>
    <div class="overflow-x-auto dark:text-white">
        <table class="table dark:text-white">
            <!-- head -->
            <thead>
                <tr class="dark:text-white">
                    <th>Atividade</th>
                    <th>GIP</th>
                    <th>PONTO EXTRA</th>
                    <th>Excluir</th>
                    <th>Inserido/ editado por</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $extra)
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
</div>
