<!DOCTYPE html>
<html lang="pt-BR">
@php
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
@endphp

<head>
    <meta charset="UTF-8">
    <title>Opção de voto</title>
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
    </style>
</head>

<body>
    <div class="p-5 border-b border-gray-100 dark:border-gray-700">

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

            <div class="flex gap-3">
                <div>
                    <h2 class="font-semibold text-gray-800 dark:text-white">
                        {{ $question->order }})
                        {{ $question->description }}
                    </h2>
                </div>
            </div>
            <div class="flex gap-3">
                <div>
                    <div
                        class="w-9 h-9 shrink-0 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                        Escolheram a opção: {{ $option->option }}
                    </div>

                </div>
            </div>
            <table class="table">
                <tr>
                    <td class="td ">Número</td>
                    <td class="td text-center">Aluno</td>
                    <td class="td text-center">Turma</td>
                </tr>
                @foreach (json_decode($students) as $student)
                    <tr class="border-t">
                        <td class="td">
                            {{ $student->number }}
                        </td>
                        <td class="td text-center">
                            {{ $student->name }}
                        </td>
                        <td class="td text-center ">
                            {{ $student->class }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
