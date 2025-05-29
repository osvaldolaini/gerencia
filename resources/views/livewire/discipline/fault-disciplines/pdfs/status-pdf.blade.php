<!DOCTYPE html>
<html lang="pt-BR">
@php

    use App\Enums\Penalty;

    use Carbon\Carbon;
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
                $decision = 'null';
                $newdecision = 'advertencia';
            @endphp
            @foreach ($data as $fafd)
                @if ($newdecision != $decision)
                    @php
                        $decision = $newdecision;
                    @endphp
                    <h2>{{ strtoupper($newdecision) }}</h2>
                @endif
                @php
                    $c += 1;
                    $newdecision = $fafd->decision;
                @endphp
                <div style="padding: 5px 5px; text-align:justify; text-indent:1.5cm;">
                    {{ $fafd->note }}
                </div>
            @endforeach
        @endif


    </div>
</body>

</html>
