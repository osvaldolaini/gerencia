<!DOCTYPE html>
<html lang="pt-BR">
@php
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
    $date = DateTime::createFromFormat('Y-m-d', $student->birthday);
    $birth = strftime('%d de %B de %Y', $date->getTimestamp());
    $article = $student->sex == 'F' ? 'a' : 'o';
    $level = $student->al_class->classGrade->nick >= 600 ? 'Fundamental' : 'Médio';
    $d = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
    $today = strftime('%d de %B de %Y', $d->getTimestamp());
    use App\Enums\MilitaryRank;
@endphp

<head>
    <meta charset="UTF-8">
    <title>Certidão de Matrícula</title>
    <style>
        .container {
            padding-top: 150px;
            width: 100%;
        }

        body {
            font-family: sans-serif;
            font-size: 12pt;
        }

        h2 {
            margin-top: 5px;
        }

        th,
        .reports td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .table-signature {
            margin-top: 50px;
            font-size: 10pt;
            text-align: center;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <p style="text-align: center;">
            <strong><u>DECLARAÇÃO</u></strong>
        </p>
        <div style="text-align:justify;text-indent:1.5em;margin:5px;">
            Declaro, para fins de confecção da Carteira Estudantil, que <strong>{{ $student->name }}</strong>
            é alun{{ $article }} do <strong>{{ $config->name }}</strong> e está matriculado
            no <strong>{{ strtolower($student->al_class->classGrade->name) }}</strong> do <strong>Ensino
                {{ $level }}</strong>
            no ano letivo de {{ date('Y') }}, com atividades presenciais compreendidas
            no período de 09 de Fevereiro a 30 de Dezembro de {{ date('Y') }}.
        </div>
        <div style="text-align:right;padding-top:50px;">
            {{ $config->city }}-{{ $config->state }}, {{ $today }}.
        </div>
        <table class="table-signature">
            <tr>
                <td>

                </td>
                <td>
                    <p style="border-top: solid thin #000; width:100%;"></p>
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">
                    {{-- Imagem da assinatura acima do texto --}}
                    @if ($signature)
                        <img src="{{ $signature }}" style="width: 150px; margin-bottom: -40px;">
                    @endif
                </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" class="assign"
                    style="border-top: 1px solid black;
                    width: 100%;
                    text-align: center;
                    padding-top: 15px;">

                    {{-- Imagem da assinatura acima do texto --}}
                    {{-- @if ($signature)
                        <img src="{{ $signature }}" style="width: 150px; margin-bottom: -25px;">
                    @endif --}}


                    {{-- Nome do comandante --}}
                    <p style="margin: 0;">
                        {{ $student->company?->comandant?->name ?? '' }}
                        {{ mb_strtoupper(MilitaryRank::fromDb($student->company?->comandant?->posto_grad)?->label() ?? '') }}

                    </p>

                    {{-- Cargo abaixo --}}
                    <p style="margin: 0;">
                        COMANDANTE DA {{ mb_strtoupper($student->company?->name) }}
                    </p>
                </td>
                <td>

                </td>
            </tr>
        </table>
    </div>
</body>

</html>
