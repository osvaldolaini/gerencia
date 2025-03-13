<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Turmas do {{ $grade }}</title>
    <style>
        .turma-wrapper {
            display: flex;
            flex-wrap: wrap;
            /* gap: 20px; */
            /* Espaço entre as tabelas */
        }

        .turmas-table {
            width: 100%;
            /* Cada tabela ocupará metade da largura */
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .turmas-table-un {
            /* margin-bottom: 20px; */
            padding: 1px;
            border-collapse: collapse;
        }

        .turmas-table-un th,
        .turmas-table-un td {
            border: 1px solid #ddd;
            padding: 2px;
            margin: 2px;
            text-align: center;
        }

        .turmas-table th,
        .turmas-table td {
            /* border: 1px solid #ddd; */
            padding: 0px;
            text-align: center;
        }

        .turmas-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        /* Evitar quebra de página dentro das tabelas */
        .turmas-table {
            page-break-inside: avoid;
        }
    </style>

</head>

<body>
    <div class="receipt-container">
        <!-- Cabeçalho com Informações da Empresa e Logo -->
        <div class="header">
            <table class="header-info" width="100%">
                <tr width="100%">
                    <td style="text-align: left;">
                        @if (Storage::directoryMissing('public/logos-school'))
                            <img width="50" src="{{ url('storage/logos/logo.png') }}" alt="api-sistema-aero">
                        @else
                            <img width="50" src="{{ url('storage/logos-school/logo.png') }}" alt="api-sistema-aero">
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div class="company-info">
                            <p><strong>{{ $config->name }}</strong></p>
                            <p>{{ $companies->name }}</p>
                            <p>Turmas do {{ $grade }}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Tabela de Turmas -->
        <div class="turma-wrapper">
            <table class="turmas-table">
                <tr class="padding: 2px;">
                    @foreach ($school_classes as $class)
                        <td>
                            <table class="turmas-table-un" width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="text-align: center; font-weight: bold;">
                                            {{ $class->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Número</th>
                                        <th>Inglês</th>
                                    </tr>
                                    @foreach ($class->studentsPivot as $student)
                                        <tr>
                                            <td>{{ $student->students->name }}</td>
                                            <td>{{ $student->students->number }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    @endforeach
                </tr>
            </table>
        </div>

    </div>
</body>

</html>
