<div class="pt-3 w-100 sm:rounded-lg">
    <div class="grid w-full grid-cols-6 gap-2">
        <span class="col-span-full sm:col-span-2">
            <div class="relative h-32 overflow-hidden bg-blue-500 rounded-lg shadow-md">
                <svg class="absolute w-24 h-24 text-blue-800 rounded-md opacity-50 top-6 right-6 md:-right-4"
                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13 20V18C13 15.2386 10.7614 13 8 13C5.23858 13 3 15.2386 3 18V20H13ZM13 20H21V19C21 16.0545 18.7614 14 16 14C14.5867 14 13.3103 14.6255 12.4009 15.6311M11 7C11 8.65685 9.65685 10 8 10C6.34315 10 5 8.65685 5 7C5 5.34315 6.34315 4 8 4C9.65685 4 11 5.34315 11 7ZM18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="p-4 ">
                    <dl>
                        <dt class="text-sm font-medium leading-5 text-white truncate">
                            Total de alunos
                        </dt>
                        <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                            {{ $students }}
                        </dd>
                    </dl>
                </div>
            </div>
        </span>
        @if ($companies)
            @foreach ($companies as $company)
                <span class="col-span-full sm:col-span-2">
                    <div class="relative h-32 overflow-hidden bg-blue-500 rounded-lg shadow-md">
                        @if ($company->code_image)
                            <picture>
                                <source
                                    srcset="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png') }}" />
                                <source
                                    srcset="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.webp') }}" />
                                <img class="absolute w-24 h-24 text-blue-800 rounded-md opacity-50 top-6 right-6 md:-right-4 src="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png') }}"
                                    alt="{{ $company->name }}">
                            </picture>
                        @else
                            <svg class="absolute w-24 h-24 text-blue-800 rounded-md opacity-50 top-6 right-6 md:-right-4"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13 20V18C13 15.2386 10.7614 13 8 13C5.23858 13 3 15.2386 3 18V20H13ZM13 20H21V19C21 16.0545 18.7614 14 16 14C14.5867 14 13.3103 14.6255 12.4009 15.6311M11 7C11 8.65685 9.65685 10 8 10C6.34315 10 5 8.65685 5 7C5 5.34315 6.34315 4 8 4C9.65685 4 11 5.34315 11 7ZM18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        @endif

                        <div class="p-4 ">
                            <dl>
                                <dt class="text-sm font-medium leading-5 text-white truncate">
                                    Alunos da {{ $company->nick }}
                                </dt>
                                <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                                    {{ $company->students_live($school_classes_year_id) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </span>
            @endforeach
        @endif
        @if ($companies)
            <div class="col-span-full">
                <div class="grid w-full grid-cols-8 gap-2">
                    @foreach ($companies as $company)
                        @foreach ($company->grade as $grade)
                            <span class="col-span-full sm:col-span-2">
                                <div class="relative h-32 overflow-hidden bg-red-500 rounded-lg shadow-md">
                                    @if ($grade->code_image)
                                        <picture>
                                            <source
                                                srcset="{{ url('storage/schoolGrades/' . $grade->id . '/' . $grade->code_image . '_list.png') }}" />
                                            <source
                                                srcset="{{ url('storage/schoolGrades/' . $grade->id . '/' . $grade->code_image . '_list.webp') }}" />
                                            <img class="absolute w-24 h-24 text-red-800 rounded-md opacity-50 top-6 right-6 md:-right-4 src="{{ url('storage/companies/' . $grade->id . '/' . $grade->code_image . '_list.png') }}"
                                                alt="{{ $grade->name }}">
                                        </picture>
                                    @else
                                        <svg class="absolute w-24 h-24 text-red-800 rounded-md opacity-50 top-6 right-6 md:-right-4"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13 20V18C13 15.2386 10.7614 13 8 13C5.23858 13 3 15.2386 3 18V20H13ZM13 20H21V19C21 16.0545 18.7614 14 16 14C14.5867 14 13.3103 14.6255 12.4009 15.6311M11 7C11 8.65685 9.65685 10 8 10C6.34315 10 5 8.65685 5 7C5 5.34315 6.34315 4 8 4C9.65685 4 11 5.34315 11 7ZM18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    @endif
                                    <div class="p-4 ">
                                        <dl>
                                            <dt class="text-sm font-medium leading-5 text-white truncate">
                                                Alunos da {{ $grade->name }}
                                            </dt>
                                            <dd class="mt-1 text-5xl font-bold leading-9 text-white">
                                                {{ $grade->students_live($school_classes_year_id) }}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </span>
                        @endforeach
                    @endforeach
                </div>

            </div>

        @endif



        {{--
        @if ($lastReceiveds)
            <div
                class="relative w-full row-span-2 overflow-hidden text-white bg-blue-500 rounded-lg shadow-md col-span-full sm:col-span-2">
                <div class="flex items-center justify-between p-3">
                    <div class="flex items-center space-x-1">
                        <div class="-space-y-1">
                            <h2 class="text-sm font-semibold leadi">Últimos pagamentos</h2>
                        </div>
                    </div>
                    <span title="Open options">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 1920 1920"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M480 106.667c-117.82 0-213.333 95.512-213.333 213.333v1280c0 117.82 95.512 213.333 213.333 213.333h960c117.82 0 213.333-95.512 213.333-213.333V320c0-117.82-95.512-213.333-213.333-213.333H480ZM480 0h960c176.731 0 320 143.269 320 320v1280c0 176.731-143.269 320-320 320H480c-176.731 0-320-143.269-320-320V320C160 143.269 303.269 0 480 0Zm106.667 320C527.757 320 480 367.756 480 426.667v106.666C480 592.243 527.756 640 586.667 640h746.666c58.91 0 106.667-47.756 106.667-106.667V426.667c0-58.91-47.756-106.667-106.667-106.667H586.667Zm0-106.667h746.666c117.821 0 213.334 95.513 213.334 213.334v106.666c0 117.821-95.513 213.334-213.334 213.334H586.667c-117.821 0-213.334-95.513-213.334-213.334V426.667c0-117.821 95.513-213.334 213.334-213.334ZM480 853.333h106.667c58.91 0 106.666 47.757 106.666 106.667 0 58.91-47.756 106.667-106.666 106.667H480c-58.91 0-106.667-47.757-106.667-106.667 0-58.91 47.757-106.667 106.667-106.667Zm426.667 0h106.666C1072.243 853.333 1120 901.09 1120 960c0 58.91-47.756 106.667-106.667 106.667H906.667C847.757 1066.667 800 1018.91 800 960c0-58.91 47.756-106.667 106.667-106.667Zm426.666 0H1440c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.757 106.667-106.667 106.667h-106.667c-58.91 0-106.666-47.757-106.666-106.667 0-58.91 47.756-106.667 106.666-106.667Zm-853.333 320h106.667c58.91 0 106.666 47.757 106.666 106.667 0 58.91-47.756 106.667-106.666 106.667H480c-58.91 0-106.667-47.757-106.667-106.667 0-58.91 47.757-106.667 106.667-106.667Zm426.667 0h106.666c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.756 106.667-106.667 106.667H906.667C847.757 1386.667 800 1338.91 800 1280c0-58.91 47.756-106.667 106.667-106.667Zm426.666 0H1440c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.757 106.667-106.667 106.667h-106.667c-58.91 0-106.666-47.757-106.666-106.667 0-58.91 47.756-106.667 106.666-106.667Zm-853.333 320h106.667c58.91 0 106.666 47.757 106.666 106.667 0 58.91-47.756 106.667-106.666 106.667H480c-58.91 0-106.667-47.757-106.667-106.667 0-58.91 47.757-106.667 106.667-106.667Zm426.667 0h106.666c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.756 106.667-106.667 106.667H906.667C847.757 1706.667 800 1658.91 800 1600c0-58.91 47.756-106.667 106.667-106.667Zm426.666 0H1440c58.91 0 106.667 47.757 106.667 106.667 0 58.91-47.757 106.667-106.667 106.667h-106.667c-58.91 0-106.666-47.757-106.666-106.667 0-58.91 47.756-106.667 106.666-106.667Z" />
                        </svg>
                    </span>
                </div>
                <div class="w-full h-full p-0 m-0 text-gray-900 bg-white rounded-b-md ">
                    <div class="w-full px-1">
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-left">
                                        <th class="px-2 py-3">Cliente</th>
                                        <th class="px-2 py-3">Responsável</th>
                                        <th class="px-2 py-3 ">Valor</th>
                                        <th class="px-2 py-3">Recibo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lastReceiveds as $item)
                                        <tr class="border-b border-opacity-20 ">
                                            <td class="px-2 py-3">
                                                {{ $item->partners->name }}
                                            </td>
                                            <td class="px-2 py-3">
                                                {{ $item->created_by }}
                                            </td>
                                            <td class="flex px-2 py-3 text-center flex-nowrap">
                                                R$ {{ $item->value }}
                                            </td>
                                            <td class="px-2 py-3 text-center">
                                                @if ($item->active == 1)
                                                    @livewire('admin.financial.voucher', ['data' => $item, 'type' => 'received'], key($item->id))
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}

    </div>
    <div class="flex flex-wrap sm:justify-center">
        <div class="w-full">
            @if ($companies)
                @foreach ($companies as $company)
                    <div class="flex flex-wrap sm:justify-center">
                        <div class="w-full">
                            <div class="w-full py-4 space-x-4">
                                <small
                                    class="flex justify-center w-full space-x-1 text-xl font-extrabold text-center text-gray-500 sm:text-5xl col-span-full dark:text-gray-100">
                                    {{ $company->name }}
                                </small>
                                <h1
                                    class="grid grid-cols-2 space-x-1 text-3xl font-extrabold text-center sm:grid-cols-4 dark:text-gray-100">
                                    @foreach ($company->grade as $item)
                                        <div class="flex items-center justify-center col-span-1 mt-5 ">
                                            <div
                                                class="items-center w-56 mr-4 shadow-xl cursor-pointer h-60 drop-shadow-xl rounded-box hover:bg-gray-900 hover:text-gray-100">
                                                <div class="items-center text-center card-body ">
                                                    <h2 class="card-title">
                                                        @if ($item->code_image)
                                                            <picture>
                                                                <source
                                                                    srcset="{{ url('storage/schoolGrades/' . $item->id . '/' . $item->code_image . '_list.png') }}" />
                                                                <source
                                                                    srcset="{{ url('storage/schoolGrades/' . $item->id . '/' . $item->code_image . '_list.webp') }}" />
                                                                <img src="{{ url('storage/schoolGrades/' . $item->id . '/' . $item->code_image . '._list.png') }}"
                                                                    alt="{{ $item->name }}">
                                                            </picture>
                                                        @else
                                                            <x-application-logo width="h-12"></x-application-logo>
                                                        @endif

                                                        <span>

                                                            {{ $item->name }}
                                                        </span>
                                                    </h2>
                                                </div>
                                                <div class="w-full mt-auto">
                                                    @if (count($item->classes($school_years->id)) > 0)
                                                        <div class="flex justify-center font-medium duration-200">
                                                            {{-- Opções visíveis em telas grandes --}}
                                                            <div class="space-x-1 md:flex">
                                                                @livewire('settings.pdf.buttons', ['print_battalion', $school_years->id, $item->id])
                                                                @livewire('settings.pdf.buttons', ['print_classes', $school_years->id, $item->id])
                                                                @livewire('settings.pdf.buttons', ['print_call', $school_years->id, $item->id])
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </h1>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
