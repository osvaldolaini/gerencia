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
                    <th>ATIVIDADES</th>
                    <th>GIP</th>
                    {{-- <th>BÔNUS</th> --}}
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
                            <x-layout.table-toggle-active id='{{ $extra->id }}'
                                active='{{ $extra->gip }}'></x-layout.table-toggle-active>
                        </td>
                        {{-- <td>
                            @if ($extra->bonus == 1)
                                <div class="p-0 tooltip tooltip-top " data-tip="Desativar">
                                    <div class="mr-1 md:hidden">
                                        DESATIVAR
                                    </div>
                                    <button wire:click="buttonBonus({{ $extra->id }})"
                                        class="p-1 text-green-500 transition-colors duration-200 whitespace-nowrap">
                                        <svg class="w-5 h-5 md:w-8 md:h-8 " viewBox="0 -6 32 32" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd" sketch:type="MSPage">
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
                                </div>
                            @else
                                <div class="p-0 tooltip tooltip-top " data-tip="Ativar">
                                    <div class="mr-1 md:hidden">
                                        ATIVAR
                                    </div>
                                    <button wire:click="buttonBonus({{ $extra->id }})"
                                        class="p-1 text-red-500 transition-colors duration-200 whitespace-nowrap">
                                        <svg class="w-6 h-6 md:w-8 md:h-8" viewBox="0 -6 32 32" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd" sketch:type="MSPage">
                                                <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                    transform="translate(-204.000000, -365.000000)" fill="currentColor">
                                                    <path
                                                        d="M214,379 C211.791,379 210,377.209 210,375 C210,372.791 211.791,371 214,371 C216.209,371 218,372.791 218,375 C218,377.209 216.209,379 214,379 L214,379 Z M214,369 C210.687,369 208,371.687 208,375 C208,378.313 210.687,381 214,381 C217.314,381 220,378.313 220,375 C220,371.687 217.314,369 214,369 L214,369 Z M226,383 L214,383 C209.582,383 206,379.418 206,375 C206,370.582 209.582,367 214,367 L226,367 C230.418,367 234,370.582 234,375 C234,379.418 230.418,383 226,383 L226,383 Z M226,365 L214,365 C208.477,365 204,369.478 204,375 C204,380.522 208.477,385 214,385 L226,385 C231.523,385 236,380.522 236,375 C236,369.478 231.523,365 226,365 L226,365 Z"
                                                        id="toggle-on" sketch:type="MSShapeGroup">

                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                            @endif

                        </td> --}}
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
