<div>
    @php
        use Carbon\Carbon;
        use App\Enums\SchoolFault;
    @endphp
    <form>
        <x-layout.tabs>
            <x-slot name="nav">
                <x-layout.tabs-nav tab="tab1">
                    <x-slot name="svg">
                        <svg class="w-5 h-5 transition duration-75 shrink-0 text-primary-600 dark:text-primary-400"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </x-slot>
                    <x-slot name="title">{{ $breadcrumb }}</x-slot>
                </x-layout.tabs-nav>
                <x-layout.button-back route="{{ $back }}"></x-layout.button-back>
            </x-slot>
            <x-slot name="content">
                <div id="tab1" x-show="activeTab === '#tab1'" class="block">
                    <div role="tabpanel"
                        class="p-6 border-2 rounded-r-lg rounded-bl-lg bg-base-100 border-base-300 dark:bg-gray-700 dark:text-gray-100">
                        <div class="mb-10 rounded-md cursor-pointer">
                            <h2 id="w-full text-center items-center">
                                <div type="button"
                                    class="items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 dark:bg-gray-900 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <div class="grid grid-cols-6 gap-2 mx-2 ">
                                        <div class="flex justify-between pl-2 col-span-full ">
                                            <div class="p-0">
                                                Falta lançada em
                                                {{ Carbon::createFromFormat('Y-m-d H:i:s', $school_faults->created_at)->format('d/m/Y H:i:s') }}
                                                por {{ $school_faults->created_by }}.
                                            </div>
                                        </div>
                                        <div class="pl-2 col-span-full sm:col-span-1">
                                            @if ($school_faults->students)
                                                @if ($school_faults->students->logo_path)
                                                    <img src="{{ url('storage/student/' . $school_faults->students->id . '/' . $school_faults->students->logo_path) }}"
                                                        class="mx-auto rounded-md">
                                                @else
                                                    <x-application-logo width="h-12"></x-application-logo>
                                                @endif
                                            @else
                                                <x-application-logo width="h-12"></x-application-logo>
                                            @endif
                                        </div>
                                        <div class="col-span-full sm:col-span-3">
                                            <h1 class="text-3xl font-bold">
                                                Al. {{ $school_faults->students->nick }}
                                            </h1>
                                            <div class="max-w-xs">
                                                <p>
                                                    nº. {{ $school_faults->students->number }}
                                                </p>
                                                <p>
                                                    T. {{ $school_faults->students->al_class->title }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="pl-2 space-y-2 col-span-full sm:col-span-2">
                                            <span class="btn btn-outline dark:btn-success btn-sm ">
                                                Data {{ $school_faults->date_view }}
                                            </span>
                                            <span class="btn btn-outline dark:btn-success btn-sm">
                                                {{ $school_faults->qtd }}
                                                período{{ $school_faults->qtd > 1 ? 's' : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </h2>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mb-1 sm:grid-cols-6 sm:gap-3 sm:mb-5">
                            <div class="col-span-full ">
                                @foreach (SchoolFault::cases() as $item)
                                    <div class="p-0 tooltip tooltip-top" data-tip="{{ $item->label() }}">
                                        <label
                                            class="flex flex-col mx-auto justify-center px-3 py-2 transition-colors duration-200
                                        rounded-md cursor-pointer
                                        {{ $item->value == $justified ? 'bg-blue-500 text-gray-800' : 'bg-gray-800 text-white dark:bg-gray-100 dark:text-gray-900' }}">
                                            <input type="radio" wire:model.live="justified"
                                                value="{{ $item->value }}" class="hidden peer"
                                                {{ $item->value == $justified ? 'checked' : '' }}>

                                            <span class="text-xs">
                                                {{ $item->label() }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            {{-- <div class="col-span-full sm:col-span-1">
                                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="title">
                                    Justificado?
                                </label>
                                <x-layout.toggle-true-false id="justified"
                                    active="{{ $justified }}"></x-layout.toggle-true-false>
                                @error('justified')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            @if ($justified == 1)
                                <div class="col-span-full sm:col-span-full ">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white"
                                        for="title">
                                        Relato
                                    </label>
                                    <textarea wire:model="text" rows="10"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>
                                    @error('text')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-span-full">
                                    <div>
                                        @if ($paste == true)
                                            <div class="col-span-full ">
                                                <span wire:click="excluirDoc()" class="btn btn-outline btn-error">
                                                    Excluir
                                                    <svg class="w-6 h-6 mr-1 -ml-1" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <object
                                                data="{{ url('storage/school_faults/' . $school_faults->id . '/' . $school_faults->logo_path) }}"
                                                type="application/pdf" class="w-full" height="600">
                                                <p>Seu navegador não suporta visualização de PDF.</p>
                                            </object>
                                        @else
                                            <div class="col-span-full ">
                                                <form wire:submit.prevent="#" id="form-upload-solution">
                                                    <div class="flex items-center justify-center w-full">
                                                        <label for="dropzone-file"
                                                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                            <div
                                                                class="flex flex-col items-center justify-center pt-5 pb-6">
                                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 20 16">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                                </svg>
                                                                <p
                                                                    class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                                    <span class="font-semibold">Clique
                                                                        ou </span> arraste e solte
                                                                </p>
                                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                    somente (pdf,jpg,jpeg,png)</p>
                                                            </div>
                                                            <div class="col-span-1" x-data="{ isUploading: false, progress: 0 }"
                                                                x-on:livewire-upload-start="isUploading = true"
                                                                x-on:livewire-upload-finish="isUploading = false"
                                                                x-on:livewire-upload-error="isUploading = false"
                                                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                                <!-- File Input -->
                                                                <input id="dropzone-file" type="file" class="hidden"
                                                                    wire:model.lazy="uploadPdf" />

                                                                @error('uploadPdf')
                                                                    <span class="error">{{ $message }}</span>
                                                                @enderror

                                                                <!-- Progress Bar -->
                                                                <div x-show="isUploading">
                                                                    <progress x-bind:value="progress"
                                                                        class="w-56 progress progress-primary"
                                                                        value="0" max="100"></progress>
                                                                </div>
                                                                <div wire:loading wire:target="uploadPdf">Enviando...
                                                                </div>
                                                            </div>
                                                            <input id="dropzone-file" type="file"
                                                                class="hidden" />
                                                        </label>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                    </div>

                                </div>
                            @endif


                        </div>
                    </div>
                </div>

            </x-slot>
        </x-layout.tabs>
    </form>
    <div class="px-4 text-right">
        <button type="submit" wire:click="save"
            class="text-white
                        bg-blue-700 hover:bg-blue-800
                        focus:ring-4 focus:outline-none focus:ring-blue-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-blue-600 dark:hover:bg-blue-700
                        dark:focus:ring-blue-800">
            Salvar
        </button>
        <button type="submit" wire:click="save_out"
            class="text-white
                        bg-green-700 hover:bg-green-800
                        focus:ring-4 focus:outline-none focus:ring-green-300
                        font-medium rounded-lg text-sm px-5 py-2.5
                        text-center dark:bg-green-600 dark:hover:bg-green-700
                        dark:focus:ring-green-800">
            Salvar e sair
        </button>
    </div>
</div>
