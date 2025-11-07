<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Legião de honra</title>
    <style>
        .container {

            padding-top: 40px;
            width: 100%;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .reports {
            width: 100%;
            border-collapse: collapse;

        }

        .text-center {
            text-align: center;
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
    </style>
</head>

<body>
    <p style="width: 100%;text-align:center;padding:0;">
        <img width="100" src="{{ $legion }}" alt="Logo">
    </p>
    <div class="container">

        <h2>Legião de honra</h2>
        <p>Data:{{ date('d/m/Y') }}</p>

        <table class="reports">
            <thead>
                <tr>

                    <th class="text-center">Ano escolar</th>
                    <th class="text-center">Aluno</th>
                    <th class="text-center">Ano entrada</th>
                    <th class="text-center">Local</th>
                    <th class="text-center">Comportamento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td style="text-align:center;">
                            {{ $student->grade ?? 'sem turma' }}
                        </td>
                        <td style="text-align:center;">{{ $student?->student->nick ?? $student?->oldSudents?->nick }}
                            ({{ $student?->student->number ?? $student?->oldSudents?->number }})
                        </td>

                        <td style="text-align:center;">{{ $student->year ?? 'Não informado' }}</td>
                        <td style="text-align:center;">{{ $student->local ?? 'Não informado' }}</td>
                        <td style="text-align:center;"> {{ $student?->grau }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
