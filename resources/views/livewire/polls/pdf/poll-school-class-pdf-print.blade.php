<!DOCTYPE html>
<html lang="pt-BR">
@php
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
@endphp

<head>
    <meta charset="UTF-8">
    <title>Alunos da turma que já votaram</title>
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

        .td {
            border: 1px solid #000;
            padding: 2px;
        }

        .text-center {
            text-align: center;
        }

        .w-full {
            width: 100%;
        }

        .table-signature {
            margin-top: 50px;
            font-size: 10pt;
            text-align: center;
            width: 100%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: sans-serif;
            font-size: 11px;
        }

        th {
            background-color: #e5e7eb;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border: 1px solid #999;
        }



        .center {
            text-align: center;
        }

        .voted {
            color: #15803d;
            font-weight: bold;
        }

        .not-voted {
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="p-5 border-b border-gray-100 dark:border-gray-700">

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

            <div class="flex gap-3">
                <div>
                    <h3 class="">
                        Enquete: {{ $poll->title }}
                    </h3>
                    <p class="">
                        Descrição {{ $poll->description }}
                    </p>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 12%;">Nº</th>
                        <th>ALUNO</th>
                        <th style="width: 25%; text-align:center;">SITUAÇÃO</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($students as $student)
                        @php
                            $statusClass = $student['status'] === 'Votou' ? 'voted' : 'not-voted';
                        @endphp
                        <tr>
                            <td class="center td">{{ $student['number'] }}</td>
                            <td class="td">{{ $student['name'] }}</td>
                            <td class="center td {{ $statusClass }}">{{ $student['status'] }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</body>
