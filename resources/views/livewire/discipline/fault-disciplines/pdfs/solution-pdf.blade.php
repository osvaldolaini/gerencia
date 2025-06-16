<!DOCTYPE html>

<head>
    @php

        use App\Enums\Penalty;
    @endphp
    <meta charset="UTF-8">
    <x-favicons></x-favicons>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            border: 1px solid black;
            margin-top: 20px;
        }

        .header {
            width: 100%;
            border: 1px solid black;
        }

        .header table {
            padding: 10px;
            width: 100%;
            border-collapse: collapse;
        }

        .header tr td {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            vertical-align: center;
            font-weight: bold;
        }

        .identification {
            width: 100%;
            border: 1px solid black;
        }

        .identification table {
            padding: 10px;
            width: 100%;
            border-collapse: collapse;
        }

        .identification tr td {
            text-align: left;
            vertical-align: center;
            padding-left: 5px;
            font-weight: thin;
        }

        .title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        .section {
            margin-top: 10px;
            padding: 5px;
            border: 1px solid black;
        }

        .label {
            font-weight: bold;
        }

        .signature {
            margin-top: 20px;
            text-align: center;
        }

        .checkbox {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 1px solid black;
            margin-right: 5px;
        }

        .small-text {
            font-size: 10px;
            text-align: justify;
        }

        p {
            font-size: 10pt;
            text-align: justify;
            text-indent: 2cm;
            width: 100%;
            padding-top: 5px;
        }


        .break-page {
            page-break-before: always;
        }
    </style>
    <title>{{ $title_postfix }} </title>
</head>

<body>

    <div class="container">
        <div class="header">
            <table class="identification">
                <tr>
                    <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                        ANÁLISE E DECISÃO DO CMT CIA SOBRE O FATO OBSERVADO E AS ALEGAÇÕES APRESENTADAS
                    </td>
                </tr>


            </table>
            <div style="padding: 5px 5px;">
                <p>1. Após análise do fato descrito no FAFD Nr
                    {{ $fault_discipline->number }}/{{ $fault_discipline->year }}
                    de {{ $fault_discipline->f_date }},e considerar as alegações prestadas nas justificativas
                    apresentadas por escrito e ouvir o(a) Al {{ $fault_discipline->al_number }}
                    {{ $fault_discipline->al_nick }},
                    concluo que o fato ocorreu da seguinte forma:
                </p>
                <p>{{ $fault_discipline->fact }}</p>
                <p>2. {{ $fault_discipline->solution }}</p>
                @if ($fault_discipline->first)
                    <p>3. Deixo de punir</p>
                @else
                    <p>3. {{ Penalty::from($fault_discipline->decision)->sugestion($fault_discipline->dacision_days) }}
                    </p>
                @endif

            </div>

            <table class="identification">
                <tr>
                    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;">
                        Solução do Cmt 1ª Cia em: {{ $fault_discipline->s_date }}
                    </td>
                    <td colspan="3" style="border-top: 1px solid black;">
                        Assinatura Cmt 1ª Cia: __________________________
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 1px solid black; border-right: 1px solid black;">
                        Enquadramento: Falta Nr

                        @if (is_array($fault_discipline->json_faults) && count($fault_discipline->json_faults) > 0)
                            @foreach ($fault_discipline->json_faults as $key => $item)
                                {{ $item }}@if ($loop->remaining === 1)
                                    e
                                @elseif (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td style="border-top: 1px solid black; border-right: 1px solid black;">
                        Reincidência (
                        {{ $fault_discipline->repeat == 1 ? $fault_discipline->repeat_number . 'x' : '  ' }} )
                    </td>
                    <td style="border-top: 1px solid black; border-right: 1px solid black;">
                        Agravante Nr
                        @if (is_array($fault_discipline->json_aggravating) && count($fault_discipline->json_aggravating) > 0)
                            @foreach ($fault_discipline->json_aggravating as $key => $item)
                                {{ $item }}@if ($loop->remaining === 1)
                                    e
                                @elseif (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @endif

                    </td>
                    <td colspan="2" style="border-top: 1px solid black;">
                        Atenuante Nr
                        @if (is_array($fault_discipline->json_mitigating) && count($fault_discipline->json_mitigating) > 0)
                            @foreach ($fault_discipline->json_mitigating as $key => $item)
                                {{ $item }}@if ($loop->remaining === 1)
                                    e
                                @elseif (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid black;border-right: 1px solid">
                        Elogio (
                        {{ $fault_discipline->decision == 'elogio' ? 'X' : '  ' }} )
                    </td>
                    <td style="border-top: 1px solid black;border-right: 1px solid">
                        Justificado ( {{ $fault_discipline->decision == 'justificado' ? 'X' : '  ' }} )
                    </td>
                    <td style="border-top: 1px solid black;border-right: 1px solid">
                        Advertência ( {{ $fault_discipline->decision == 'advertencia' ? 'X' : '  ' }} )
                    </td>
                    <td style="border-top: 1px solid black;border-right: 1px solid">
                        Repreensão ( {{ $fault_discipline->decision == 'repreensao' ? 'X' : '  ' }} )
                    </td>
                    <td style="border-top: 1px solid black;border-right: 1px solid">
                        AOE
                        {{ $fault_discipline->decision == 'atividade_orientacao_educacional' ? $fault_discipline->dacision_days : '  ' }}
                        dias
                    </td>
                    <td style="border-top: 1px solid black;border-right: 1px solid">
                        Retirada
                        {{ $fault_discipline->decision == 'retirada_cm' ? $fault_discipline->dacision_days : '  ' }}
                        dias
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 1px solid black;border-right: 1px solid">
                        Nota p/Bol Nr: _____
                    </td>
                    <td colspan="1" style="border-top: 1px solid black;border-right: 1px solid">
                        BAR Nr _____________
                    </td>
                    <td colspan="1" style="border-top: 1px solid black;border-right: 1px solid">
                        FIOD Nr
                    </td>
                    <td colspan="2" style="border-top: 1px solid black;border-right: 1px solid">
                        Grau de Comportamento:
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid">
                        Lançamento no SINCOMIL em ___/____/20___
                    </td>
                    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid">
                        Rubrica Sgtte: _________________________________
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @if ($fault_discipline->first)
        {{-- COMANDANTE DO CA --}}
        <div class="break-page"></div>
        <div class="container">
            <div class="header">
                <table class="identification">
                    <tr>
                        <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                            ANÁLISE E DECISÃO DO CMT DO CA SOBRE O FATO OBSERVADO E AS ALEGAÇÕES APRESENTADAS
                        </td>
                    </tr>


                </table>
                <div style="padding: 5px 5px;">
                    <p>1. Após análise do fato descrito no FAFD Nr
                        {{ $fault_discipline->number }}/{{ $fault_discipline->year }}
                        de {{ $fault_discipline->f_date }},e considerar as alegações prestadas nas justificativas
                        apresentadas por escrito e ouvir o(a) Al {{ $fault_discipline->al_number }}
                        {{ $fault_discipline->al_nick }},
                        concluo que o fato ocorreu da seguinte forma:
                    </p>
                    <p>{{ $fault_discipline->fact }}</p>
                    <p>2. {{ $fault_discipline->solution }}</p>
                    <p>3. Deixo de punir</p>
                    </p>
                </div>

                <table class="identification">
                    <tr>
                        <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;">
                            Solução do Cmt do CA em: ______/________/_______
                        </td>
                        <td colspan="3" style="border-top: 1px solid black;">
                            Assinatura Cmt do CA: __________________________
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-top: 1px solid black; border-right: 1px solid black;">
                            Enquadramento: Falta Nr

                            @if (is_array($fault_discipline->json_faults) && count($fault_discipline->json_faults) > 0)
                                @foreach ($fault_discipline->json_faults as $key => $item)
                                    {{ $item }}@if ($loop->remaining === 1)
                                        e
                                    @elseif (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif

                        </td>
                        <td style="border-top: 1px solid black; border-right: 1px solid black;">
                            Reincidência (
                            {{ $fault_discipline->repeat == 1 ? $fault_discipline->repeat_number . 'x' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black; border-right: 1px solid black;">
                            Agravante Nr
                            @if (is_array($fault_discipline->json_aggravating) && count($fault_discipline->json_aggravating) > 0)
                                @foreach ($fault_discipline->json_aggravating as $key => $item)
                                    {{ $item }}@if ($loop->remaining === 1)
                                        e
                                    @elseif (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif

                        </td>
                        <td colspan="2" style="border-top: 1px solid black;">
                            Atenuante Nr
                            @if (is_array($fault_discipline->json_mitigating) && count($fault_discipline->json_mitigating) > 0)
                                @foreach ($fault_discipline->json_mitigating as $key => $item)
                                    {{ $item }}@if ($loop->remaining === 1)
                                        e
                                    @elseif (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Elogio (
                            {{ $fault_discipline->decision == 'elogio' ? 'X' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Justificado ( {{ $fault_discipline->decision == 'justificado' ? 'X' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Advertência ( {{ $fault_discipline->decision == 'advertencia' ? 'X' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Repreensão ( {{ $fault_discipline->decision == 'repreensao' ? 'X' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            AOE
                            {{ $fault_discipline->decision == 'atividade_orientacao_educacional' ? $fault_discipline->dacision_days : '  ' }}
                            dias
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Retirada
                            {{ $fault_discipline->decision == 'retirada_cm' ? $fault_discipline->dacision_days : '  ' }}
                            dias
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-top: 1px solid black;border-right: 1px solid">
                            Nota p/Bol Nr: _____
                        </td>
                        <td colspan="1" style="border-top: 1px solid black;border-right: 1px solid">
                            BAR Nr _____________
                        </td>
                        <td colspan="1" style="border-top: 1px solid black;border-right: 1px solid">
                            FIOD Nr
                        </td>
                        <td colspan="2" style="border-top: 1px solid black;border-right: 1px solid">
                            Grau de Comportamento:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid">
                            Lançamento no SINCOMIL em ___/____/20___
                        </td>
                        <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid">
                            Rubrica Sgtte: _________________________________
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- COMANDANTE DO CA --}}
        <div class="break-page"></div>
        <div class="container">
            <div class="header">
                <table class="identification">
                    <tr>
                        <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                            ANÁLISE E DECISÃO DO CMT DO CM SOBRE O FATO OBSERVADO E AS ALEGAÇÕES APRESENTADAS
                        </td>
                    </tr>


                </table>
                <div style="padding: 5px 5px;">
                    <p>1. Após análise do fato descrito no FAFD Nr
                        {{ $fault_discipline->number }}/{{ $fault_discipline->year }}
                        de {{ $fault_discipline->f_date }},e considerar as alegações prestadas nas justificativas
                        apresentadas por escrito e ouvir o(a) Al {{ $fault_discipline->al_number }}
                        {{ $fault_discipline->al_nick }},
                        concluo que o fato ocorreu da seguinte forma:
                    </p>
                    <p>{{ $fault_discipline->fact }}</p>
                    <p>2. {{ $fault_discipline->solution }}</p>
                    <p>
                        3. Por fim, no uso de minhas atribuições de Comandante de Companhia decido punir o(a) aluno(a)
                        com {{ $fault_discipline->dacision_days }} dia
                        {{ $fault_discipline->dacision_days > 1 ? 's' : '' }} de retirada
                    </p>
                </div>

                <table class="identification">
                    <tr>
                        <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;">
                            Solução do Cmt do CM em: ______/________/_______
                        </td>
                        <td colspan="3" style="border-top: 1px solid black;">
                            Assinatura Cmt do CM: __________________________
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-top: 1px solid black; border-right: 1px solid black;">
                            Enquadramento: Falta Nr

                            @if (is_array($fault_discipline->json_faults) && count($fault_discipline->json_faults) > 0)
                                @foreach ($fault_discipline->json_faults as $key => $item)
                                    {{ $item }}@if ($loop->remaining === 1)
                                        e
                                    @elseif (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif

                        </td>
                        <td style="border-top: 1px solid black; border-right: 1px solid black;">
                            Reincidência (
                            {{ $fault_discipline->repeat == 1 ? $fault_discipline->repeat_number . 'x' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black; border-right: 1px solid black;">
                            Agravante Nr
                            @if (is_array($fault_discipline->json_aggravating) && count($fault_discipline->json_aggravating) > 0)
                                @foreach ($fault_discipline->json_aggravating as $key => $item)
                                    {{ $item }}@if ($loop->remaining === 1)
                                        e
                                    @elseif (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif

                        </td>
                        <td colspan="2" style="border-top: 1px solid black;">
                            Atenuante Nr
                            @if (is_array($fault_discipline->json_mitigating) && count($fault_discipline->json_mitigating) > 0)
                                @foreach ($fault_discipline->json_mitigating as $key => $item)
                                    {{ $item }}@if ($loop->remaining === 1)
                                        e
                                    @elseif (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Elogio (
                            {{ $fault_discipline->decision == 'elogio' ? 'X' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Justificado ( {{ $fault_discipline->decision == 'justificado' ? 'X' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Advertência ( {{ $fault_discipline->decision == 'advertencia' ? 'X' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Repreensão ( {{ $fault_discipline->decision == 'repreensao' ? 'X' : '  ' }} )
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            AOE
                            {{ $fault_discipline->decision == 'atividade_orientacao_educacional' ? $fault_discipline->dacision_days : '  ' }}
                            dias
                        </td>
                        <td style="border-top: 1px solid black;border-right: 1px solid">
                            Retirada
                            {{ $fault_discipline->decision == 'retirada_cm' ? $fault_discipline->dacision_days : '  ' }}
                            dias
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-top: 1px solid black;border-right: 1px solid">
                            Nota p/Bol Nr: _____
                        </td>
                        <td colspan="1" style="border-top: 1px solid black;border-right: 1px solid">
                            BAR Nr _____________
                        </td>
                        <td colspan="1" style="border-top: 1px solid black;border-right: 1px solid">
                            FIOD Nr
                        </td>
                        <td colspan="2" style="border-top: 1px solid black;border-right: 1px solid">
                            Grau de Comportamento:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid">
                            Lançamento no SINCOMIL em ___/____/20___
                        </td>
                        <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid">
                            Rubrica Sgtte: _________________________________
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endif

</body>

</html>
