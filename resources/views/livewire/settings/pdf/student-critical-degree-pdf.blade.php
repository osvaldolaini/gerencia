<!DOCTYPE html>
<html lang="pt-BR">

@php
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
    $d = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
    $today = strftime('%d de %B de %Y', $d->getTimestamp());

@endphp

<head>
    <meta charset="UTF-8">
    <title>Grau de comportamento abaixo de 5</title>
    <style>
        /* .container {
            margin-top: 50px;
            padding-top: 50px;
        } */

        .class {
            width: 100%;
            font-size: 10pt;
        }

        .turmas-table {
            width: 100%;
            font-size: 10pt;
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
        <div>
            <table class="border turmas-table">

                <tr class="class">
                    <th class="border ">Aluno</th>
                    <th class="border ">Nome completo</th>
                    <th class="text-center border">Turma</th>
                    <th class="text-center border">Grau</th>
                    <th class="text-center border">Comportamento</th>
                </tr>

                @foreach ($students as $student)
                    <tr>
                        <td class="border ">{{ $student->nick . ' ( ' . $student->num . ' )' ?? '-' }}</td>
                        <td class="border ">{{ $student->name ?? '-' }}</td>
                        <td class="text-center border">{{ $student?->al_class->title ?? 'sem turma' }}</td>
                        <td class="text-center border">{{ $student->adjusted_grau }}</td>
                        <td class="text-center border">
                            {{ $student->grau_status }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
