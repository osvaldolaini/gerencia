<!DOCTYPE html>
<html lang="pt-BR">

@php
    use App\Enums\SchoolFault;
@endphp

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
        <h2>Relatório de alunos com mais de 7,5% de faltas</h2>
        
        <table class="reports">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Nome completo</th>
                    <th class="text-center">Turma</th>
                    <th class="text-center">Qtd</th>
                    <th class="text-center">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->nick .' ( '.$student->nick.' )'?? '-' }}</td>
                        <td>{{ $student->name ?? '-' }}</td>
                        <td class="text-center">{{ $student?->al_class->title  ?? 'sem turma' }}</td>
                        <td class="text-center">{{ $student->total_faults }}</td>
                        <td class="px-2 py-1 font-bold text-center">
                            ({{ number_format($student->total_faults_percent, 2, ',', '') }}%)
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
