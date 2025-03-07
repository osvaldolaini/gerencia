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

            <div class="grid w-full grid-cols-2 gap-0 px-0 mx-0">
                <div class="grid w-full grid-cols-3 gap-0 px-0 mx-0">
                    <div class="col-span-2 px-0 mx-0">
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
                                                class="{{ in_array($item->id, $addSelected) ?? 'bg-gray-200' }} px-4 py-1 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                                <span class="flex ">
                                                    <span
                                                        class="{{ $item->sex == 'M' ? 'text-blue-500' : 'text-red-500' }}">
                                                        {{ $item->student_title }}
                                                    </span>
                                                    @if ($item->classT($school_classes_id))
                                                        <span
                                                            class="ml-2 badge {{ $item->classT($school_classes_id) == $title ? 'badge-success' : 'badge-neutral' }}">
                                                            {{ $item->classT($school_classes_id) }}
                                                        </span>
                                                    @endif
                                                    @if (in_array($item->id, $addSelected))
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
                    <div class="flex justify-center w-full col-span-1 mt-10 items-top">
                        <button wire:click='addStudent()'
                            class=" btn
                        {{ !empty($addSelected) ? '' : 'btn-outline' }} }}  btn-success btn-sm">
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
                    </div>
                </div>
                <div class="col-span-1 px-0 mx-0">
                    @livewire('settings.school-classes.school-classes-updateds', [$school_classes_id])
                </div>
            </div>
        </x-slot>
    </x-layout.tabs>
</div>
