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

            <div class="grid w-full grid-cols-3 gap-2">
                <div class="col-span-1">
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
                                        Aluno
                                    </th>
                                </tr>
                            </thead>
                        </x-slot>
                        <x-slot name="body">
                            <tbody
                                class="p-0 m-0 bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach ($dataTable as $item)
                                    <tr class="cursor-pointer hover:bg-gray-200"
                                        wire:click="selectAddStudent('{{ $item->id }}')">
                                        <td
                                            class="{{ $item->id == $addSelected ?? 'bg-gray-200' }} px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                            <span class="flex ">
                                                {{ $item->student_title }}
                                                @if ($item->people_class)
                                                    <span
                                                        class="ml-2 badge {{ $item->people_class->class->title == $title ? 'badge-success' : 'badge-neutral' }}">{{ $item->people_class->class->title }}</span>
                                                @endif
                                                @if ($item->id == $addSelected)
                                                    <svg class="w-5 h-5 text-green-500" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.5"
                                                            d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </x-slot>

                        <x-slot name="link">
                            {{ $dataTable->links() }}
                        </x-slot>
                    </x-layout.table>
                </div>
                <div class="flex justify-center w-full col-span-1 mt-10 space-x-4 items-top">
                    <button wire:click='addStudent()'
                        class=" btn
                    {{ $addSelected ? '' : 'btn-outline' }} }}  btn-success btn-sm">
                        Adicionar
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " fill="currentColor"
                            viewBox="0 0 512 512" xml:space="preserve">
                            <polygon
                                points="144.84,504.84 250.824,397.28 144.84,289.72 144.84,335.88 0,335.88 0,458.68 144.84,458.68 " />
                            <polygon
                                points="144.84,222.28 250.824,114.72 144.84,7.16 144.84,53.32 0,53.32 0,176.12 144.84,176.12 " />
                            <polygon
                                points="406.024,363.56 512,256 406.024,148.44 406.024,194.6 261.176,194.6 261.176,317.4 406.024,317.4 " />
                        </svg>
                    </button>
                    <button wire:click='removeStudent()'
                        class="
                    btn
                    {{ $removeSelected ? '' : 'btn-outline' }} btn-error btn-sm">
                        Remover
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " fill="currentColor"
                            viewBox="0 0 512 512" xml:space="preserve">
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
                <div class="col-span-1">
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
                                        Aluno
                                    </th>
                                </tr>
                            </thead>
                        </x-slot>
                        <x-slot name="body">
                            <tbody
                                class="p-0 m-0 bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                @foreach ($class as $item)
                                    <tr class="cursor-pointer hover:bg-gray-200"
                                        wire:click="selectRemoveStudent('{{ $item->id }}')">
                                        <td
                                            class="{{ $item->id == $removeSelected ?? 'bg-gray-200' }} px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                            <span class="flex">
                                                {{ $item->students->student_title }}
                                                @if ($item->id == $removeSelected)
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
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </x-slot>

                        <x-slot name="link">
                            {{ $dataTable->links() }}
                        </x-slot>
                    </x-layout.table>
                </div>

            </div>


        </x-slot>
    </x-layout.tabs>
</div>
