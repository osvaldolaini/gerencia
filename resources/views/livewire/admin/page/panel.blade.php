<div class="pt-3 w-100 sm:rounded-lg">
    <div class="grid w-full grid-cols-6 gap-2">
        <span class="col-span-full sm:col-span-2">
            <div class="relative h-32 overflow-hidden bg-blue-500 rounded-lg shadow-md">
                @if ($config->id)
                    <picture class="absolute w-24 h-24 text-red-800 rounded-md opacity-50 top-2 -right-4 md:-right-4">
                        <source srcset="{{ url('storage/logos-school/logo.png') }}" />
                        <source srcset="{{ url('storage/logos-school/logo.webp') }}" />
                        <img class="absolute w-24 h-24 text-red-800 rounded-md opacity-50 top-2 -right-4 md:-right-4"
                            src="{{ url('storage/logos-school/logo.png') }}" alt="api-gerencia">
                    </picture>
                @else
                    <svg class="absolute w-24 h-24 text-red-800 rounded-md opacity-50 top-2 -right-4 md:-right-4"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 20V18C13 15.2386 10.7614 13 8 13C5.23858 13 3 15.2386 3 18V20H13ZM13 20H21V19C21 16.0545 18.7614 14 16 14C14.5867 14 13.3103 14.6255 12.4009 15.6311M11 7C11 8.65685 9.65685 10 8 10C6.34315 10 5 8.65685 5 7C5 5.34315 6.34315 4 8 4C9.65685 4 11 5.34315 11 7ZM18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                @endif
                <div class="p-4 ">
                    <dl>
                        <dt class="text-sm font-medium leading-5 text-white truncate">
                            Alunos do {{ $config->nick }}
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
                                <img class="absolute w-24 h-24 text-blue-800 rounded-md opacity-50 top-2 -right-6 md:-right-4 src="{{ url('storage/companies/' . $company->id . '/' . $company->code_image . '_list.png') }}"
                                    alt="{{ $company->name }}">
                            </picture>
                        @else
                            <svg class="absolute w-24 h-24 text-blue-800 rounded-md opacity-50 top-2 -right-6 md:-right-4"
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
    </div>
    @if ($companies)
        <div class="flex flex-wrap sm:justify-center">
            <div class="w-full">
                @foreach ($companies as $company)
                    <small
                        class="flex justify-center w-full space-x-1 text-xl font-extrabold text-center text-gray-500 sm:text-5xl col-span-full dark:text-gray-100">
                        {{ $company->name }}
                    </small>

                    <h1
                        class="grid grid-cols-2 space-x-1 text-3xl font-extrabold text-center sm:grid-cols-4 dark:text-gray-100">
                        @foreach ($company->grade as $grade)
                            <div class="flex items-center justify-center col-span-1 mt-5 ">
                                <div
                                    class="items-center w-56 mr-4 shadow-xl cursor-pointer h-60 drop-shadow-xl rounded-box hover:bg-gray-900 hover:text-gray-100">
                                    <div class="items-center pt-2 pb-1 text-center card-body">
                                        <h2 class="card-title">
                                            @if ($grade->code_image)
                                                <picture>
                                                    <source
                                                        srcset="{{ url('storage/schoolGrades/' . $grade->id . '/' . $grade->code_image . '_list.png') }}" />
                                                    <source
                                                        srcset="{{ url('storage/schoolGrades/' . $grade->id . '/' . $grade->code_image . '_list.webp') }}" />
                                                    <img src="{{ url('storage/schoolGrades/' . $grade->id . '/' . $grade->code_image . '._list.png') }}"
                                                        alt="{{ $grade->name }}">
                                                </picture>
                                            @else
                                                <x-application-logo width="h-12"></x-application-logo>
                                            @endif

                                            <span>
                                                {{ $grade->name }}
                                            </span>
                                        </h2>
                                    </div>
                                    <div class="grid w-full grid-cols-2 gap-2 pt-0 mt-0 text-xs">
                                        <div class="flex flex-col justify-center col-span-1 mx-2 rounded-sm ">
                                            <div class="w-full text-xs sm:text-lg">Alunos</div>
                                            <div class="w-full text-xs sm:text-lg">
                                                {{ $grade->students_live($school_classes_year_id) }}
                                            </div>
                                        </div>
                                        <div class="flex flex-col justify-center col-span-1 mx-2 rounded-sm ">
                                            <div class="w-full sm:text-md">
                                                @livewire('charts.sex', ['school_grade' => $grade->id, 'school_classes_year_id' => $school_classes_year_id])
                                            </div>
                                        </div>
                                        <div class="flex justify-center col-span-1 mx-2 rounded-sm ">
                                            @if (count($grade->classes($school_years->id)) > 0)
                                                <div class="flex justify-center font-medium duration-200">
                                                    {{-- Opções visíveis em telas grandes --}}
                                                    <div class="flex space-x-1">
                                                        @livewire('settings.pdf.buttons', ['print_battalion', $school_years->id, $grade->id])
                                                        @livewire('settings.pdf.buttons', ['print_classes', $school_years->id, $grade->id])
                                                        @livewire('settings.pdf.buttons', ['print_call', $school_years->id, $grade->id])
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </h1>
                @endforeach
            </div>

        </div>

    @endif
</div>
