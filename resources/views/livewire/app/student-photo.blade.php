<div class="relative w-full max-w-lg mx-auto">
    <div class="container flex flex-col items-center justify-center w-full mx-auto">
        <ul class="flex flex-col w-full mt-5">
            <li class="flex flex-row w-full mb-2 border-gray-400 cursor-pointer">
                <div
                    class="flex items-center flex-1 p-4 bg-white border rounded-md shadow cursor-pointer select-none dark:bg-gray-800">
                    <div class="flex flex-col items-center justify-center w-10 h-10 mr-4">
                        <span class="relative block">
                            @if ($student->logo_path)
                                <img src="{{ url('storage/student/' . $student->id . '/' . $student->code_image . '_big.png') }}"
                                    class="object-cover w-10 h-10 mx-auto rounded-full ">
                            @else
                                <x-application-logo width="h-12"></x-application-logo>
                            @endif
                        </span>
                    </div>
                    <div class="flex-1 pl-1 md:mr-16">
                        <div class="font-medium dark:text-white">
                            Al {{ $student->nick }} -
                            <span class="badge badge-success">{{ $student->people_class }}</span>
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-200">
                            {{ $student->name }}
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div>
        <label for="upload"
            class="flex items-center w-full cursor-pointer btn btn-square dark:btn-outline btn-success">
            Tirar Foto
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16"
                id="photo-camera-16px" xmlns="http://www.w3.org/2000/svg">
                <path id="Path_62" data-name="Path 62"
                    d="M-9.5,4h-1.154L-11.789.973A1.506,1.506,0,0,0-13.193,0h-3.614a1.506,1.506,0,0,0-1.4.973L-19.346,4H-20.5A2.5,2.5,0,0,0-23,6.5v7A2.5,2.5,0,0,0-20.5,16h11A2.5,2.5,0,0,0-7,13.5v-7A2.5,2.5,0,0,0-9.5,4Zm-7.775-2.675A.5.5,0,0,1-16.807,1h3.614a.5.5,0,0,1,.468.325l1,2.675h-6.556ZM-8,13.5A1.5,1.5,0,0,1-9.5,15h-11A1.5,1.5,0,0,1-22,13.5v-7A1.5,1.5,0,0,1-20.5,5h11A1.5,1.5,0,0,1-8,6.5ZM-15,6a4,4,0,0,0-4,4,4,4,0,0,0,4,4,4,4,0,0,0,4-4A4,4,0,0,0-15,6Zm0,7a3,3,0,0,1-3-3,3,3,0,0,1,3-3,3,3,0,0,1,3,3A3,3,0,0,1-15,13Zm.5-4.5A.5.5,0,0,1-15,9a1,1,0,0,0-1,1,.5.5,0,0,1-.5.5A.5.5,0,0,1-17,10a2,2,0,0,1,2-2A.5.5,0,0,1-14.5,8.5Z"
                    transform="translate(23)" />
            </svg>
        </label>

        <input type="file" id="upload" wire:model="foto" accept="image/*" class="hidden" />
        @error('foto')
            <span class="block mt-1 text-sm text-error">{{ $message }}</span>
        @enderror
    </div>
    {{-- Preview da Imagem --}}
    @if ($foto)
        <div class="relative">
            <div wire:loading.class="flex" wire:target="foto"
                class="absolute inset-0 z-50 items-center justify-center hidden bg-black bg-opacity-50 rounded-box">
                <span class="text-white loading loading-spinner loading-lg"></span>
                <p class="mt-2 text-sm text-white">Carregando imagem...</p>
            </div>

            <img id="image-to-crop" src="{{ $foto->temporaryUrl() }}" alt="Imagem para cortar"
                class="h-auto max-w-full rounded-box">

            <button wire:click="removerFoto"
                class="absolute px-2 py-1 text-xs text-white bg-red-500 rounded top-2 right-2">Remover</button>
        </div>
    @else
        <div class="p-2 mt-4 border rounded-box">
            <p class="mb-2 text-sm font-semibold dark:text-white">Ajuste da foto (proporção 3x4)</p>

            <div class="relative w-full aspect-[3/4] max-h-80 items-center">
                <div wire:loading wire:target="foto"
                    class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-black bg-opacity-50 rounded-box">
                    <span class="text-white loading loading-spinner loading-lg"></span>
                    <p class="mt-2 text-sm text-white">Carregando imagem...</p>
                </div>
                <img id="image-to-crop" src="{{ url('storage/student/' . $old_photo) }}" alt="Pré-visualização"
                    class="mx-auto max-h-80 rounded-box" />
            </div>

            <div class="flex justify-end mt-2">
                <button type="button" onclick="cropImage()" class="btn btn-sm btn-primary">Usar esta foto</button>
            </div>
        </div>
    @endif

    {{-- Botão de cortar --}}
    @if ($foto)
        <button onclick="cropImage()" class="w-full mt-4 btn btn-primary">Cortar Imagem</button>
    @endif
</div>

@push('scripts')
    <script>
        let cropper;

        function initCropper() {
            const image = document.getElementById('image-to-crop');

            if (image) {
                // Garante que a imagem está carregada
                if (image.complete && image.naturalHeight !== 0) {
                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 1,
                    });
                    console.log('✅ Cropper iniciado com sucesso');
                } else {
                    console.warn("⚠️ Imagem ainda não carregada completamente para iniciar o Cropper");
                }
            }
        }

        function cropImage() {
            if (cropper) {
                cropper.getCroppedCanvas().toBlob((blob) => {
                    Livewire.emit('fotoCortada', blob);
                });
            } else {
                console.error("❌ Cropper não foi iniciado corretamente");
            }
        }

        window.addEventListener('livewire:update', function() {
            setTimeout(() => {
                const image = document.getElementById('image-to-crop');
                if (image && image.complete && image.naturalHeight !== 0) {
                    initCropper();
                } else {
                    console.warn('⚠️ Tentativa de iniciar o cropper antes da imagem carregar');
                }
            }, 600); // Tempo maior para garantir o carregamento
        });

        // Logs para depuração de loading
        Livewire.hook('message.sent', () => {
            console.log('📤 Livewire: mensagem enviada');
        });

        Livewire.hook('message.processed', () => {
            console.log('✅ Livewire: mensagem processada');
        });
    </script>
@endpush
