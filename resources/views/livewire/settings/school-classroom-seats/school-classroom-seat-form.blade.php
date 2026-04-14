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
            <div class="grid grid-cols-2">
                <div class="flex justify-start w-full col-span-1 space-x-1">
                    <div class="p-0 tooltip tooltip-top" data-tip="Espelho de classe" wire:ignore>
                        <button wire:click="classroom({{ $school_classes->id }})"
                            class="px-3 py-2 transition-colors duration-200 rounded-md btn btn-outline btn-accent whitespace-nowrap">
                            Imprimir
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2" fill="currentColor"
                                viewBox="0 0 512 512" xml:space="preserve">

                                <g>
                                    <path d="M347.746,346.204c-8.398-0.505-28.589,0.691-48.81,4.533c-11.697-11.839-21.826-26.753-29.34-39.053
                                    c24.078-69.232,8.829-88.91-11.697-88.91c-16.119,0-24.167,17.011-22.376,35.805c0.906,9.461,8.918,29.34,18.78,48.223
                                    c-6.05,15.912-16.847,42.806-27.564,62.269c-12.545,3.812-23.305,8.048-31.027,11.622c-38.465,17.888-41.556,41.773-33.552,51.894
                                    c15.197,19.226,47.576,2.638,80.066-55.468c22.243-6.325,51.508-14.752,54.146-14.752c0.304,0,0.721,0.097,1.204,0.253
                                    c16.215,14.298,35.366,30.67,51.128,32.825c22.808,3.136,35.791-13.406,34.891-23.692
                                    C382.703,361.461,376.691,347.942,347.746,346.204z M203.761,408.88c-9.401,11.178-24.606,21.9-29.972,18.334
                                    c-5.373-3.574-6.265-13.86,5.819-25.497c12.076-11.623,32.29-17.657,35.329-18.787c3.59-1.337,4.482,0,4.482,1.791
                                    C219.419,386.512,213.154,397.689,203.761,408.88z M244.923,258.571c-0.899-11.192,1.33-21.922,10.731-23.26
                                    c9.386-1.352,13.868,9.386,10.292,26.828c-3.582,17.464-5.38,29.08-7.164,30.44c-1.79,1.338-3.567-3.144-3.567-3.144
                                    C251.627,282.27,245.815,269.748,244.923,258.571z M248.505,363.697c4.912-8.064,17.442-40.702,17.442-40.702
                                    c2.683,4.926,23.699,29.956,23.699,29.956S257.438,360.123,248.505,363.697z M345.999,377.995
                                    c-13.414-1.768-36.221-17.895-36.221-17.895c-3.128-1.337,24.992-5.157,35.79-4.466c13.875,0.9,18.794,6.718,18.794,12.53
                                    C364.362,373.982,359.443,379.787,345.999,377.995z" />
                                    <path class="st0" d="M461.336,107.66l-98.34-98.348L353.683,0H340.5H139.946C92.593,0,54.069,38.532,54.069,85.901v6.57H41.353
                                        v102.733h12.716v230.904c0,47.361,38.525,85.893,85.878,85.893h244.808c47.368,0,85.893-38.532,85.893-85.893V130.155v-13.176
                                        L461.336,107.66z M384.754,480.193H139.946c-29.875,0-54.086-24.212-54.086-54.086V195.203h157.31V92.47H85.86v-6.57
                                        c0-29.882,24.211-54.102,54.086-54.102H332.89v60.894c0,24.888,20.191,45.065,45.079,45.065h60.886v288.349
                                        C438.855,455.982,414.636,480.193,384.754,480.193z M88.09,166.086v-47.554c0-0.839,0.683-1.524,1.524-1.524h15.108
                                        c2.49,0,4.786,0.409,6.837,1.212c2.029,0.795,3.812,1.91,5.299,3.322c1.501,1.419,2.653,3.144,3.433,5.121
                                        c0.78,1.939,1.182,4.058,1.182,6.294c0,2.282-0.402,4.414-1.19,6.332c-0.78,1.918-1.932,3.619-3.418,5.054
                                        c-1.479,1.427-3.27,2.549-5.321,3.329c-2.036,0.78-4.332,1.174-6.822,1.174h-6.376v17.241c0,0.84-0.683,1.523-1.523,1.523h-7.208
                                        C88.773,167.61,88.09,166.926,88.09,166.086z M134.685,166.086v-47.554c0-0.839,0.684-1.524,1.524-1.524h16.698
                                        c3.173,0,5.968,0.528,8.324,1.568c2.386,1.062,4.518,2.75,6.347,5.009c0.944,1.189,1.694,2.504,2.236,3.916
                                        c0.528,1.375,0.929,2.862,1.189,4.407c0.253,1.531,0.401,3.181,0.453,4.957c0.045,1.694,0.067,3.515,0.067,5.447
                                        c0,1.924-0.022,3.746-0.067,5.44c-0.052,1.769-0.2,3.426-0.453,4.964c-0.26,1.546-0.661,3.025-1.189,4.399
                                        c-0.55,1.427-1.3,2.743-2.23,3.909c-1.842,2.282-3.976,3.969-6.354,5.016c-2.334,1.04-5.135,1.568-8.324,1.568h-16.698
                                        C135.368,167.61,134.685,166.926,134.685,166.086z M214.269,137.981c0.84,0,1.523,0.684,1.523,1.524v6.48
                                        c0,0.84-0.683,1.524-1.523,1.524h-18.244v18.579c0,0.84-0.684,1.523-1.524,1.523h-7.209c-0.84,0-1.523-0.683-1.523-1.523v-47.554
                                        c0-0.839,0.683-1.524,1.523-1.524h27.653c0.839,0,1.524,0.684,1.524,1.524v6.48c0,0.84-0.684,1.524-1.524,1.524h-18.92v11.444
                                        H214.269z" />
                                    <path class="st0"
                                        d="M109.418,137.706c1.212-1.092,1.798-2.645,1.798-4.749c0-2.096-0.587-3.649-1.798-4.741
                                        c-1.263-1.13-2.928-1.68-5.098-1.68h-5.975v12.848h5.975C106.489,139.385,108.155,138.836,109.418,137.706z" />
                                    <path class="st0" d="M156.139,157.481c1.13-0.424,2.103-1.107,2.973-2.088c0.944-1.055,1.538-2.571,1.769-4.511
                                        c0.26-2.208,0.386-5.091,0.386-8.569c0-3.485-0.126-6.369-0.386-8.569c-0.231-1.946-0.825-3.462-1.762-4.51
                                        c-0.869-0.982-1.873-1.679-2.972-2.089c-1.182-0.453-2.534-0.676-4.042-0.676h-7.164v31.68h7.164
                                        C153.605,158.15,154.965,157.927,156.139,157.481z" />
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex justify-end w-full col-span-1 space-x-1">

                    @foreach ($otherClasses as $item)
                        <a href="{{ route('school-classes-classroom-seats', $item->id) }}"
                            class='btn {{ $item->id == $school_classes_id ? ' btn-info' : 'btn-outline btn-info' }}'>
                            <span>
                                {{ $item->title }}
                            </span>
                        </a>
                    @endforeach
                </div>
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
            <div class="grid w-full gap-2 "
                style="grid-template-columns: repeat({{ $columns }}, minmax(100px, 1fr));">
                @for ($r = 1; $r <= $rows; $r++)
                    @for ($c = 1; $c <= $columns; $c++)
                        @php
                            $seat = $seats->first(fn($s) => $s->row === $r && $s->column === $c);
                        @endphp
                        <div class="indicator">
                            @if ($seat?->students)
                                <span wire:click="remove({{ $seat->id }})"
                                    class="cursor-pointer indicator-item indicator-center badge badge-error">X</span>
                            @endif

                            <div wire:click="openModalSearch({{ $r }}, {{ $c }})"
                                class="flex items-center justify-center h-30 w-32 p-1 m-2 text-center border rounded cursor-pointer
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
    @section('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('openPdfInNewTabClasses', ({
                    pdfPath
                }) => {
                    window.open(pdfPath, '_blank');
                })
            })
        </script>
    @endsection
</div>
