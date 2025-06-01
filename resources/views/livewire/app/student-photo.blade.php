<div class="max-w-md px-4 mx-auto shadow-xl rounded-box ">

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

    <form wire:submit.prevent="save" class="space-y-4">

        <div>
            <label for="upload"
                class="flex items-center w-full cursor-pointer btn btn-square dark:btn-outline btn-success">
                Tirar Foto
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M-9.5,4h-1.154L-11.789.973A1.506,1.506,0,0,0-13.193,0h-3.614a1.506,1.506,0,0,0-1.4.973L-19.346,4H-20.5A2.5,2.5,0,0,0-23,6.5v7A2.5,2.5,0,0,0-20.5,16h11A2.5,2.5,0,0,0-7,13.5v-7A2.5,2.5,0,0,0-9.5,4Z"
                        transform="translate(23)" />
                </svg>
            </label>

            <input type="file" id="upload" wire:model="foto" accept="image/*" class="hidden" />
            @error('foto')
                <span class="block mt-1 text-sm text-error">{{ $message }}</span>
            @enderror
        </div>

        @if ($foto)
            <div class="p-2 mt-4 border rounded-box" x-data="{ carregandoImagem: true }" x-init="window.addEventListener('livewire:update', () => {
                setTimeout(() => carregandoImagem = false, 300);
            });">

                <p class="mb-2 text-sm font-semibold dark:text-white">Ajuste da foto (proporção 3x4)</p>

                <div class="relative w-full aspect-[3/4] max-h-80 items-center">
                    <template x-if="carregandoImagem">
                        <div
                            class="absolute inset-0 z-50 flex flex-col items-center justify-center bg-black bg-opacity-50 rounded-box">
                            <span class="text-white loading loading-spinner loading-lg"></span>
                            <p class="mt-2 text-sm text-white">Carregando imagem...</p>
                        </div>
                    </template>

                    <img id="image-to-crop" src="{{ $foto->temporaryUrl() }}" alt="Pré-visualização"
                        class="mx-auto max-h-80 rounded-box" />
                </div>

                <div class="flex justify-end mt-2">
                    <button type="button" onclick="cropImage()" class="btn btn-sm btn-primary">Usar esta foto</button>
                </div>
            </div>
        @elseif($old_photo)
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

    </form>

    @if ($foto || $old_photo)
        @push('scripts')
            <script>
                let cropper;

                window.addEventListener('livewire:load', function() {
                    initCropper();
                });

                window.addEventListener('livewire:update', function() {
                    setTimeout(() => {
                        initCropper();
                    }, 300);
                });

                function initCropper() {
                    const image = document.getElementById('image-to-crop');
                    if (!image) return;

                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }

                    function startCropper(img) {
                        cropper = new Cropper(img, {
                            aspectRatio: 3 / 4,
                            viewMode: 1,
                            autoCropArea: 1,
                            responsive: true,
                            movable: true,
                            scalable: false,
                            zoomable: true,
                        });
                        console.log('✅ Cropper iniciado');
                    }

                    const originalSrc = image.src;
                    image.onload = () => {
                        console.log('✅ Imagem carregada');
                        startCropper(image);
                    };
                    image.src = '';
                    image.src = originalSrc;

                    if (image.complete && image.naturalHeight !== 0) {
                        console.log('✅ Imagem já completa, iniciando direto');
                        startCropper(image);
                    }
                }

                Livewire.on('resetCropper', () => {
                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }
                });

                function cropImage() {
                    if (cropper) {
                        cropper.getCroppedCanvas({
                            width: 300,
                            height: 400,
                        }).toBlob(blob => {
                            const reader = new FileReader();
                            reader.onloadend = function() {
                                Livewire.emit('fotoCortada', reader.result);
                            };
                            reader.readAsDataURL(blob);
                        }, 'image/jpeg', 0.9);
                    }
                }
            </script>
        @endpush
    @endif

</div>
