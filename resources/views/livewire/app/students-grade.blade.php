<div>
    <div class="container flex flex-col items-center justify-center w-full mx-auto">
        <input type="text" placeholder="Pesquisar" wire:model.live="search"
            class="w-full py-3 pl-10 mb-5 text-sm text-gray-900 border-blue-500 rounded-2xl focus:ring-primary-500 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500"
            autofocus />
        <ul class="flex flex-col w-full">
            @forelse ($list as $item)
                <li class="flex flex-row w-full mb-2 border-gray-400 cursor-pointer" @click="activeTab = '#tab6'"
                    wire:click='seeStudentProfile({{ $item->students->id }})'>
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
</div>
