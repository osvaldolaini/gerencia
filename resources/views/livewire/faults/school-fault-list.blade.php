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
    <x-layout.search>
        <x-slot name="button">
            <button wire:click="showCreate()"
                class="flex items-center justify-center p-3 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg lg:px-5 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <svg class="w-4 h-4 mr-0 lg:mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                <span class="">Novo </span>
            </button>
        </x-slot>
    </x-layout.search>
    <div class="mt-5 space-y-4">
        <!-- Lista de itens arrastáveis -->
        <div>
            @foreach ($dataTable->filter(function ($fault) {
        return \Carbon\Carbon::parse($fault->date)->year == $actived;
    }) as $item)
                <div class="mb-10 rounded-md cursor-pointer">
                    <h2 id="w-full text-center items-center">
                        <div type="button"
                            class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <div class="grid grid-cols-8 gap-2 mx-2 ">
                                <div class="flex justify-between pl-2 col-span-full ">
                                    <div class="p-0">
                                        Falta lançada em
                                        {{ Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d/m/Y H:i:s') }}
                                        por {{ $item->created_by }}.
                                    </div>
                                </div>
                                <div class="pl-2 col-span-full sm:col-span-1">
                                    @if ($item->student_id)
                                        @if ($item->path)
                                            <img src="{{ url('storage/student/' . $item->student_id . '/' . $item->path) }}"
                                                class="mx-auto rounded-md">
                                        @else
                                            <x-application-logo width="h-12"></x-application-logo>
                                        @endif
                                    @else
                                        <x-application-logo width="h-12"></x-application-logo>
                                    @endif
                                </div>
                                <div class="col-span-full sm:col-span-2">
                                    <h1
                                        class="text-3xl font-bold {{ $item?->students?->sex == 'F' ? 'text-red-500' : 'text-blue-500' }}">
                                        Al. {{ $item?->students?->nick ?? $item?->oldSudents?->nick }}
                                    </h1>
                                    <div class="max-w-xs">
                                        <p>
                                            nº. {{ $item?->students?->number ?? $item?->oldSudents?->number }}
                                        </p>
                                        <p>
                                            T. {{ $item?->students?->al_class->title }}
                                        </p>
                                        <p>
                                            @if ($item->students?->company->code_image)
                                                <picture>
                                                    <source
                                                        srcset="{{ url('storage/companies/' . $item->students?->company->id . '/' . $item->students?->company->code_image . '_list.png') }}" />
                                                    <source
                                                        srcset="{{ url('storage/companies/' . $item->students?->company->id . '/' . $item->students?->company->code_image . '_list.webp') }}" />
                                                    <img src="{{ url('storage/companies/' . $item->students?->company->id . '/' . $item->students?->company->code_image . '_list.png') }}"
                                                        alt="{{ $item->students?->company->name }}">
                                                </picture>
                                            @else
                                                <span class="badge badge-accent">
                                                    {{ $item->students?->company?->nick ?? '' }}
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-2 col-span-full sm:col-span-3">
                                    <span class="btn btn-outline dark:btn-success btn-sm ">
                                        Data {{ $item->date_view }}
                                    </span>
                                    <span class="btn btn-outline dark:btn-success btn-sm">
                                        {{ $item->qtd }} período{{ $item->qtd > 1 ? 's' : '' }}
                                    </span>
                                    <div class="flex-nowrap">
                                        <span wire:click='justify({{ $item->id }},0)'
                                            class="btn {{ $item->justified == 0 ? '' : 'btn-outline' }} btn-error btn-sm">
                                            Não justificada
                                        </span>
                                        <span wire:click='justify({{ $item->id }},1)'
                                            class="btn {{ $item->justified == 1 ? '' : 'btn-outline' }} btn-info btn-sm">
                                            Justificada
                                        </span>
                                        <div class="p-0 tooltip tooltip-top"
                                            data-tip="Art. 86, § 3º, III - o aluno que estiver representando o CM em atividade externa ou extra classe, terá a sua
                                                    falta justificada (abono de falta). RICM 2024">
                                            <span wire:click='justify({{ $item->id }},2)'
                                                class="btn {{ $item->justified == 2 ? '' : 'btn-outline' }} btn-success btn-sm">
                                                Abonada
                                            </span>
                                        </div>
                                    </div>

                                    {{-- @switch($item->justified)
                                        @case(0)
                                            <span class="btn btn-outline btn-error btn-sm">
                                                Não justificada
                                            </span>
                                        @break

                                        @case(1)
                                            <span class="btn btn-outline btn-info btn-sm">
                                                Justificada
                                            </span>
                                        @break

                                        @case(2)
                                            <span class="btn btn-outline btn-success btn-sm">
                                                Abonada
                                            </span>
                                        @break
                                    @endswitch --}}
                                </div>
                                <div class="col-span-full sm:col-span-2">
                                    <div class="justify-start block space-x-2 space-y-2 font-medium duration-200 ">

                                        @if (in_array('update', auth()->user()->jsonActivities))
                                            <button wire:click='showUpdate({{ $item->id }})'
                                                class="btn btn-outline dark:btn-accent btn-sm">
                                                Editar
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif

                                        @if (in_array('active', auth()->user()->jsonActivities))
                                            <button wire:click="showModalDelete({{ $item->id }})"
                                                class="btn btn-outline dark:btn-accent btn-sm">
                                                Apagar
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                <!-- SVG de Apagar -->
                                            </button>
                                        @endif

                                        @if ($item->justified != 0)
                                            <a href="{{ route('school-faults-justified', $item->id) }}"
                                                class="btn btn-outline dark:btn-accent btn-sm">
                                                Justificativa
                                                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('school-faults-second-call', $item->id) }}"
                                                class="btn btn-outline dark:btn-accent btn-sm">
                                                2ª Chamada
                                                <svg class="w-6 h-6 mr-2" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </h2>
                </div>
            @endforeach
            <div class="items-center justify-between py-4" wire:ignore>
                {{ $dataTable->links() }}
            </div>
        </div>
    </div>
    {{-- MODAL DELETE --}}
    <x-confirmation-modal wire:model="showJetModal">
        <x-slot name="title">
            Excluir registro
        </x-slot>

        <x-slot name="content">
            <h2 class="h2">Deseja realmente excluir o registro?</h2>
            <p>Não será possível reverter esta ação!</p>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('showJetModal')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="delete({{ $id }})" wire:loading.attr="disabled">
                Apagar registro
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    {{-- MODAL FORM --}}

    <x-dialog-modal wire:model="showModalForm" maxWidth="4xl">
        <x-slot name="title">{{ $breadcrumb }} </x-slot>
        <x-slot name="content">
            @if ($school_faults)
                @livewire('faults.school-fault-form', ['school_faults' => $school_faults], key($school_faults->id))
            @else
                @livewire('faults.school-fault-form')
            @endif
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>
</div>
