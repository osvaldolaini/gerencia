<div class="min-h-screen bg-base-200">

    <div class="max-w-5xl px-4 py-10 mx-auto">

        {{-- Cabeçalho --}}
        <div class="mb-8 text-center">

            <img src="{{ asset('storage/logos/brasao-brasil-preto-e-branco.png') }}" class="w-20 mx-auto mb-4">

            <h1 class="text-3xl font-bold">
                Verificação de Documento Oficial
            </h1>
            <p class="mt-2 text-base-content/70">
                Este documento foi emitido e assinado digitalmente.
            </p>


        </div>

        {{-- Status --}}
        <div class="mb-6 shadow-xl card bg-base-100">
            <div class="card-body">
                <p class="mt-2 text-base-content/70">
                    @if ($document->isValid())
                        <div class="alert alert-success">
                            <span>
                                Este documento é autêntico e sua integridade foi validada.
                            </span>
                        </div>
                    @else
                        <div class="alert alert-error">
                            <span>
                                Atenção! O arquivo oficial foi alterado ou está corrompido.
                            </span>
                        </div>
                    @endif
                </p>

            </div>

        </div>

        {{-- Status --}}
        <div class="mb-6 shadow-xl card bg-base-100">
            <div class="card-body grid grid-cols-2">
                <div class="flex items-center gap-4">
                    <div class="text-5xl">

                        @if ($document->status->isCompleted())
                            ✅
                        @elseif($document->status->isCancelled())
                            ❌
                        @else
                            ⏳
                        @endif

                    </div>
                    <div>

                        <h2 class="text-xl font-bold">
                            {{ $document->status->label() }}
                        </h2>

                        <p class="opacity-70">
                            UUID:
                            {{ $document->uuid }}
                        </p>

                    </div>
                </div>
                <div class="text-right">
                    @if ($document->status->isCompleted())
                        {{-- Download --}}
                        <div class="text-right">
                            <button wire:click="download" class="btn btn-primary btn-lg">
                                📄 Baixar PDF Oficial
                            </button>
                        </div>
                    @elseif($document->status->isCancelled())
                        @if ($document->replacedBy)
                            <a href="{{ route('documents.show', $document->replacedBy->uuid) }}" target="_blank"
                                class="btn btn-outline dark:btn-info">
                                <x-layout.svg.pdf class="w-8 h-8" />
                                Ir para o documento oficial
                            </a>
                        @else
                            <div class="alert alert-warning">
                                Este documento foi revogado e ainda não possui um documento substituto.
                            </div>
                        @endif

                    @endif

                </div>

            </div>
        </div>
        {{-- File Validatos --}}
        <div class="mb-6 shadow-xl card bg-base-100">
            @livewire('signatures.document-file-validator')
        </div>

        {{-- Informações --}}
        <div class="mb-6 shadow-xl card bg-base-100">

            <div class="card-body">

                <h2 class="mb-4 text-xl font-bold">

                    Informações do Documento

                </h2>

                <table class="table">

                    <tbody>

                        <tr>
                            <th>Tipo</th>
                            <td>{{ $document->document_type->label() }}</td>
                        </tr>

                        <tr>
                            <th>Documento</th>
                            <td>#{{ $document->document_id }}</td>
                        </tr>

                        <tr>
                            <th>Emitido em</th>
                            <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                        </tr>

                        <tr>
                            <th>Hash SHA-256</th>
                            <td>
                                <code class="text-xs break-all">
                                    {{ $document->hash }}
                                </code>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Assinaturas --}}
        <div class="mb-6 shadow-xl card bg-base-100">

            <div class="card-body">

                <h2 class="mb-4 text-xl font-bold">

                    Assinaturas Digitais

                </h2>

                <div class="space-y-4">

                    @foreach ($document->signatures as $signature)
                        <div class="flex items-center justify-between pb-4 border-b last:border-0">

                            <div>

                                <div class="font-semibold">

                                    {{ $signature->signer->user->name }}

                                </div>

                                <div class="text-sm opacity-70">

                                    {{ $signature->role->label() }}

                                </div>

                            </div>

                            <div class="text-right">

                                <div>

                                    {{ $signature->signed_at->format('d/m/Y') }}

                                </div>

                                <div class="text-sm opacity-70">

                                    {{ $signature->signed_at->format('H:i:s') }}

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>
        {{-- Linha do tempo --}}
        <div class="mb-6 shadow-xl card bg-base-100">
            <div class="card-body">
                <h2 class="mb-4 text-xl font-bold">
                    Linha do tempo
                </h2>
                <ul class="timeline timeline-vertical">
                    {{-- Documento criado --}}
                    <li>
                        <div class="timeline-start text-end">
                            {{ $document->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="timeline-middle">
                            <div class="badge badge-primary badge-sm"></div>
                        </div>
                        <div class="timeline-end pb-8">
                            <strong>Documento criado</strong>
                            <br>
                            {{ $document->creator?->name }}
                        </div>
                        <hr>
                    </li>
                    {{-- Assinaturas --}}
                    @foreach ($document->signatures->sortBy('signed_at') as $signature)
                        <li>

                            <hr>

                            <div class="timeline-start text-end">
                                {{ $signature->signed_at->format('d/m/Y H:i') }}
                            </div>

                            <div class="timeline-middle">
                                <div class="badge badge-success badge-sm"></div>
                            </div>

                            <div class="timeline-end pb-8">

                                <strong>{{ $signature->role->label() }}</strong>

                                <br>

                                {{ $signature->signer->user->name }}

                            </div>

                            <hr>

                        </li>
                    @endforeach
                    {{-- Documento oficial --}}
                    @if ($document->signed_at)
                        <li>
                            <hr>
                            <div class="timeline-start text-end">
                                {{ $document->signed_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="timeline-middle">
                                <div class="badge badge-info badge-sm"></div>
                            </div>
                            <div class="timeline-end pb-8">
                                <strong>Documento oficial gerado</strong>
                            </div>
                            <hr>
                        </li>
                    @endif

                    {{-- Revogado --}}
                    @if ($document->revoked_at)
                        <li>
                            <hr>
                            <div class="timeline-start text-end">
                                {{ $document->revoked_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="timeline-middle">
                                <div class="badge badge-error badge-sm"></div>
                            </div>
                            <div class="timeline-end">
                                <strong>Documento revogado</strong>
                                @if ($document->revocation_reason)
                                    <br>
                                    {{ $document->revocation_reason }}
                                @endif
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
