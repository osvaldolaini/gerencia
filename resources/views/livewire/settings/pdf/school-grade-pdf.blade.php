<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Turmas do </title>
    <style>
        .container {
            margin-top: 50px;
            padding-top: 70px;
        }

        .class {
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
        <!-- Tabela de Turmas -->
        <div class="turma-wrapper">
            <table class="turmas-table">
                <tr class="padding: 2px;">
                    @foreach ($school_classes as $class)
                        <td style="margin: 10px;">
                            <table class="turmas-table-un" width="100%">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="text-align: center; font-weight: bold;">
                                            {{ $class->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center border">Nome</th>
                                        <th class="text-center border">Número</th>
                                        <th class="text-center border">Inglês</th>
                                    </tr>
                                    @foreach ($class->studentsPivot as $student)
                                        <tr>
                                            <td class="text-center border">{{ $student->students->name }}</td>
                                            <td class="text-center border">{{ $student->students->number }}</td>
                                            <td class="text-center border"></td>
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
