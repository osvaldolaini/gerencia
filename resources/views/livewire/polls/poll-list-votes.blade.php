<div>

    <x-layout.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
        </x-slot>

    </x-layout.breadcrumb>

    <x-layout.table>
        <x-slot name="head">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr scope="col" class="text-gray-500 dark:text-gray-400">
                    <th scope="col" wire:click="addSort('year')"
                        class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                        Aluno
                    </th>
                    <th scope="col"
                        class="px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                        Enquete
                    </th>
                </tr>
            </thead>
        </x-slot>
        <x-slot name="body">
            <tbody class="p-0 m-0 bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                @foreach ($dataTable as $item)
                    <tr>
                        <td class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                            {{ $item->student_name }}
                        </td>

                        <td class="w-1/6 px-4 py-1 text-sm font-normal text-center text-gray-500 dark:text-gray-400">
                            <button wire:click='showVote({{ $item->id }})'
                                class="flex justify-center px-3 py-2 mx-auto transition-colors duration-200 hover:text-gray-400 whitespace-nowrap">
                                <svg class="w-6 h-6" viewBox="0 -1.5 20.412 20.412" xmlns="http://www.w3.org/2000/svg">
                                    <g id="check-lists" transform="translate(-1.588 -2.588)">
                                        <path id="primary" d="M7,4,4.33,7,3,5.5" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        <path id="primary-2" data-name="primary" d="M3,11.5,4.33,13,7,10" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" />
                                        <path id="primary-3" data-name="primary" d="M3,17.5,4.33,19,7,16" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" />
                                        <path id="primary-4" data-name="primary" d="M11,6H21M11,12H21M11,18H21"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2" />
                                    </g>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-slot>

        {{-- <x-slot name="link">
            {{ $dataTable->links() }}
        </x-slot> --}}
    </x-layout.table>


    {{-- MODAL READ --}}
    <x-dialog-modal wire:model="selectedVote">
        <x-slot name="title">
            <div>
                @if ($selectedVote)
                    <span class="text-xs font-semibold text-blue-600 uppercase">
                        Respostas da votação
                    </span>

                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mt-1">
                        {{ $selectedVote['student_name'] }}
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Nº {{ $selectedVote['student_number'] }}
                        · {{ $selectedVote['school_class_name'] }}
                    </p>

                    <p class="text-xs text-gray-400 mt-2">
                        <i class="fa-regular fa-clock mr-1"></i>
                        {{ $selectedVote['voted_at'] }}
                    </p>
                @endif
            </div>
        </x-slot>
        <x-slot name="content">
            <dl class="text-gray-900 divide-y divide-gray-200 max-w dark:text-white dark:divide-gray-700">

                @if ($selectedVote)
                    {{-- Perguntas e respostas --}}
                    <div class="p-5 overflow-y-auto space-y-4">

                        @foreach ($selectedVote['answers'] as $index => $answer)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">

                                <div class="p-4 bg-gray-50 dark:bg-gray-900">

                                    <div class="flex items-start gap-3">

                                        <span
                                            class="w-7 h-7 shrink-0 rounded-lg bg-blue-100
                                                text-blue-700 flex items-center justify-center
                                                text-xs font-bold">
                                            {{ $index + 1 }}
                                        </span>

                                        <div>
                                            <h3 class="font-semibold text-gray-800 dark:text-white">
                                                {{ $answer['question'] }}
                                            </h3>

                                            <span class="text-xs text-gray-400">
                                                @if ($answer['type'] === 'single_choice')
                                                    Escolha única
                                                @elseif($answer['type'] === 'multiple_choice')
                                                    Múltipla escolha
                                                @else
                                                    Resposta aberta
                                                @endif
                                            </span>
                                        </div>

                                    </div>
                                </div>

                                <div class="p-4">

                                    @if ($answer['response'] === 'Não respondeu')
                                        <span class="text-sm text-gray-400 italic">
                                            Não respondeu
                                        </span>
                                    @else
                                        <div class="flex gap-2 text-sm text-gray-700 dark:text-gray-200">
                                            <i class="fa-solid fa-check-circle text-green-500 mt-0.5"></i>

                                            <span class="whitespace-pre-line break-words">
                                                {{ $answer['response'] }}
                                            </span>
                                        </div>
                                    @endif

                                </div>

                            </div>
                        @endforeach

                    </div>


                @endif

            </dl>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalView')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>


</div>
