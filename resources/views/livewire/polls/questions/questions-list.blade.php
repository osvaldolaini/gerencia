<div x-data="dragAndDrop()">

    <x-layout.tabs>
        <x-slot name="nav">
            <x-layout.tabs-nav tab="tab1">
                <x-slot name="svg">
                    <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </x-slot>
                <x-slot name="title">{{ $breadcrumb }}</x-slot>
            </x-layout.tabs-nav>
            <x-layout.button-back route="{{ $back }}"></x-layout.button-back>

        </x-slot>
        <x-slot name="content">
            <div role="tabpanel"
                class="p-6 mt-4 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                <div class="flex justify-center mb-5">
                    <span wire:click="addQuestion()"
                        class="flex justify-between px-3 py-1 text-white transition-colors duration-200 bg-gray-700 border border-gray-500 rounded-md cursor-pointer hover:text-white dark:hover:bg-blue-500 hover:hover:bg-blue-500 whitespace-nowrap">
                        Adicionar questão <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 "
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 12H20M12 4V20" stroke="CurrentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
                @if ($dataTable)
                    <div class="space-y-4">
                        <!-- Lista de itens arrastáveis -->
                        <div x-data="{ items: @entangle('dataTable') }">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="mb-10 rounded-md cursor-pointer"
                                    :draggable="{{ $search ? 'false' : 'true' }}" @dragstart="startDragging(index)"
                                    @dragover.prevent @drop="drop(index)">
                                    <h2 id="w-full text-center items-center">
                                        <div type="button"
                                            class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                                            <div class="grid grid-cols-8 gap-2 mx-2 ">
                                                <div class="flex justify-start pl-2 col-span-full ">
                                                    <div class="p-0 tooltip tooltip-top" data-tip="Arraste e solte">
                                                        <button x-show="!('{{ $search }}' !== '')"
                                                            class="btn dark:btn-accent btn-sm">
                                                            Ordenar
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 "
                                                                viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M4 7L7 7M20 7L11 7" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round" />
                                                                <path d="M20 17H17M4 17L13 17" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round" />
                                                                <path d="M4 12H7L20 12" stroke="currentColor"
                                                                    stroke-width="1.5" stroke-linecap="round" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="pl-2 col-span-full sm:col-span-5 ">
                                                    <div class="space-x-2">
                                                        <span class="text-sm font-bold badge badge-primary"
                                                            x-text="item.type_label"></span>
                                                        <span class="text-sm font-bold badge badge-primary"
                                                            x-text="item.required_label"></span>
                                                        <span class="text-sm font-bold badge badge-primary"
                                                            x-text="item.order_label"></span>
                                                    </div>

                                                    <h1 class="text-xl font-bold " x-text="item.description"></h1>
                                                </div>
                                                <div class="col-span-full sm:col-span-3">
                                                    <div
                                                        class="justify-start block space-x-2 space-y-2 font-medium duration-200 ">
                                                        @if (in_array('update', auth()->user()->jsonActivities))
                                                            <button @click="$wire.showUpdate(item.id)"
                                                                x-show="item.active == 1"
                                                                class="btn btn-outline dark:btn-accent btn-sm">
                                                                Editar
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 "
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        @endif

                                                        @if (in_array('delete', auth()->user()->jsonActivities))
                                                            <button @click="$wire.showModalDelete(item.id)"
                                                                x-show="item.active == 1"
                                                                class="btn btn-outline dark:btn-error btn-sm">
                                                                Apagar
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                                <!-- SVG de Apagar -->
                                                            </button>
                                                        @endif
                                                        @if (in_array('active', auth()->user()->jsonActivities))
                                                            <button x-show="item.active == 0"
                                                                @click="$wire.buttonActive(item.id)"
                                                                class="btn btn-outline dark:btn-accent btn-sm">
                                                                Ativar
                                                                <svg class="h-6 w-6 " viewBox="0 -6 32 32"
                                                                    version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                                                                    <g id="Page-1" stroke="none" stroke-width="1"
                                                                        fill="none" fill-rule="evenodd"
                                                                        sketch:type="MSPage">
                                                                        <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                                            transform="translate(-204.000000, -365.000000)"
                                                                            fill="currentColor">
                                                                            <path
                                                                                d="M214,379 C211.791,379 210,377.209 210,375 C210,372.791 211.791,371 214,371 C216.209,371 218,372.791 218,375 C218,377.209 216.209,379 214,379 L214,379 Z M214,369 C210.687,369 208,371.687 208,375 C208,378.313 210.687,381 214,381 C217.314,381 220,378.313 220,375 C220,371.687 217.314,369 214,369 L214,369 Z M226,383 L214,383 C209.582,383 206,379.418 206,375 C206,370.582 209.582,367 214,367 L226,367 C230.418,367 234,370.582 234,375 C234,379.418 230.418,383 226,383 L226,383 Z M226,365 L214,365 C208.477,365 204,369.478 204,375 C204,380.522 208.477,385 214,385 L226,385 C231.523,385 236,380.522 236,375 C236,369.478 231.523,365 226,365 L226,365 Z"
                                                                                id="toggle-on"
                                                                                sketch:type="MSShapeGroup">

                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                                <!-- SVG de Apagar -->
                                                            </button>
                                                        @endif

                                                        <button @click="$wire.showOptions(item.id)"
                                                            x-show="item.type != 'text' && item.active == 1"
                                                            class="btn btn-outline dark:btn-accent btn-sm">
                                                            Alternativas
                                                            <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </template>
                        </div>

                    </div>
                @endif

            </div>


        </x-slot>
    </x-layout.tabs>

    {{-- MODAL QUESTIONS --}}
    <x-dialog-modal wire:model="showModalForm" maxWidth="4xl">
        <x-slot name="title">{{ $breadcrumb }} </x-slot>
        <x-slot name="content">
            @if ($poll_question)
                @livewire('polls.questions.question-form', ['poll_question' => $poll_question], key($poll_question->id))
            @else
                @livewire('polls.questions.question-form')
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalForm')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    {{-- MODAL FORM --}}
    <x-dialog-modal wire:model="showModalOptions" maxWidth="4xl">
        <x-slot name="title">
            <strong>
                @if ($option)
                    {{ $breadcrumb_number }}
                @endif
            </strong>
            <div class="text-sm">
                @if ($option)
                    {{ $breadcrumb_question }}
                @endif
            </div>

        </x-slot>
        <x-slot name="content">
            @if ($option)
                @livewire('polls.questions.options.option-list', ['question' => $option], key($option->id))
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalOptions')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>


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
    <script>
        function dragAndDrop() {
            return {
                items: @entangle('dataTable'),
                draggedIndex: null,

                startDragging(index) {
                    this.draggedIndex = index;
                },

                drop(targetIndex) {
                    const draggedItem = this.items[this.draggedIndex];
                    console.log(draggedItem);
                    // Remove o item arrastado e insere na nova posição
                    this.items.splice(this.draggedIndex, 1);
                    this.items.splice(targetIndex, 0, draggedItem);
                    // let novaOrdem = this.draggedIndex + 1;

                    this.draggedIndex = null;

                    // Salva a nova ordem automaticamente
                    Livewire.dispatch('atualizarOrdem', [this.items]);
                }
            };
        }
    </script>
</div>
