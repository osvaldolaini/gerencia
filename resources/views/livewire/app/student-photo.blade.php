<div wire:id="{{ $this->getId() }}" id="student-photo" class="max-w-md p-4 mx-auto shadow-xl rounded-box">
    <div class="container flex flex-col items-center justify-center w-full mx-auto">
        <ul class="flex flex-col w-full">

            <li class="flex flex-row w-full mb-2 border-gray-400 cursor-pointer">
                <div
                    class="flex items-center flex-1 p-4 bg-white border rounded-md shadow cursor-pointer select-none dark:bg-gray-800">
                    <div class="flex flex-col items-center justify-center w-10 h-10 mr-4">
                        <span class="relative block">
                            @if ($student->logo_path)
                                <img src="{{ url('storage/student/' . $student->id . '/' . $student->code_image . '_small.png') }}"
                                    class="object-cover w-10 h-10 mx-auto rounded-full ">
                            @else
                                <x-application-logo width="h-12"></x-application-logo>
                            @endif
                        </span>
                    </div>
                    <div class="flex-1 pl-1 md:mr-16">
                        <div class="font-medium dark:text-white">
                            Al {{ $student->nick }} - <span class="badge badge-success">
                                {{ $student->people_class }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-600 dark:text-gray-200">
                            {{ $student->name }}
                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </div>
    <form wire:submit.prevent="save" class="space-y-4 {{ $seePhoto ? 'hidden' : '' }}">
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

            <input type="file" class="hidden" id="upload" wire:model="uploadimage" accept="image/*" />
            {{-- <input type="file" class="hidden" id="upload" wire:model="uploadimage" accept="image/*"
                capture="environment" /> --}}

            @error('foto')
                <span class="block mt-1 text-sm text-error">{{ $message }}</span>
            @enderror
        </div>
        <div wire:loading wire:target="foto" class="mt-4 text-center ">
            <span class="loading loading-spinner loading-lg text-success"></span>
            <p class="mt-2 text-sm text-gray-600">Carregando imagem...</p>
        </div>
        <div class="p-2 mt-4 border rounded-box bg-base-200 {{ $seePhoto ? 'hidden' : '' }}">

            <p class="mb-2 text-sm font-semibold dark:text-white">Ajuste da foto (proporção 3x4)</p>
            <div class="relative w-full h-full bg-white">
                <!-- Foto antiga sobreposta -->
                <div class="absolute inset-0 z-20 bg-white dark:bg-gray-900 {{ $seeOldPhoto ? '' : 'hidden' }} ">
                    <img id="preview-old"
                        src="{{ url('storage/student/' . $student->id . '/' . $student->code_image . '_big.png') }}"
                        class="relative flex justify-center mx-auto rounded ">
                </div>

                <!-- Spinner e texto sobre a imagem antiga -->
                <div wire:loading wire:target="uploadimage"
                    class="absolute inset-0 z-30 flex flex-col items-center justify-center text-sm text-center text-green-500 bg-black rounded">
                    <span class="mb-2 loading loading-spinner loading-lg"></span>
                    <p>Carregando imagem...</p>
                </div>

                <!-- Container da nova imagem para crop -->
                <div wire:ignore class="w-full aspect-[3/4] max-h-80 relative overflow-hidden ">
                    <img id="preview" class="hidden object-cover w-full h-full rounded ">
                    <button id="cropBtn"
                        class="absolute z-30 hidden px-4 py-2 text-white bg-blue-600 rounded bottom-2 right-2">
                        Cortar
                    </button>
                </div>
            </div>


            <div class="flex justify-end mt-2">
                <span onclick="cropImage()" class="cursor-pointer btn btn-sm btn-primary">Usar esta foto</span>
            </div>
        </div>
    </form>
    <div class="{{ $seePhoto ? '' : 'hidden' }}">
        <div class="p-2 mt-4 border rounded-box bg-base-200">
            <div class="relative w-full h-full">
                <!-- Foto antiga sobreposta -->
                <img id="preview-old"
                    src="{{ url('storage/student/' . $student->id . '/' . $student->code_image . '_big.png') }}"
                    class=" overflow-hidden inset-0 z-20 flex justify-center mx-auto rounded-box {{ $seeOldPhoto ? '' : 'hidden' }}">
            </div>
        </div>
    </div>


    <link rel="stylesheet" href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" />
    <script src="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.js"></script>
    <script>
        let cropper;
        const componentId = document.getElementById('student-photo').getAttribute('wire:id');

        document.getElementById('upload').addEventListener('change', (e) => {
            Livewire.dispatch('esconderFotoAntiga');
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    const preview = document.getElementById('preview');
                    preview.src = reader.result;
                    preview.classList.remove('hidden');

                    if (cropper) cropper.destroy();
                    cropper = new Cropper(preview, {
                        aspectRatio: 3 / 4,
                        viewMode: 1,
                        movable: true,
                        zoomable: true,
                        scalable: false,
                        cropBoxResizable: true,
                        cropBoxMovable: true,
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        function cropImage() {
            const canvas = cropper.getCroppedCanvas({
                width: 150,
                height: 200,
            });
            const base64Image = canvas.toDataURL('image/jpeg');
            Livewire.dispatch('cropImage', {
                image: base64Image
            });
            console.log('Imagem cortada enviada');
        }
    </script>

</div>
