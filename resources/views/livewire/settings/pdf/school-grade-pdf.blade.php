<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>{{ $subtext }}</title>
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

        .turmas-table-un {
            font-size: 8px;
            margin-top: 0px;
        }

        .mt-0 {
            margin-top: 0;
        }

        .turmas-table td {
            vertical-align: top;
            /* Alinha o conteúdo no topo da célula */
        }

        .turma-wrapper {
            min-height: 300px;
            /* Ajuste a altura mínima conforme necessário */
        }

        .text-right {
            text-align: right;
        }
    </style>
    <x-app.favicons></x-app.favicons>

</head>

<body>
    <div class="container">
        <!-- Tabela de Turmas -->
        <div class="turma-wrapper">
            <table class="mt-0 turmas-table">
                <tr class="mt-0">
                    @php
                        $tot = 0;
                    @endphp
                    @foreach ($school_classes as $class)
                        <td class="mt-0">
                            <div class="mt-0 turma-wrapper">
                                <!-- Primeira Tabela -->
                                <table class="mt-0 turmas-table turmas-table-un">
                                    <tr class="w-full mt-0">
                                        <th colspan="3" class="mt-0 border header">
                                            <small>
                                                <span>{{ $class->title }}</span>
                                            </small>
                                        </th>
                                    </tr>
                                    <tr class="w-full mt-0">
                                        <th class="w-20 text-center border">Número</th>
                                        <th class="w-20 text-center border">Nome</th>
                                        <th class="w-20 text-center border">Inglês</th>
                                    </tr>
                                    @php
                                        $c = 0;
                                    @endphp
                                    @foreach ($class->studentsPivot->where('active', 1)->sortBy('students.nick') as $student)
                                        @php
                                            $c += 1;
                                        @endphp
                                        <tr class="mt-0">
                                            <td class="text-center border">{{ $student->students->number ?? '' }}</td>
                                            <td class="text-center border">{{ $student->students->nick }}</td>
                                            <td class="text-center border"></td>
                                        </tr>
                                    @endforeach
                                    <tr class="">
                                        <td colspan="2" class="text-right border">Total</td>
                                        <td class="text-center border">{{ $c }}</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        @php
                            $tot += $c;
                        @endphp
                    @endforeach
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        Efetivo: {{ $tot }}</td>
                </tr>
            </table>
        </div>
    </div>


</body>


</html>
