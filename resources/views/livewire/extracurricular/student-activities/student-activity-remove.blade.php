<div>
    <div class="grid w-full grid-cols-3 px-0 mx-0">
        <div class="flex justify-center col-span-1 px-0 mx-0 mt-10 items-top">

            <button wire:click='removeStudent()'
                class="
            btn
            {{ !empty($removeSelected) ? '' : 'btn-outline' }} btn-error btn-sm">
                Remover
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " fill="currentColor" viewBox="0 0 512 512"
                    xml:space="preserve">
                    <g>
                        <polygon
                            points="367.16,7.16 261.176,114.72 367.16,222.28 367.16,176.12 512,176.12 512,53.32 367.16,53.32 	" />
                        <polygon
                            points="367.16,289.72 261.176,397.28 367.16,504.84 367.16,458.68 512,458.68 512,335.88 367.16,335.88 	" />
                        <polygon
                            points="105.976,148.44 0,256 105.976,363.56 105.976,317.4 250.824,317.4 250.824,194.6 105.976,194.6 	" />
                    </g>
                </svg>

            </button>
        </div>
        <div class="col-span-2 ">
            <x-layout.search>
                <x-slot name="button">

                </x-slot>
            </x-layout.search>
            <x-layout.table>
                <x-slot name="head">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr scope="col" class="text-gray-500 dark:text-gray-400">
                            <th scope="col"
                                class="px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                Alunos da atividade
                            </th>
                        </tr>
                    </thead>
                </x-slot>
                <x-slot name="body">
                    <tbody class="p-0 m-0 bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                        @foreach ($dataTable as $item)
                            <tr class="cursor-pointer hover:bg-gray-200"
                                wire:click="selectRemoveStudent('{{ $item->id }}')">
                                <td
                                    class="{{ in_array($item->id, $removeSelected) ?? 'bg-gray-200' }} px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">

                                    <span class="flex ">

                                        <div x-data="{ show: false, x: 0, y: 0 }"
                                            class="relative flex items-center px-4 py-1 space-x-2 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                            @if (in_array($item->id, $removeSelected))
                                                <svg class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.4"
                                                        d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81V16.18C2 19.83 4.17 22 7.81 22H16.18C19.82 22 21.99 19.83 21.99 16.19V7.81C22 4.17 19.83 2 16.19 2Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M13.0594 12.0001L15.3594 9.70011C15.6494 9.41011 15.6494 8.93011 15.3594 8.64011C15.0694 8.35011 14.5894 8.35011 14.2994 8.64011L11.9994 10.9401L9.69937 8.64011C9.40937 8.35011 8.92937 8.35011 8.63938 8.64011C8.34938 8.93011 8.34938 9.41011 8.63938 9.70011L10.9394 12.0001L8.63938 14.3001C8.34938 14.5901 8.34938 15.0701 8.63938 15.3601C8.78938 15.5101 8.97937 15.5801 9.16937 15.5801C9.35937 15.5801 9.54937 15.5101 9.69937 15.3601L11.9994 13.0601L14.2994 15.3601C14.4494 15.5101 14.6394 15.5801 14.8294 15.5801C15.0194 15.5801 15.2094 15.5101 15.3594 15.3601C15.6494 15.0701 15.6494 14.5901 15.3594 14.3001L13.0594 12.0001Z"
                                                        fill="currentColor" />
                                                </svg>
                                            @endif


                                            <span class="{{ $item->sex == 'M' ? 'text-blue-500' : 'text-red-500' }}">
                                                {{ $item->number . ' - ' . $item->nick }}
                                            </span>



                                        </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-slot>

                <x-slot name="link" wire:ignore>
                    {{ $dataTable->links() }}
                </x-slot>
            </x-layout.table>
        </div>
    </div>

</div>
