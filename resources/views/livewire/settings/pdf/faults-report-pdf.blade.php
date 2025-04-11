<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <title>Relatório de Faltas</title>
    <style>
        .container {
            margin-top: 30px;
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
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }

        h2 {
            margin-top: 50px;
        }

        th,
        td {
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

    <div class="container">
        <h2>Relatório de Faltas</h2>
        <p>Período: {{ \Carbon\Carbon::parse($dateStart)->format('d/m/Y') }} a
            {{ \Carbon\Carbon::parse($dateEnd)->format('d/m/Y') }}</p>

        <table class="reports">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th class="text-center">Data</th>
                    <th class="text-center">Turma</th>
                    <th class="text-center">Qtd</th>
                    <th class="text-center">Justificada</th>
                    <th class="text-center">Acumulado</th>
                    <th class="text-center">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faults as $fault)
                    <tr>
                        <td>{{ $fault->students->name ?? '-' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($fault->date)->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $fault->class->title ?? '-' }}</td>
                        <td class="text-center">{{ $fault->qtd }}</td>
                        <td class="text-center">{{ $fault->justified ? 'Sim' : 'Não' }}</td>
                        <td class="text-center">{{ $fault->acumulado }}</td>
                        <td class="px-2 py-1 font-bold text-center">
                            {{ number_format((($fault->acumulado ?? 0) / 1200) * 100, 2, ',', '') }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
