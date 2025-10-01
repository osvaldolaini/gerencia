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
    <div class="w-full grid grid-cols-8">
        <div class="w-full col-span-1">
            <div class="p-0 tooltip tooltip-top" wire:click='print()' data-tip="Lista em pdf" wire:ignore>
                <button
                    class="px-3 py-2 text-gray-800 transition-colors duration-200 rounded-sm dark:text-white whitespace-nowrap">
                    <x-layout.svg.pdf></x-layout.svg.pdf>
                </button>
            </div>
        </div>
    </div>
    <div class="mt-5 space-y-4">
        <!-- Lista de itens arrastáveis -->
        <div>
            @foreach ($students as $item)
                    <div class="mb-10 rounded-md cursor-pointer">
                        <h2 id="w-full text-center items-center">
                            <div type="button"
                                class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <div class="grid grid-cols-8 gap-2 mx-2 ">
                                    <div class="pl-2 col-span-full sm:col-span-1">
                                        @if ($item->id)
                                            @if ($item->logo_path)
                                                <img src="{{ url('storage/student/' . $item->id . '/' . $item->logo_path) }}"
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
                                            class="text-3xl font-bold {{ $item->sex == 'F' ? 'text-red-500' : 'text-blue-500' }}">
                                            Al. {{ $item->nick ?? $item?->oldSudents?->nick }}
                                        </h1>
                                        <div class="max-w-xs">
                                            <p>
                                                nº. {{ $item->number ?? $item?->oldSudents?->number }}
                                            </p>
                                            <p>
                                                T. {{ $item?->al_class->title  ?? 'sem turma' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="space-y-2 col-span-full sm:col-span-3">
                        

                                    <span class="badge badge-{{ $item->total_faults_color }}">
                                        Faltas: {{ $item->total_faults }}
                                        ({{ number_format($item->total_faults_percent, 2, ',', '') }}%)
                                    </span>


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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </h2>
                    </div>
                
            @endforeach
            {{-- <div class="items-center justify-between py-4" wire:ignore>
                {{ $dataTable->links() }}
            </div> --}}
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
@section('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('openPdfInNewTabClasses', ({
                    pdfPath
                }) => {
                    window.open(pdfPath, '_blank');
                })
            })
        </script>
    @endsection

</div>
