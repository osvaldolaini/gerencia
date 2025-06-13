<div>

    <div>
        <div role="tabpanel" class="bg-gray-100 dark:bg-gray-700 dark:text-gray-100">
            <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                <div class="col-span-full ">
                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-100" for="title">
                        Alunos
                    </label>
                    <fieldset class="w-full col-span-1 space-y-1 dark:text-gray-100" wire:click="openModalSearch()"
                        wire:ignore>
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
                                            <button type="button" title="search"
                                                class="p-1 focus:outline-none focus:ring">
                                                <svg fill="currentColor" viewBox="0 0 512 512"
                                                    class="w-4 h-4 dark:text-gray-100">
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
                                                                                <img src="{{ url('storage/student/' . $item->id . '/' . $item->code_image . '_big.png') }}"
                                                                                    alt="Foto grande"
                                                                                    class="w-full h-full rounded-lg">
                                                                            @else
                                                                                <x-application-logo
                                                                                    width="h-12"></x-application-logo>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="font-bold">
                                                                            {{ $item->setTitle() }}
                                                                        </div>
                                                                        <div class="text-sm opacity-50">Al.
                                                                            {{ $item->student_title }}
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
                @if ($selectedStudents)
                    <div class="border-2 rounded-r-lg rounded-bl-lg col-span-full ">
                        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-4 sm:gap-3 sm:mb-5">
                            @foreach ($selectedStudents as $key => $value)
                                <div role="alert" class="w-full col-span-1 m-4 shadow-xl sm:col-span-2 alert ">
                                    <figure>
                                        <img src="{{ url('storage/student/' . $value['id'] . '/' . $value['code_image'] . '_list.png') }}"
                                            class="mx-auto rounded ">
                                    </figure>
                                    <div>
                                        <h3 class="font-bold">Al. {{ $value['nick'] }}</h3>
                                        <div class="text-xs">T. {{ $value['class'] }}</div>
                                    </div>
                                    <span wire:click="removeStudents({{ $key }})"
                                        class="btn btn-sm {{ $value['sex'] == 'F' ? 'btn-secondary' : 'btn-info' }}">Excluir
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            class="inline-block w-4 h-4 cursor-pointer stroke-current">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>
