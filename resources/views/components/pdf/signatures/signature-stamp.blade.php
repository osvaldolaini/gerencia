<table width="100%" cellpadding="4" cellspacing="0"
    style="border:1px solid #666;border-collapse:collapse;font-size:7pt;margin-top:5px;">

    <tr>
        {{-- QR Code --}}
        <td width="20%" align="center" valign="middle" style="border-right:1px solid #666;padding:6px;">
            {!! $authenticationBlock !!}
        </td>

        {{-- Informações --}}
        <td width="80%" valign="top">

            <div style="font-size:7pt;font-weight:bold;">
                Documento assinado digitalmente
            </div>

            <div style="margin-top:2px;">
                Este documento foi assinado eletronicamente pelo sistema
                <strong>{{ config('app.name') }}</strong>.
            </div>

            <div style="margin-top:2px;">
                <strong>Assinante:</strong>
                {{ $document->signatures->last()?->signer->user->name }}
            </div>

            <div>
                <strong>Data:</strong>
                {{ optional($document->signed_at)->format('d/m/Y H:i:s') }}
            </div>

            <div>
                <strong>Código:</strong>
                {{ $document->uuid }}
            </div>

            <div style="font-size:6pt;color:#444;">
                Para validar este documento, aponte a câmera do celular para o
                QR Code ou acesse o endereço indicado.
            </div>

        </td>
    </tr>

</table>
