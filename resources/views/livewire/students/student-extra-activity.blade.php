<div>
    <div class="flex justify-center mb-5">
        {{-- @livewire('message-alert-modal') --}}
        <span wire:click="showConfirm()"
            class="flex items-center justify-between px-3 py-1 text-white transition-colors duration-200 bg-green-500 border border-gray-500 rounded-md cursor-pointer hover:text-white dark:hover:bg-blue-500 hover:hover:bg-blue-500 whitespace-nowrap">
            Enviar ficha indivídual <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 "
                version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 512 512" xml:space="preserve">
                <g>
                    <g>
                        <path d="M174.545,302.545H81.455c-6.982,0-11.636,4.655-11.636,11.636s4.655,11.636,11.636,11.636h93.091
                   c6.982,0,11.636-4.655,11.636-11.636S181.527,302.545,174.545,302.545z" />
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M139.636,244.364H46.545c-6.982,0-11.636,4.655-11.636,11.636s4.655,11.636,11.636,11.636h93.091
                   c6.982,0,11.636-4.655,11.636-11.636S146.618,244.364,139.636,244.364z" />
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M104.727,186.182H11.636C4.655,186.182,0,190.836,0,197.818s4.655,11.636,11.636,11.636h93.091
                   c6.982,0,11.636-4.655,11.636-11.636S111.709,186.182,104.727,186.182z" />
                    </g>
                </g>
                <g>
                    <g>
                        <path d="M463.127,155.927c-3.491-4.655-11.636-5.818-16.291-2.327l-123.345,94.255c-12.8,9.309-30.255,9.309-43.055,0
                   L157.091,153.6c-4.655-3.491-12.8-3.491-16.291,2.327c-3.491,4.655-3.491,12.8,2.327,16.291l124.509,94.255
                   c10.473,8.145,23.273,11.636,34.909,11.636s25.6-3.491,34.909-11.636L460.8,172.218
                   C465.455,168.727,466.618,160.582,463.127,155.927z" />
                    </g>
                </g>
                <g>
                    <path d="M477.091,104.727H104.727c-6.982,0-11.636,4.655-11.636,11.636S97.745,128,104.727,128h372.364
                   c6.982,0,11.636,4.655,11.636,11.636v232.727c0,6.982-4.655,11.636-11.636,11.636H104.727c-6.982,0-11.636,4.655-11.636,11.636
                   c0,6.982,4.655,11.636,11.636,11.636h372.364c19.782,0,34.909-15.127,34.909-34.909V139.636
                   C512,119.855,496.873,104.727,477.091,104.727z" />
                </g>
                </g>
                <g>
                    <g>
                        <path
                            d="M461.964,340.945l-69.818-69.818c-4.655-4.655-11.636-4.655-16.291,0s-4.655,11.636,0,16.291l69.818,69.818
                   c2.327,2.327,5.818,3.491,8.145,3.491s5.818-1.164,8.146-3.491C466.618,352.582,466.618,345.6,461.964,340.945z" />
                    </g>
                </g>
            </svg>
        </span>
        <div class="overflow-x-auto dark:text-white">
            <table class="table dark:text-white">
                <!-- head -->
                <thead>
                    <tr class="dark:text-white">
                        <th>Atividade</th>
                        <th>GIP</th>
                        <th>PONTO EXTRA</th>
                        <th>APAGAR</th>
                        <th>INSERIDO / EDITADO</th>
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
