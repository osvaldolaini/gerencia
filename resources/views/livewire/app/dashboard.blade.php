<div class="pt-3 w-100 sm:rounded-lg">
    <div class="flex flex-wrap sm:justify-center">
        <div class="w-full">
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
                                                                {{-- @livewire('settings.pdf.buttons', ['print_battalion', $school_years->id, $grade->id]) --}}
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
    </div>
</div>
