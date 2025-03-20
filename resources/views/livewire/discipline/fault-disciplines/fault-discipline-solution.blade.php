<div wire:ignore>
    <div class="flex items-center justify-center w-full mb-5 space-x-1">
        <span wire:ignore wire:click="print()" class="btn btn-info">
            Imprimir Solução
            <svg class="w-6 h-6 mr-0 lg:mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V11C20.6569 11 22 12.3431 22 14V18C22 19.6569 20.6569 21 19 21H5C3.34314 21 2 19.6569 2 18V14C2 12.3431 3.34315 11 5 11V5ZM5 13C4.44772 13 4 13.4477 4 14V18C4 18.5523 4.44772 19 5 19H19C19.5523 19 20 18.5523 20 18V14C20 13.4477 19.5523 13 19 13V15C19 15.5523 18.5523 16 18 16H6C5.44772 16 5 15.5523 5 15V13ZM7 6V12V14H17V12V6H7ZM9 9C9 8.44772 9.44772 8 10 8H14C14.5523 8 15 8.44772 15 9C15 9.55228 14.5523 10 14 10H10C9.44772 10 9 9.55228 9 9ZM9 12C9 11.4477 9.44772 11 10 11H14C14.5523 11 15 11.4477 15 12C15 12.5523 14.5523 13 14 13H10C9.44772 13 9 12.5523 9 12Z"
                    fill="currentColor" />
            </svg>
        </span>
        @if ($paste)
            <span wire:click="excluirDoc()" class="btn btn-outline btn-error">
                Excluir
                <svg class="w-6 h-6 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </span>
            <a class="btn btn-outline" download
                href="{{ url('storage/fafd/' . $fault_discipline->id . '/fafd_n_solucao_' . $fault_discipline->id . '.pdf') }}">
                Baixar solução (assinada)
                <svg class="w-6 h-6 mr-0 lg:mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V11C20.6569 11 22 12.3431 22 14V18C22 19.6569 20.6569 21 19 21H5C3.34314 21 2 19.6569 2 18V14C2 12.3431 3.34315 11 5 11V5ZM5 13C4.44772 13 4 13.4477 4 14V18C4 18.5523 4.44772 19 5 19H19C19.5523 19 20 18.5523 20 18V14C20 13.4477 19.5523 13 19 13V15C19 15.5523 18.5523 16 18 16H6C5.44772 16 5 15.5523 5 15V13ZM7 6V12V14H17V12V6H7ZM9 9C9 8.44772 9.44772 8 10 8H14C14.5523 8 15 8.44772 15 9C15 9.55228 14.5523 10 14 10H10C9.44772 10 9 9.55228 9 9ZM9 12C9 11.4477 9.44772 11 10 11H14C14.5523 11 15 11.4477 15 12C15 12.5523 14.5523 13 14 13H10C9.44772 13 9 12.5523 9 12Z"
                        fill="currentColor" />
                </svg>
            </a>
        @endif
    </div>
    <div class="w-full">
        <div>
            @if ($paste)
                <object
                    data="{{ url('storage/fafd/' . $fault_discipline->id . '/fafd_n_solucao_' . $fault_discipline->id . '.pdf') }}"
                    type="application/pdf" class="w-full" height="600">
                    <p>Seu navegador não suporta visualização de PDF.</p>
                </object>
            @else
                <div class="col-span-full sm:col-span-3">
                    <form wire:submit.prevent="#" id="form-upload-solution">
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">Clique
                                            ou </span> arraste e solte</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        somente PDF</p>
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
                                        <progress x-bind:value="progress" class="w-56 progress progress-primary"
                                            value="0" max="100"></progress>
                                    </div>
                                    <div wire:loading wire:target="uploadPdf">Enviando...</div>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" />
                            </label>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>
    <div wire:ignore>
        @section('scripts')
            <script>
                document.addEventListener('livewire:init', () => {
                    Livewire.on('openPdfInNewTab', ({
                        pdfPath
                    }) => {
                        window.open(pdfPath, '_blank');
                    })
                })
            </script>
        @endsection
    </div>
</div>
