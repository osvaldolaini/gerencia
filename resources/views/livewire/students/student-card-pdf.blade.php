<!DOCTYPE html>
<html lang="pt-BR">
@php
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
    $date = DateTime::createFromFormat('Y-m-d', $student->birthday);
    $birth = strftime('%d de %B de %Y', $date->getTimestamp());
    $article = $student->sex == 'F' ? 'a' : 'o';
    $level = $student->al_class->classGrade->nick > 600 ? 'Fundamental' : 'Médio';
    $d = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
    $today = strftime('%d de %B de %Y', $d->getTimestamp());

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
    <div class="container" style="padding:5px;">
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
            </tr>
            <tr>
                <td></td>
                <td>{{ $config->signature?->name ?? '' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Adjunto do corpo de Alunos </td>
            </tr>
        </table>
    </div>
</body>

</html>
