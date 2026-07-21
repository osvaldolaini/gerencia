<div class="border shadow-sm card bg-base-100 border-base-300">

    <div class="card-body">
        <h2 class="justify-center block text-center sm:text-left sm:justify-start sm:flex card-title">
            <x-layout.svg.shield-check class="w-6 h-6 mx-auto text-success" />
            Verificar autenticidade de documento
        </h2>

        <p class="mb-4 text-sm text-center opacity-70">
            Se você recebeu o documento digital e quer verificar autenticidade, arraste o PDF ou
            clique abaixo para selecioná-lo.
            O sistema verificará se o arquivo corresponde exatamente ao
            documento oficial emitido.
        </p>


        @if (!$result && !$verifying)
            {{-- Área de Upload --}}
            <label
                class="flex flex-col items-center justify-center w-full transition border-2 border-dashed rounded-lg cursor-pointer h-52 border-base-300 hover:border-primary"
                x-data="{ dragging: false }" @dragover.prevent="dragging=true" @dragleave.prevent="dragging=false"
                @drop.prevent="
                    dragging=false;
                    $refs.file.files = $event.dataTransfer.files;
                    $refs.file.dispatchEvent(new Event('change'))
                "
                :class="dragging ? 'border-primary bg-primary/5' : ''">
                <input x-ref="file" id="verificationFile" type="file" wire:model="file" accept="application/pdf"
                    class="hidden" id="verify-file">
                <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-3 opacity-50" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 16V4m0 0l-4 4m4-4l4 4M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2" />

                    </svg>

                    <div class="font-semibold" x-show="!dragging">
                        Arraste um PDF ou clique para selecionar
                    </div>

                    <div class="text-sm opacity-70" x-show="dragging">
                        Será feita a verificação automática após o envio.
                    </div>
                </div>

            </label>
            @error('file')
                <span class="mt-2 text-error">
                    {{ $message }}
                </span>
            @enderror
        @endif



        @if ($verifying)
            <div class="p-8 text-center border rounded-xl">

                <span class="loading loading-spinner loading-lg text-primary"></span>

                <div class="mt-5 text-lg font-semibold">
                    Verificando autenticidade...
                </div>

                <div class="mt-2 opacity-70">
                    Aguarde alguns instantes.
                </div>

            </div>
        @endif

        @if ($result === true)
            <div class="alert alert-success">
                ✅ Documento íntegro. O arquivo não foi alterado.
            </div>
        @elseif ($result === false)
            <div class="alert alert-error">
                ❌ O arquivo foi alterado ou não corresponde ao documento oficial.
            </div>
        @endif
        @if ($result)
            <button wire:click="resetVerification" class="mt-4 btn dark:btn-outline btn-info btn-lg">
                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-3 opacity-50"
                    viewBox="0 0 512 512" data-name="Layer 1" id="Layer_1" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M64,256H34A222,222,0,0,1,430,118.15V85h30V190H355V160h67.27A192.21,192.21,0,0,0,256,64C150.13,64,64,150.13,64,256Zm384,0c0,105.87-86.13,192-192,192A192.21,192.21,0,0,1,89.73,352H157V322H52V427H82V393.85A222,222,0,0,0,478,256Z" />
                </svg>
                Verificar outro documento

            </button>
        @endif

    </div>

</div>
