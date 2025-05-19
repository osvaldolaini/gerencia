<!DOCTYPE html>
<html lang="pt-BR">
@php

    use App\Enums\Penalty;
@endphp

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        .container {
            margin-top: 50px;
            padding-top: 50px;
        }

        .class {
            width: 100%;
            font-size: 12pt;
        }

        .turmas-table {

            width: 100%;
            font-size: 12pt;
        }

        .border {
            border: solid thin #000;
        }

        .w-20 {
            min-width: 20%;
        }

        .w-10 {
            min-width: 10%;
        }

        .header {
            font-size: 20px;
        }

        .turma-wrapper {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .turmas-table {
            width: 100%;

            border-collapse: collapse;
        }
    </style>
    <x-app.favicons></x-app.favicons>

</head>

<body>
    <div class="container">
        @if ($title == 'Justificativa')
            <div>
                <h2 style="text-align: center;padding:20px;">Aguardando {{ $title }}</h2>
            </div>
            <table class="turmas-table">
                <tr class="class">
                    <td class="text-left border">FAFD Nº</td>
                    <td class="text-left border">Nr</td>
                    <td class="text-left border">Aluno</td>
                    <td class="text-left border">Turma</td>
                    <td class="text-center border">Data prevista</td>
                </tr>
                @php
                    $c = 0;
                @endphp
                @foreach ($data as $fafd)
                    @php
                        $c += 1;
                    @endphp
                    <tr class="class">
                        <td class="text-left border">{{ $fafd->number }}/{{ $fafd->year }}</td>
                        <td class="text-left border">{{ $fafd?->students?->number }}</td>
                        <td class="text-left border">{{ $fafd?->students?->nick }}</td>
                        <td class="text-left border">{{ $fafd?->students?->al_class->title }}</td>
                        <td class="text-center border">{{ $fafd->deliv_date }}</td>
                    </tr>
                @endforeach
                <tr class="border">
                    <td colspan="4" class="text-right border">Total</td>
                    <td class="text-center border">{{ $c }}</td>
                </tr>
            </table>
        @endif
        @if ($title == 'Solução')
            <div>
                <h2 style="text-align: center;padding:20px;">Aguardando {{ $title }}</h2>
            </div>
            <table class="turmas-table">
                <tr class="class">
                    <td class="text-left border">FAFD Nº</td>
                    <td class="text-left border">Nr</td>
                    <td class="text-left border">Aluno</td>
                    <td class="text-left border">Turma</td>
                    <td class="text-center border">Data justificativa</td>
                </tr>
                @php
                    $c = 0;
                @endphp
                @foreach ($data as $fafd)
                    @php
                        $c += 1;
                    @endphp
                    <tr class="class">
                        <td class="text-left border">{{ $fafd->number }}/{{ $fafd->year }}</td>
                        <td class="text-left border">{{ $fafd?->students?->number }}</td>
                        <td class="text-left border">{{ $fafd?->students?->nick }}</td>
                        <td class="text-left border">{{ $fafd?->students?->al_class->title }}</td>
                        <td class="text-center border">{{ $fafd->just_date }}</td>
                    </tr>
                @endforeach
                <tr class="border">
                    <td colspan="4" class="text-right border">Total</td>
                    <td class="text-center border">{{ $c }}</td>
                </tr>
            </table>
        @endif
        @if ($title == 'Publicação')
            <div>
                <h2 style="text-align: center;">Aguardando {{ $title }}</h2>
            </div>
            @php
                $c = 0;
            @endphp
            @foreach ($data as $fafd)
                @php
                    $c += 1;
                @endphp
                <div style="padding: 5px 5px; text-align:justify; text-indent:1.5cm;">
                    {{ $fafd->bi_number }}
                    Em {{ $fafd->f_date }}, Al Nr {{ $fafd->al_number }},
                    {{ $fafd->al_name ? $fafd->al_name . '(' . $fafd->al_nick . ')' : $fafd->al_nick }},
                    turma {{ $fafd->al_class }} -
                    Motivo: {{ $fafd->solution }} Falta disciplinar nº @if (is_array($fafd->faults) && count($fafd->faults) > 0)
                        @foreach ($fafd->faults as $fafd->key => $fafd->item)
                            {{ $fafd->item }}@if ($fafd->loop->remaining === 1)
                                e
                            @elseif (!$fafd->loop->last)
                                ,
                            @endif
                        @endforeach
                        @endif, @if (is_array($fafd->aggravating) && count($fafd->aggravating) > 0)
                            com agravante(s) nr
                            @foreach ($fafd->aggravating as $fafd->key => $fafd->item)
                                {{ $fafd->item }}
                                @if ($fafd->loop->remaining === 1)
                                    e
                                @else
                                    ,
                                @endif
                            @endforeach
                        @else
                            sem agravantes,
                            @endif @if (is_array($fafd->mitigating) && count($fafd->mitigating) > 0)
                                com atenuante(s) nr
                                @foreach ($fafd->mitigating as $fafd->key => $fafd->item)
                                    {{ $fafd->item }}
                                    @if ($fafd->loop->remaining === 1)
                                        e
                                    @else
                                        ,
                                    @endif
                                @endforeach
                            @else
                                sem atenuante,
                            @endif
                            previstos no apêndice 1 do anexo F do RICM 2024,
                            @if ($fafd->repeat == 0)
                                {{ $fafd->repeat }}
                                @endif sendo reincidente, @if ($fafd->repeat == 1)
                                    {{ $fafd->repeat_number }} vezes
                                @endif em faltas
                                desta
                                natureza. - Medida disciplinar: @if ($fafd->dacision_days)
                                    {{ $fafd->dacision_days }}
                                    dia{{ $fafd->dacision_days > 1 ? 's' : '' }} de
                                @endif
                                @if ($fafd->decision)
                                    {{ Penalty::fromDb($fafd->decision)?->label() ?? 'Advertência' }} (FAFD
                                    nº
                                    {{ $fafd->number }}/{{ $fafd->year }} - {{ $fafd->cia }}
                                @endif
                                ,
                                de
                                {{ $fafd->f_date }}) grau atualizado {{ $fafd->students->adjusted_grau }}.

                </div>
            @endforeach
        @endif


    </div>
</body>

</html>
