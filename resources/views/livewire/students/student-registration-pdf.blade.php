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
    // dd($level, $student->al_class->classGrade->nick);
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
        <div style="text-align:justify;text-indent:1.5em;">
            <strong>DECLARO</strong>, para os devidos fins, que <strong>{{ $student->name }}</strong>,
            nascid{{ $article }} em
            <strong>{{ $birth }}</strong>, na cidade de <strong>{{ $student->city_birth }} -
                {{ $student->state_birth }}</strong>,
            filh{{ $article }} de <strong>{{ $student->mom }}</strong>
            {{ $student->dad ? 'e ' : '' }}<strong>{{ $student->dad }}</strong>, está
            matriculad{{ $article }} e
            frequentará o <strong>{{ strtolower($student->al_class->classGrade->name) }}</strong> do <strong>Ensino
                {{ $level }}</strong> neste
            Estabelecimento de Ensino no ano letivo de <strong>{{ date('Y') }}</strong>, com atividades presenciais
            compreendidas
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
