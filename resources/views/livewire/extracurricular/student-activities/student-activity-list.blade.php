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
                        <th>
                            {{ $extra->created_by }}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- MODAL SEND MAIL --}}
    <x-confirmation-modal wire:model="showModalConfirm">
        <x-slot name="title">
            Enviar ficha individual
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja realmente enviar a ficha do aluno?</h2>
            <p>A ficha será enviada para:</p>
            <ul>


            </ul>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalConfirm')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="sentEmail()" wire:loading.attr="disabled">
                Enviar
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
