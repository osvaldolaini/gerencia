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
            @if ($school_grade_id)
                <div role="tabpanel"
                    class="p-6 mt-4 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                    <div class="flex justify-center mb-5">
                        <span wire:click="addSchoolClass()"
                            class="flex justify-between px-3 py-1 text-white transition-colors duration-200 bg-gray-700 border border-gray-500 rounded-md cursor-pointer hover:text-white dark:hover:bg-blue-500 hover:hover:bg-blue-500 whitespace-nowrap">
                            Adicionar turma <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 "
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 12H20M12 4V20" stroke="CurrentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
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
                                                <div class="pl-2 col-span-full sm:col-span-5">
                                                    <h1 class="text-3xl font-bold" x-text="item.title"></h1>
                                                    <div class="max-w-xs">
                                                        <p x-text="item.number"></p>
                                                        <p x-text="item.obs"></p>
                                                    </div>
                                                </div>
                                                <div class="col-span-full sm:col-span-3">
                                                    <div
                                                        class="justify-start block space-x-2 space-y-2 font-medium duration-200 ">
                                                        @if (in_array('update', auth()->user()->jsonActivities))
                                                            <button @click="$wire.showUpdate(item.id)"
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
                                                            <button x-show="item.active === 1"
                                                                @click="$wire.showModalDelete(item.id)"
                                                                class="btn btn-outline dark:btn-accent btn-sm">
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
                                                            <button x-show="item.active === 1"
                                                                @click="$wire.showModalDelete(item.id)"
                                                                class="btn btn-outline dark:btn-accent btn-sm">
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

                                                        <button @click="$wire.addStudent(item.id)"
                                                            class="btn btn-outline dark:btn-accent btn-sm">
                                                            Montar turma
                                                            <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </button>
                                                        <button @click="$wire.showStudents(item.id)"
                                                            class="btn btn-outline dark:btn-accent btn-sm">
                                                            Ver alunos
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 "
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                                </path>
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
                </div>
            @else
                @foreach ($companies as $company)
                    <div class="flex flex-wrap sm:justify-center">
                        <div class="w-full">
                            <div class="w-full py-4 space-x-4">
                                <small
                                    class="ml-2 space-x-1 text-5xl font-extrabold text-gray-500 col-span-full dark:text-gray-100">
                                    {{ $company->name }}
                                </small>
                                <h1
                                    class="grid grid-cols-2 space-x-1 text-3xl font-extrabold text-center sm:grid-cols-4 dark:text-gray-100">
                                    @foreach ($company->grade as $item)
                                        <div class="flex items-center justify-center col-span-1 mt-5 ">
                                            <div wire:click="select_grade({{ $item->id }})"
                                                class="items-center w-56 mr-4 shadow-xl cursor-pointer h-60 drop-shadow-xl rounded-box hover:bg-gray-900 hover:text-gray-100">
                                                <div class="items-center text-center card-body ">
                                                    <h2 class="card-title">
                                                        @if ($item->code_image)
                                                            <picture>
                                                                <source
                                                                    srcset="{{ url('storage/schoolGrades/' . $item->id . '/' . $item->code_image . '_list.png') }}" />
                                                                <source
                                                                    srcset="{{ url('storage/schoolGrades/' . $item->id . '/' . $item->code_image . '_list.webp') }}" />
                                                                <img src="{{ url('storage/schoolGrades/' . $item->id . '/' . $item->code_image . '._list.png') }}"
                                                                    alt="{{ $item->name }}">
                                                            </picture>
                                                        @else
                                                            <x-application-logo width="h-12"></x-application-logo>
                                                        @endif

                                                        <span>

                                                            {{ $item->name }}
                                                        </span>
                                                    </h2>
                                                </div>
                                                <ul class="text-sm text-center">
                                                    @forelse ($item->classes($school_classes_year_id) as $class)
                                                        <li>{{ $class->title }}</li>
                                                    @empty
                                                        <li>Nenhuma turma cadastradas</li>
                                                    @endforelse
                                                </ul>

                                            </div>
                                        </div>
                                    @endforeach
                                </h1>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif


        </x-slot>
    </x-layout.tabs>

    {{-- MODAL RECEIVABLE --}}
    <x-confirmation-modal wire:model="showModalStudent">
        <x-slot name="title">
            Alunos da turma {{ $class }}
        </x-slot>
        <x-slot name="content">
            @if ($list_students)
                <div class="grid grid-cols-3 gap-4 mt-4">
                    @foreach ($list_students as $item)
                        <div class="p-2 text-center bg-gray-100 rounded-md">
                            <span class="{{ $item->students->sex == 'M' ? 'text-blue-500' : 'text-red-500' }}">
                                {{ $item->students->student_title }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalStudent')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
        </x-slot>
    </x-confirmation-modal>

    {{-- MODAL FORM --}}

    <x-dialog-modal wire:model="showModalForm" maxWidth="4xl">
        <x-slot name="title">{{ $breadcrumb }} </x-slot>
        <x-slot name="content">
            @if ($school_classes)
                @livewire('settings.school-classes.school-classes-form', ['school_classes' => $school_classes], key($school_classes->id))
            @else
                @livewire('settings.school-classes.school-classes-form')
            @endif
        </x-slot>
        <x-slot name="footer">

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
