<div>
    @php
        use Carbon\Carbon;
    @endphp
    <x-layout.breadcrumb>
        <x-slot name="left">
            <h3 class="text-2xl font-bold tracki dark:text-gray-50">
                {{ $breadcrumb }}
            </h3>
        </x-slot>
    </x-layout.breadcrumb>
    {{-- <div class="grid w-full grid-cols-8">
        <div class="w-full col-span-1">
            <div class="p-0 tooltip tooltip-top" wire:click='printAuthorization()' data-tip="Imprimir" wire:ignore>
                <button
                    class="px-3 py-2 text-gray-800 transition-colors duration-200 rounded-sm dark:text-white whitespace-nowrap">
                    <x-layout.svg.pdf class="w-8 h-8 text-white"></x-layout.svg.pdf>
                </button>
            </div>
        </div>
    </div> --}}

    <div>
        <div class="mb-10 rounded-md cursor-pointer">
            <h2 id="w-full text-center items-center">
                <div type="button"
                    class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <div class="grid grid-cols-8 gap-2 mx-2 ">
                        <div class="flex justify-between pl-2 col-span-full ">
                            <div class="p-0">
                                Falta lançada em
                                {{ Carbon::createFromFormat('Y-m-d H:i:s', $school_faults?->created_at)->format('d/m/Y H:i:s') }}
                                por {{ $school_faults?->created_by }}.
                            </div>
                        </div>
                        <div class="pl-2 col-span-full sm:col-span-1">

                            @if ($school_faults?->students->logo_path)
                                <img src="{{ url('storage/student/' . $school_faults?->students->id . '/' . $school_faults?->students->logo_path) }}"
                                    class="mx-auto rounded-md">
                            @else
                                <x-application-logo width="h-12"></x-application-logo>
                            @endif
                        </div>
                        <div class="col-span-full sm:col-span-2">
                            <h1
                                class="text-3xl font-bold {{ $school_faults?->students?->sex == 'F' ? 'text-red-500' : 'text-blue-500' }}">
                                Al. {{ $school_faults?->students?->nick ?? $school_faults?->oldSudents?->nick }}
                            </h1>
                            <div class="max-w-xs">
                                <p>
                                    nº. {{ $school_faults?->students?->number ?? $school_faults?->oldSudents?->number }}
                                </p>
                                <p>
                                    T. {{ $school_faults?->students?->al_class->title }}
                                </p>
                            </div>
                        </div>
                        <div class="space-y-2 col-span-full sm:col-span-3">
                            <span class="btn btn-outline dark:btn-success btn-sm ">
                                Data {{ $school_faults?->date_view }}
                            </span>
                            <span class="btn btn-outline dark:btn-success btn-sm">
                                {{ $school_faults?->qtd }} período{{ $school_faults?->qtd > 1 ? 's' : '' }}
                            </span>
                            <div class="flex-nowrap">
                                @switch($school_faults?->justified)
                                    @case(0)
                                        <span
                                            class="btn {{ $school_faults?->justified == 0 ? '' : 'btn-outline' }} btn-error btn-sm">
                                            Não justificada
                                        </span>
                                    @break

                                    @case(1)
                                        <span
                                            class="btn {{ $school_faults?->justified == 1 ? '' : 'btn-outline' }} btn-info btn-sm">
                                            Justificada
                                        </span>
                                    @break

                                    @case(2)
                                        <div class="p-0 tooltip tooltip-top"
                                            data-tip="Art. 86, § 3º, III - o aluno que estiver representando o CM em atividade externa ou extra classe, terá a sua
                                                falta justificada (abono de falta). RICM 2024">
                                            <span
                                                class="btn {{ $school_faults?->justified == 2 ? '' : 'btn-outline' }} btn-success btn-sm">
                                                Abonada
                                            </span>
                                        </div>
                                    @break

                                    @default
                                @endswitch
                            </div>
                        </div>
                        <div class="justify-center col-span-2 mb-5">
                            {{-- @livewire('message-alert-modal') --}}
                            <span wire:click="addAuthorization()" class="mb-2 btn btn-outline dark:btn-info">
                                <x-layout.svg.plus class="w-4 h-4 mr-0 lg:mr-2"></x-layout.svg.plus>
                                Nova autorização
                            </span>
                            @if ($authorizations->count() > 0)
                                <div class="p-0 tooltip tooltip-top" wire:click='printAuthorization()'
                                    data-tip="Imprimir" wire:ignore>
                                    <button class="btn btn-outline dark:btn-info ">
                                        <x-layout.svg.pdf class="w-8 h-8 "></x-layout.svg.pdf>
                                        Imprimir
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </h2>
        </div>
    </div>
    <div class="mt-5 space-y-4">
        <!-- Lista de itens arrastáveis -->
        <div>
            @foreach ($authorizations as $authorization)
                <div class="mb-10 rounded-md cursor-pointer" wire:key='item-{{ $authorization->id }}'>
                    <div type="button"
                        class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                            <div class="col-span-full">
                                <span wire:click="removeAuthorization({{ $authorization->id }})"
                                    class="btn btn-outline dark:btn-accent btn-sm }}">Excluir
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="inline-block w-4 h-4 cursor-pointer stroke-current" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                            <div class="col-span-full">
                                @livewire('faults.second-chance-form', ['second_call' => $authorization], key($authorization->id))
                            </div>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    @section('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('openPdfSecond', ({
                    pdfPath
                }) => {
                    window.open(pdfPath, '_blank');
                })
            })
        </script>
    @endsection

</div>
