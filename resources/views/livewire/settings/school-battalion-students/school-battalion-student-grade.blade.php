<div class="pt-3 w-100 sm:rounded-lg">
    <div class="flex flex-wrap sm:justify-center">
        <div class="w-full">
            <div class="w-full py-4 space-x-4">
                <h1
                    class="grid grid-cols-1 space-x-1 text-5xl font-extrabold text-center sm:grid-cols-4 dark:text-white">
                    <small class="ml-2 font-semibold text-gray-500 col-span-full dark:text-gray-400">
                        Anos de {{ $school_battalions->year }}
                    </small>
                    @foreach ($school_grade as $grade)
                        <div class="flex items-center justify-center col-span-1 mt-5 ">
                            <div
                                class="items-center w-56 mr-4 shadow-xl cursor-pointer h-60 drop-shadow-xl rounded-box hover:bg-gray-900 hover:text-gray-100">
                                <div class="items-center pt-2 pb-1 text-center card-body"
                                    wire:click="goCourse('{{ $grade->id }}')">
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
                                    <div class="w-full col-span-1 mt-auto">
                                        <div class="flex justify-center font-medium duration-200">
                                            <div class="space-x-1 md:flex">
                                                <div class="p-0 tooltip tooltip-top" data-tip="Montar">
                                                    <a href="{{ route('school-battalion-students-mount', [$school_battalions->id, $grade->id]) }}"
                                                        class="flex px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-span-1"></div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </h1>
            </div>

        </div>
    </div>

</div>
