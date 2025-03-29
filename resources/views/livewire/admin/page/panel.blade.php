<div class="pt-3 w-100 sm:rounded-lg">
    <div class="flex flex-wrap sm:justify-center">
        <div class="w-full">
            @if ($companies)
                @foreach ($companies as $company)
                    <div class="flex flex-wrap sm:justify-center">
                        <div class="w-full">
                            <div class="w-full py-4 space-x-4">
                                <small
                                    class="ml-2 space-x-1 text-5xl font-extrabold text-gray-500 col-span-full dark:text-gray-100">
                                    {{ $company->name }}
                                </small>
                                <h1
                                    class="grid grid-cols-2 space-x-1 text-3xl font-extrabold text-center sm:grid-cols-4 dark:text-gray-100">
                                    @foreach ($company->grade as $item)
                                        <div class="flex items-center justify-center col-span-1 mt-5 ">
                                            <div wire:click="select_grade({{ $item->id }})"
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
                                                {{-- <ul class="text-sm text-center">
                                            @forelse ($item->classes($school_classes_year_id) as $class)
                                                <li>{{ $class->title }}</li>
                                            @empty
                                                <li>Nenhuma turma cadastradas</li>
                                            @endforelse
                                        </ul> --}}
                                                <div class="w-full mt-auto">
                                                    @if (count($item->classes($school_years->id)) > 0)
                                                        <div class="flex justify-center font-medium duration-200">
                                                            {{-- Opções visíveis em telas grandes --}}
                                                            <div class="space-x-1 md:flex">
                                                                {{-- @livewire('settings.pdf.buttons', ['print_battalion', $school_years->id, $item->id]) --}}
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
