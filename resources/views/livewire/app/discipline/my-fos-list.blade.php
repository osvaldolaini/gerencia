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
            @foreach ($dataTable as $item)
                <div class="mb-10 rounded-md cursor-pointer">
                    <h2 id="w-full text-center items-center">
                        <div type="button"
                            class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <div class="grid grid-cols-8 gap-2 mx-2 ">
                                <div class="flex justify-between pl-2 col-span-full ">
                                    <div class="p-0 tooltip tooltip-top" data-tip="Arraste e solte">
                                        FO <span
                                            class="badge {{ $item->fact_type == 'negativo' ? 'badge-error' : ($item->fact_type == 'positivo' ? 'badge-success' : 'badge-info') }}">
                                            {{ $item->fact_type }}</span> Nº <span>{{ $item->fact_number }}
                                            - ocorrido em {{ $item->f_date . ' às ' . $item->fact_hour }} por
                                            {{ $item->fact_observer . ' ' . $item->fact_observer_function }}.

                                        </span>
                                    </div>
                                </div>
                                <div class="pl-2 col-span-full sm:col-span-1">
                                    @if ($item->student_id)
                                        @if ($item->students->logo_path)
                                            <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_big.png') }}"
                                                class="mx-auto rounded-md">
                                        @else
                                            <x-application-logo width="h-12"></x-application-logo>
                                        @endif
                                    @else
                                        <x-application-logo width="h-12"></x-application-logo>
                                    @endif
                                </div>
                                <div class="col-span-full sm:col-span-2">
                                    <h1 class="text-3xl font-bold">
                                        Al. {{ $item->al_nick }}
                                    </h1>
                                    <div class="max-w-xs">
                                        <p>
                                            nº. {{ $item->al_number }}
                                        </p>
                                        <p>
                                            T. {{ $item->al_class }}
                                        </p>
                                    </div>
                                </div>
                                <div class="pl-2 col-span-full sm:col-span-3">
                                    <ul class="timeline timeline-vertical">
                                        <li>
                                            <div class="timeline-start">
                                                {{ Carbon::createFromFormat('Y-m-d', $item->fact_date)->format('d/m') }}
                                            </div>
                                            <div class="timeline-middle">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    class="w-5 h-5 {{ $item->fact_date ? 'text-success' : '' }}">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>

                                            <span class="timeline-end timeline-box">
                                                Lançado
                                            </span>

                                            @if ($item->fact_date)
                                                <hr class="bg-success" />
                                            @else
                                                <hr />
                                            @endif
                                        </li>
                                        @if ($item->fafd)
                                            <li>
                                                @if ($item->fact_date)
                                                    <hr class="bg-success" />
                                                @else
                                                    <hr />
                                                @endif
                                                <div class="timeline-start">
                                                    @if ($item->updated_at)
                                                        {{ Carbon::createFromFormat('Y-m-d  H:i:s', $item->updated_at)->format('d/m') }}
                                                    @endif
                                                </div>
                                                <div class="timeline-middle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        class="w-5 h-5 {{ $item->updated_at ? 'text-success' : '' }}">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <span class="timeline-end timeline-box">
                                                    Gerou FAFD nº {{ $item->fafds->number }} /
                                                    {{ $item->fafds->year }}
                                                </span>
                                            </li>
                                        @else
                                            <li>
                                                @if ($item->fact_date)
                                                    <hr class="bg-success" />
                                                @else
                                                    <hr />
                                                @endif
                                                <div class="timeline-start">
                                                    @if ($item->sincomil_date)
                                                        {{ Carbon::createFromFormat('Y-m-d', $item->sincomil_date)->format('d/m') }}
                                                    @endif
                                                </div>
                                                <div class="timeline-middle">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                        class="w-5 h-5 {{ $item->sincomil_date ? 'text-success' : '' }}">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <span class="timeline-end timeline-box">
                                                    SINCOMIL
                                                </span>
                                            </li>
                                        @endif

                                    </ul>
                                </div>

                            </div>
                        </div>
                    </h2>
                </div>
            @endforeach
            <div class="items-center justify-between py-4">
                {{ $dataTable->links() }}
            </div>
        </div>
    </div>

    <x-dialog-modal wire:model="showModalForm" maxWidth="4xl">
        <x-slot name="title">{{ $breadcrumb }} </x-slot>
        <x-slot name="content">
            <x-app.tabs>
                <x-slot name="content">
                    <div id="tab1" x-show="activeTab === '#tab1'">
                        <div class="grid grid-cols-3 gap-0 py-10 mx-4">
                            <div class="flex items-center justify-center p-0 m-0">
                                <a href="#tab2" @click="activeTab = '#tab2'" class="relative inline-flex ">
                                    <div
                                        class="flex w-24 overflow-hidden rounded-tr-2xl rounded-bl-2xl dark:bg-blue-300">
                                        <img src="{{ url('storage/buttons/fo-.png') }}" alt="fo" />
                                    </div>
                                </a>
                            </div>
                            <div class="flex items-center justify-center">
                                <a href="#tab21" @click="activeTab = '#tab21'" class="relative inline-flex ">
                                    <div
                                        class="flex w-24 overflow-hidden rounded-tr-2xl rounded-bl-2xl dark:bg-blue-300">

                                        <img src="{{ url('storage/buttons/fo+.png') }}" alt="fo" />
                                    </div>
                                </a>
                            </div>
                            <div class="flex items-center justify-center">
                                <a href="#tab22" @click="activeTab = '#tab22'" class="relative inline-flex ">
                                    <div
                                        class="flex w-24 overflow-hidden rounded-tr-2xl rounded-bl-2xl dark:bg-blue-300">
                                        <img src="{{ url('storage/buttons/fo!.png') }}" alt="fo" />
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div id="tab2" x-show="activeTab === '#tab2'">
                        @livewire('app.fact-observeds.app-fact-observed-negative')
                    </div>
                    <div id="tab21" x-show="activeTab === '#tab21'">
                        @livewire('app.fact-observeds.app-fact-observed-positive')
                    </div>
                    <div id="tab22" x-show="activeTab === '#tab22'">
                        @livewire('app.fact-observeds.app-fact-observed-info')
                    </div>
                </x-slot>

                <x-slot name="nav">
                    <footer
                        class="fixed bottom-0 left-0 flex justify-around w-full p-3 bg-white border-t shadow-md dark:bg-gray-800">

                    </footer>
                </x-slot>
            </x-app.tabs>
        </x-slot>
        <x-slot name="footer">

        </x-slot>
    </x-dialog-modal>


</div>
