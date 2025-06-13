<div>
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
            <a href="{{ route('school-classes-year-list', $year) }}"
                class="flex items-center px-3 py-2 text-sm font-medium text-gray-500 transition duration-75 border-transparent hover:text-gray-600 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-300">
                <span class="px-1 transition duration-75 text-primary-600 dark:text-primary-400">
                    Voltar
                </span>
                <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2050 2050" data-name="Layer 3" id="Layer_3"
                    xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <style></style>
                    </defs>
                    <title />
                    <path fill="currentColor"
                        d="M1582.2,1488.7a44.9,44.9,0,0,1-36.4-18.5l-75.7-103.9A431.7,431.7,0,0,0,1121.4,1189h-60.1v64c0,59.8-33.5,112.9-87.5,138.6a152.1,152.1,0,0,1-162.7-19.4l-331.5-269a153.5,153.5,0,0,1,0-238.4l331.5-269a152.1,152.1,0,0,1,162.7-19.4c54,25.7,87.5,78.8,87.5,138.6v98.3l161,19.6a460.9,460.9,0,0,1,404.9,457.4v153.4a45,45,0,0,1-45,45Z" />
                </svg>
            </a>


        </x-slot>
        <x-slot name="content">
            <div class="flex justify-end w-full space-x-1">
                @foreach ($otherClasses as $item)
                    <a href="{{ route('school-classes-classroom-seats', $item->id) }}"
                        class='btn {{ $item->id == $school_classes_id ? ' btn-info' : 'btn-outline btn-info' }}'>
                        <span>
                            {{ $item->title }}
                        </span>
                    </a>
                @endforeach
            </div>

        </x-slot>
    </x-layout.tabs>

    <div wire:ignore class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
        @livewire('settings.school-classroom-seats.school-classes-infos', ['school_classes' => $school_classes], key($school_classes->id))
    </div>

    <div class="p-4">
        <div class="flex items-start gap-4">
            @if ($door_side === 'top_left')
                <div class="flex flex-col items-center w-12">
                    <div class="px-2 py-1 text-xs text-white bg-yellow-400 rounded shadow">
                        <svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                        </svg>
                    </div>
                </div>
            @endif
            <div class="w-full p-2 mb-5 text-center text-white bg-blue-800 border-2 border-blue-300 rounded-md">Quadro
            </div>
            @if ($door_side === 'top_right')
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
            <div class="grid w-full gap-2 space-x-2 space-y-1"
                style="grid-template-columns: repeat({{ $columns }}, minmax(100px, 1fr));">
                @for ($r = 1; $r <= $rows; $r++)
                    @for ($c = 1; $c <= $columns; $c++)
                        @php
                            $seat = $seats->first(fn($s) => $s->row === $r && $s->column === $c);
                        @endphp
                        <div class="mx-2 my-2 indicator">
                            @if ($seat?->students)
                                <span wire:click="remove({{ $seat->id }})"
                                    class="cursor-pointer indicator-item indicator-center badge badge-error">X</span>
                            @endif

                            <div wire:click="openModalSearch({{ $r }}, {{ $c }})"
                                class="flex items-center justify-center h-30 w-40 p-1 text-center border rounded cursor-pointer
                            {{ $seat?->students ? 'border-green-200 ' : 'border-gray-200 ' }}">
                                @if ($seat?->students)
                                    <div class="grid grid-cols-2">
                                        <svg class="w-10 h-10 text-green-500 " fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1"
                                            xmlns="http://www.w3.org/2000/svg">

                                            <rect x="9.11" y="12.02" width="11.48" height="3.83" />
                                            <rect x="10.07" y="1.5" width="9.57" height="5.74" />
                                            <polyline points="11.02 23.5 11.02 15.85 18.67 15.85 18.67 23.5" />
                                            <polyline points="11.98 12.98 11.98 7.24 17.72 7.24 17.72 12.98" />
                                            <polyline points="11.98 15.85 4.33 15.85 4.33 9.15" />
                                            <line x1="2.41" y1="9.15" x2="8.15" y2="9.15" />
                                        </svg>
                                        <div class="avatar">
                                            <div class="relative w-8 rounded-full cursor-pointer">
                                                <!-- Avatar pequeno -->
                                                <img src="{{ url('storage/student/' . $seat?->students?->id . '/' . $seat?->students?->code_image . '_list.png') }}"
                                                    alt="{{ $seat?->students?->name }}">
                                            </div>
                                        </div>
                                        <div class="flex flex-col text-xs text-green-500 col-span-full">
                                            {!! str_replace(' ', '<br>', $seat?->students?->nick) !!}
                                            <span>({{ $seat?->students?->number }})</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="grid grid-cols-2">
                                        <svg class="w-10 h-10 text-gray-800 col-span-full dark:text-yellow-400 "
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24" id="Layer_1"
                                            data-name="Layer 1" xmlns="http://www.w3.org/2000/svg">

                                            <rect x="9.11" y="12.02" width="11.48" height="3.83" />
                                            <rect x="10.07" y="1.5" width="9.57" height="5.74" />
                                            <polyline points="11.02 23.5 11.02 15.85 18.67 15.85 18.67 23.5" />
                                            <polyline points="11.98 12.98 11.98 7.24 17.72 7.24 17.72 12.98" />
                                            <polyline points="11.98 15.85 4.33 15.85 4.33 9.15" />
                                            <line x1="2.41" y1="9.15" x2="8.15" y2="9.15" />
                                        </svg>
                                        {{-- <div class="avatar">
                                            <div class="relative w-8 rounded-full cursor-pointer">
                                                <x-application-logo width="h-12"></x-application-logo>
                                            </div>
                                        </div> --}}
                                        <div class="text-yellow-400 col-span-full">
                                            Vazio
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endfor
                @endfor
            </div>
            {{-- Porta à direita --}}
            @if ($door_side === 'right')
                <div class="flex flex-col items-center w-12">
                    <div class="px-2 py-1 text-xs text-white bg-yellow-400 rounded shadow">
                        <svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                        </svg>
                    </div>
                </div>
            @endif
        </div>
        <div class="flex items-start gap-4 mt-5">
            @if ($door_side === 'bottom_left')
                <div class="flex flex-col items-center w-12">
                    <div class="px-2 py-1 text-xs text-white bg-yellow-400 rounded shadow">
                        <svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                        </svg>
                    </div>
                </div>
            @endif

            @if ($door_side === 'bottom_right')
                <div class="flex flex-col items-center w-12">
                    <div class="px-2 py-1 text-xs text-white bg-yellow-400 rounded shadow">
                        <svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
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
                                                                        alt="Foto grande"
                                                                        class="w-full h-full rounded-lg">
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
