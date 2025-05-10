<div>

    <h2 class="mb-4 text-xl font-bold dark:text-white">Espelho de classe da {{ $breadcrumb }}</h2>
    <div wire:ignore class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
        @livewire('settings.school-classroom-seats.school-classes-infos', ['school_classes' => $school_classes], key($school_classes->id))
    </div>

    <div class="p-4">
        <div class="w-full p-2 mb-5 text-center text-white bg-blue-800 border-2 border-blue-300 rounded-md">Quadro</div>
        <div class="flex items-start gap-4">
            {{-- Porta à esquerda --}}
            @if ($door_side === 'left')
                <div class="flex flex-col items-center w-12">
                    <div class="px-2 py-1 text-xs text-white bg-yellow-400 rounded shadow">
                        <svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                        </svg>
                    </div>
                </div>
            @endif
            <div class="grid w-full gap-2"
                style="grid-template-columns: repeat({{ $columns }}, minmax(80px, 1fr)); direction: {{ $door_side === 'right' ? 'rtl' : 'ltr' }};">

                @for ($r = 1; $r <= $rows; $r++)
                    @for ($c = 1; $c <= $columns; $c++)
                        @php
                            $seat = $seats->first(fn($s) => $s->row === $r && $s->column === $c);
                        @endphp

                        <div wire:click="openModalSearch({{ $r }}, {{ $c }})"
                            class="border rounded p-2 h-20 flex items-center justify-center text-center cursor-pointer
                                {{ $seat?->students ? 'bg-green-200 hover:bg-green-300' : 'bg-gray-200 hover:bg-gray-300' }}">
                            <div class="text-sm">
                                {{ $seat?->students?->nick ?? 'Vazio' }}
                            </div>
                        </div>
                    @endfor
                @endfor
            </div>
            {{-- Porta à direita --}}
            @if ($door_side === 'right')
                <div class="flex flex-col items-center w-12">
                    <div class="px-2 py-1 text-xs text-white bg-yellow-400 rounded shadow">
                        <svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                        </svg>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <x-dialog-modal wire:model="modalSearch" class="mt-0">
        <x-slot name="title">Pesquisar </x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 gap-4 mb-1">
                <fieldset class="w-full col-span-1 space-y-1 dark:text-gray-100">
                    <label for="Search" class="hidden">Pesquisar </label>
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                            <button type="button" title="search" class="p-1 focus:outline-none focus:ring">
                                <svg fill="currentColor" viewBox="0 0 512 512" class="w-4 h-4 dark:text-gray-100">
                                    <path
                                        d="M479.6,399.716l-81.084-81.084-62.368-25.767A175.014,175.014,0,0,0,368,192c0-97.047-78.953-176-176-176S16,94.953,16,192,94.953,368,192,368a175.034,175.034,0,0,0,101.619-32.377l25.7,62.2L400.4,478.911a56,56,0,1,0,79.2-79.195ZM48,192c0-79.4,64.6-144,144-144s144,64.6,144,144S271.4,336,192,336,48,271.4,48,192ZM456.971,456.284a24.028,24.028,0,0,1-33.942,0l-76.572-76.572-23.894-57.835L380.4,345.771l76.573,76.572A24.028,24.028,0,0,1,456.971,456.284Z">
                                    </path>
                                </svg>
                            </button>
                        </span>
                        <input type="text" placeholder="Pesquisar" wire:model.live="inputSearch"
                            class="w-full py-3 pl-10 text-sm text-gray-900 border-blue-500 rounded-2xl focus:ring-primary-500 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500"
                            autofocus />
                    </div>
                </fieldset>
                @isset($results)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <tbody>
                                @if ($results)
                                    @foreach ($results as $item)
                                        <tr class="hover:bg-gray-200 dark:hover:bg-gray-500">
                                            <td>
                                                <div class="flex items-center gap-3 cursor-pointer "
                                                    wire:click="selectPeople({{ $item->id }})">
                                                    <div class="avatar">
                                                        <div class="h-24 w-18">
                                                            @if ($item->code_image)
                                                                <div
                                                                    class="fixed h-24 border-2 border-gray-300 rounded-lg shadow-lg p-1bg-white w-18">
                                                                    <!-- Avatar pequeno -->
                                                                    <img src="{{ url('storage/student/' . $item->id . '/' . $item->code_image . '_list.png') }}"
                                                                        alt="Foto grande" class="w-full h-full rounded-lg">
                                                                </div>
                                                            @else
                                                                <div class="avatar">
                                                                    <div class="relative w-8 rounded-full cursor-pointer">
                                                                        <x-application-logo
                                                                            width="h-12"></x-application-logo>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold">
                                                            {{ $item->setTitle() }}
                                                        </div>
                                                        <div class="text-sm opacity-50">Al. {{ $item->student_title }}
                                                        </div>
                                                    </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                @endisset

            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('modalSearch')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
