<div>
    <fieldset class="w-full col-span-1 space-y-1 dark:text-gray-100" wire:click="openModalSearch()" wire:ignore>
        <label for="Search" class="hidden">Pesquisar</label>
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
            <input type="text" readonly placeholder="Pesquisar" wire:model.live="people"
                class="w-full py-3 pl-10 text-sm text-gray-900 border-blue-500 rounded-2xl focus:ring-primary-500 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500"
                autofocus />
        </div>
    </fieldset>
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
                                        @if ($item->people_grade == $field)
                                            <tr class="hover:bg-gray-200 dark:hover:bg-gray-500">
                                                <td>
                                                    <div class="flex items-center gap-3 cursor-pointer "
                                                        wire:click="selectPeople({{ $item->id }})">
                                                        <div class="avatar">
                                                            <div class="h-24 w-18">
                                                                @if ($item->code_image)
                                                                    <div class="avatar">
                                                                        <div
                                                                            class="relative w-8 rounded-full cursor-pointer">
                                                                            <!-- Avatar pequeno -->
                                                                            <img @mouseleave="show = false"
                                                                                @mouseover="show = true; x = $event.clientX; y = $event.clientY"
                                                                                src="{{ url('storage/student/' . $item->id . '/' . $item->code_image . '_list.png') }}"
                                                                                alt="{{ $item->name }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Foto maior ao passar o mouse -->
                                                                    <div x-show="show" x-transition.opacity
                                                                        class="fixed z-50 w-32 h-32 p-1 bg-white border-2 border-gray-300 rounded-lg shadow-lg"
                                                                        :style="'top: ' + (y + 10) + 'px; left: ' + (x + 10) +
                                                                        'px;'">
                                                                        <img src="{{ url('storage/student/' . $item->id . '/' . $item->code_image . '_big.png') }}"
                                                                            alt="Foto grande"
                                                                            class="w-full h-full rounded-lg">
                                                                    </div>
                                                                @else
                                                                    <div class="avatar">
                                                                        <div
                                                                            class="relative w-8 rounded-full cursor-pointer">
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
                                        @endif
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
