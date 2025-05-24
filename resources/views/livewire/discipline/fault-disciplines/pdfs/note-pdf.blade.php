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
    </style>
    <title>{{ $title_postfix }} </title>
</head>

<body>

    <div class="container">
        <div class="header">
            <table class="identification">
                <tr>
                    <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                        NOTA DE PUNIÇÃO
                    </td>
                </tr>


            </table>
            <div style="padding: 5px 5px; text-align:justify; text-indent:1.5cm;">

                Em {{ $fault_discipline->f_date }}, Al Nr {{ $fault_discipline->al_number }},
                {{ $fault_discipline->al_name ? $fault_discipline->al_name . '(' . $fault_discipline->al_nick . ')' : $fault_discipline->al_nick }},
                turma {{ $fault_discipline->al_class }} -
                Motivo: {{ $fault_discipline->solution }} Falta disciplinar nº @if (is_array($fault_discipline->faults) && count($fault_discipline->faults) > 0)
                    @foreach ($fault_discipline->faults as $fault_discipline->key => $fault_discipline->item)
                        {{ $fault_discipline->item }}@if ($fault_discipline->loop->remaining === 1)
                            e
                        @elseif (!$fault_discipline->loop->last)
                            ,
                        @endif
                    @endforeach
                    @endif, @if (is_array($fault_discipline->aggravating) && count($fault_discipline->aggravating) > 0)
                        com agravante(s) nr
                        @foreach ($fault_discipline->aggravating as $fault_discipline->key => $fault_discipline->item)
                            {{ $fault_discipline->item }}
                            @if ($fault_discipline->loop->remaining === 1)
                                e
                            @else
                                ,
                            @endif
                        @endforeach
                    @else
                        sem agravantes,
                        @endif @if (is_array($fault_discipline->mitigating) && count($fault_discipline->mitigating) > 0)
                            com atenuante(s) nr
                            @foreach ($fault_discipline->mitigating as $fault_discipline->key => $fault_discipline->item)
                                {{ $fault_discipline->item }}
                                @if ($fault_discipline->loop->remaining === 1)
                                    e
                                @else
                                    ,
                                @endif
                            @endforeach
                        @else
                            sem atenuante,
                        @endif
                        previstos no apêndice 1 do anexo F do RICM 2024,
                        @if ($fault_discipline->repeat == 0)
                            {{ $fault_discipline->repeat }}
                            @endif sendo reincidente, @if ($fault_discipline->repeat == 1)
                                {{ $fault_discipline->repeat_number }} vezes
                            @endif em faltas
                            desta
                            natureza. - Medida disciplinar: @if ($fault_discipline->dacision_days)
                                {{ $fault_discipline->dacision_days }}
                                dia{{ $fault_discipline->dacision_days > 1 ? 's' : '' }} de
                            @endif
                            @if ($fault_discipline->decision)
                                {{ Penalty::fromDb($fault_discipline->decision)?->label() ?? 'Advertência' }} (FAFD
                                nº
                                {{ $fault_discipline->number }}/{{ $fault_discipline->year }} -
                                {{ $fault_discipline->cia }}
                            @endif
                            ,
                            de
                            {{ $fault_discipline->f_date }}) - Grau de comportamento
                            {{ $fault_discipline->student->calculateAdjustedGrau(Carbon::parse($fault_discipline->bi_date)) }}.

            </div>

            <table class="identification">
                <tr>
                    <td colspan="2" style="border-top: 1px solid black;border-right: 1px solid">
                        Nota p/Bol Nr: {{ $fault_discipline->supplement_number }} / {{ $fault_discipline->bi_number }}
                    </td>
                    <td colspan="1" style="border-top: 1px solid black;border-right: 1px solid">
                        BAR Nr _____________
                    </td>
                    <td colspan="1" style="border-top: 1px solid black;border-right: 1px solid">
                        FIOD Nr
                    </td>
                    <td colspan="2" style="border-top: 1px solid black;border-right: 1px solid">
                        Grau de Comportamento:
                        {{ $fault_discipline->student->calculateAdjustedGrau(Carbon::parse($fault_discipline->bi_date)) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid">
                        Lançamento no SINCOMIL em
                        {{ $fault_discipline->sin_date ? $fault_discipline->sin_date : '___/____/20___' }}
                    </td>
                    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid">
                        Rubrica Sgtte: _________________________________
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
