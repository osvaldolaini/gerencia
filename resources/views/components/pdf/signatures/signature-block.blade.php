@if ($document->signatures->isNotEmpty())
    <div style="margin-top:30px; page-break-inside:avoid;">
        <table width="100%" cellpadding="5" cellspacing="0"
            style="border:1px solid #444;border-collapse:collapse;font-size:8pt;">

            <tr style="background:#efefef;">
                <td colspan="3" align="center">
                    <strong>DOCUMENTO ASSINADO DIGITALMENTE</strong>
                </td>
            </tr>
            <tr>
                {{-- QR Code --}}
                <td width="150" align="center" valign="top" style="border-right:1px solid #444;">
                    {!! $authenticationBlock !!}
                    <br>
                    <small>Escaneie para validar</small>
                </td>

                {{-- Informações --}}
                <td>
                    <table>
                        <tr>
                            <td>
                                <strong>Status</strong>
                            </td>
                            <td>
                                {{ $document->status->label() }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Documento</strong>
                            </td>
                            <td>
                                {{ $document->document_type->label() }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>UUID</strong>
                            </td>
                            <td>
                                {{ $document->uuid }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%" cellpadding="1" cellspacing="0" style="border-collapse:collapse;font-size:7pt;">
            <tr style="background:#efefef;">
                <td width="35%"><strong>Assinante</strong></td>
                <td width="25%"><strong>Função</strong></td>
                <td width="20%"><strong>Data</strong></td>
                <td width="20%"><strong>Status</strong></td>
            </tr>
            @foreach ($document->signatures as $signature)
                <tr>
                    <td>
                        {{ $signature->signer->user?->people->name ?? $signature->signer->user->name }}
                    </td>
                    <td>
                        {{ $signature->role->label() }}
                    </td>
                    <td>
                        {{ $signature->signed_at?->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        ✔ Assinado
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endif
