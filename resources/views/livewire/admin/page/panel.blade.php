<div class="pt-3 w-100 sm:rounded-lg">
    <div class="flex flex-wrap sm:justify-center">
        <div class="w-full">
            @if ($school_years)
                <div class="w-full py-4 space-x-4">
                    <h1
                        class="grid grid-cols-1 space-x-1 text-5xl font-extrabold text-center sm:grid-cols-4 dark:text-white">
                        <small class="ml-2 font-semibold text-gray-500 col-span-full dark:text-gray-400">
                            Turmas de {{ $school_years->year }}
                        </small>
                        @foreach ($school_grade as $grade)
                            <div class="flex items-center justify-center col-span-1 mt-5 dark:text-gray-900">
                                <div
                                    class="w-56 mr-4 bg-white shadow-xl cursor-pointer h-60 drop-shadow-xl rounded-box card card-compact">

                                    <div class="mx-auto mt-5" wire:click="goCourse('{{ $grade->id }}')">
                                        {{-- <x-application-logo width="h-12"></x-application-logo> --}}
                                        {{ $grade->name }}
                                    </div>
                                    <div class="card-body">
                                        <ul class="text-sm text-center">
                                            @forelse ($grade->classes($school_years->id) as $class)
                                                <li>{{ $class->title }}</li>
                                            @empty
                                                <li>Nenhuma turma cadastradas</li>
                                            @endforelse
                                        </ul>
                                        <div class="w-full mt-auto">
                                            @if (count($grade->classes($school_years->id)) > 0)
                                                <div class="flex justify-center font-medium duration-200">
                                                    {{-- Opções visíveis em telas grandes --}}
                                                    <div class="space-x-1 md:flex">
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
                </div>
            @endif

        </div>
    </div>

</div>
