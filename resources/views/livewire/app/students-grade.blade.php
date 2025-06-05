<div>
    <div class="flex justify-center font-medium duration-200">
        <div class="flex space-x-1">
            <div class="p-0 tooltip tooltip-top" data-tip="Ver alunos" wire:ignore>
                <span wire:click='seeStudents()'
                    class="flex px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </span>
            </div>
        </div>
    </div>
    {{-- MODAL READ --}}
    <x-dialog-modal wire:model="showModalView">
        <x-slot name="title">Alunos do {{ $title ? $title : '' }} {{ $search }}</x-slot>
        <x-slot name="content">
            <div class="container flex flex-col items-center justify-center w-full mx-auto">
                <input type="text" placeholder="Pesquisar" wire:model.live="search"
                    class="w-full py-3 pl-10 mb-5 text-sm text-gray-900 border-blue-500 rounded-2xl focus:ring-primary-500 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500"
                    autofocus />
                <ul class="flex flex-col w-full">
                    @forelse ($list as $item)
                        <li class="flex flex-row w-full mb-2 border-gray-400 cursor-pointer"
                            @click="activeTab = '#tab6'" wire:click='seeStudentProfile({{ $item->students->id }})'>
                            <div
                                class="flex items-center flex-1 p-4 bg-white border rounded-md shadow cursor-pointer select-none dark:bg-gray-800">
                                <div class="flex flex-col items-center justify-center w-10 h-10 mr-4">
                                    <span class="relative block">
                                        @if ($item->students->logo_path)
                                            <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_big.png') }}"
                                                class="object-cover w-10 h-10 mx-auto rounded-full ">
                                        @else
                                            <x-application-logo width="h-12"></x-application-logo>
                                        @endif
                                    </span>
                                </div>
                                <div class="flex-1 pl-1 md:mr-16">
                                    <div class="font-medium dark:text-white">
                                        Al {{ $item->students->nick }} - <span class="badge badge-success">
                                            {{ $item->students->people_class }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-200">
                                        {{ $item->students->name }}
                                    </div>
                                </div>
                            </div>
                        </li>

                    @empty
                        <p>Nenhum aluno na turma</p>
                    @endforelse

                </ul>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalView')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
