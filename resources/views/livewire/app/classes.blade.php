<div class="pt-3 w-100 sm:rounded-lg">
    @php
        use App\Enums\Rank;
    @endphp

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
                                            <div class="items-center pb-1 text-center card-body">
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
                                                <div class="flex flex-col justify-center col-span-2 mx-2 rounded-sm ">
                                                    <div class="grid w-full grid-cols-2 gap-2 pt-0 mt-0 text-xs">
                                                        <div
                                                            class="flex flex-col items-center justify-center text-xs sm:text-lg">
                                                            <span>Alunos</span>
                                                            {{ $grade->students_live($school_classes_year_id) }}
                                                        </div>
                                                        <div class="flex flex-col items-center justify-center">
                                                            @livewire('charts.sex', ['school_grade' => $grade->id, 'school_classes_year_id' => $school_classes_year_id])
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex justify-center col-span-1 mx-2 rounded-sm ">
                                                    @if (count($grade->classes($school_years->id)) > 0)
                                                        <div class="flex justify-center font-medium duration-200">
                                                            {{-- Opções visíveis em telas grandes --}}
                                                            <div class="flex space-x-1">
                                                                <div class="p-0 tooltip tooltip-top"
                                                                    data-tip="Ver alunos" wire:ignore>
                                                                    <span
                                                                        wire:click='view_students({{ $grade->id }},{{ $school_classes_year_id }})'
                                                                        class="flex px-3 py-2 transition-colors duration-200 rounded-sm hover:text-white dark:hover:bg-blue-500 hover:bg-blue-500 whitespace-nowrap">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-6 h-6">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                                        </svg>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            {{-- @livewire('app.students-grade', ['grade' => $grade->id, 'school_classes_year_id' => $school_classes_year_id]) --}}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-span-1" wire:ignore>
                                                    @livewire('app.battalion.students-grade', ['grade' => $grade->id])
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
    {{-- MODAL READ --}}
    <x-dialog-modal wire:model="seeModelBattalion">
        <x-slot name="title">Alunos do batalhão do {{ $title ? $title : '' }}</x-slot>
        <x-slot name="content">
            <div class="container flex flex-col items-center justify-center w-full mx-auto">
                <ul class="flex flex-col w-full">
                    @if ($seeModelBattalion)
                        @foreach ($battalion as $item)
                            <li class="flex flex-row w-full mb-2 border-gray-400">
                                <div
                                    class="flex items-center justify-between w-full p-4 bg-white border rounded-md shadow cursor-pointer select-none dark:bg-gray-800">
                                    <div class="items-center justify-center w-10 h-10 mr-4 ">
                                        <span class="relative block">
                                            @if ($item->students->logo_path)
                                                <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_list.png') }}"
                                                    class="object-cover w-10 h-10 mx-auto rounded-full ">
                                            @else
                                                <x-application-logo width="h-12"></x-application-logo>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex flex-col pl-1 md:mr-16">
                                        <div class="font-medium dark:text-white">
                                            Al {{ $item->students->nick }} - <span class="badge badge-success">
                                                {{ $item->students->people_class }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-600 dark:text-gray-200">
                                            {{ $item->students->name }}
                                        </div>
                                    </div>
                                    <div class="flex justify-end pl-1 text-right ">
                                        <!-- Exibir ícone da patente -->
                                        <img src="{{ Rank::fromDb($item->posto_grad)?->imageBg() ?? Storage::url('ranks/fundo/default.png') }}"
                                            alt="Patente" class="w-12 h-12 rounded-full">
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('seeModelBattalion')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
    {{-- MODAL READ --}}
    <x-dialog-modal wire:model="showModalView">
        <x-slot name="title">Alunos do {{ $title ? $title : '' }} </x-slot>
        <x-slot name="content">
            <div class="container flex flex-col items-center justify-center w-full mx-auto">

                <ul class="flex flex-col w-full">
                    @if ($select_grade)
                        @livewire('app.students-grade', ['grade' => $select_grade->id, 'school_classes_year_id' => $school_classes_year_id])
                    @endif
                    {{-- @forelse ($list as $item)
                        <li class="flex flex-row w-full mb-2 border-gray-400 cursor-pointer"
                            @click="activeTab = '#tab6'" wire:click='seeStudentProfile({{ $item->students->id }})'>
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
                    @endforelse --}}

                </ul>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showModalView')" class="mx-2">
                Fechar
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
