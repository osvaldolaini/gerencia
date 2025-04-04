<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Turmas do {{ $grade }}</title>
    <style>
        .container {
            margin-top: 50px;
            padding-top: 50px;
        }

        .class {
            width: 100%;
            font-size: 8pt;
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
        @foreach ($school_classes as $class)
            <div class="turma-wrapper">
                <!-- Primeira Tabela -->
                <table class="turmas-table">
                    <tr class="w-full py-5">
                        <th colspan="7" class="border header">
                            <small>
                                <span>{{ $class->title }}</span>
                            </small>
                        </th>
                        <th>
                            &nbsp;
                            &nbsp;
                            &nbsp;
                        </th>
                        <th colspan="7" class="border header">
                            <small>
                                <span>{{ $class->title }}</span>
                            </small>
                        </th>
                    </tr>
                    <tr class="w-full ">
                        <th class="w-20 text-center border">Nr</th>
                        <th class="w-20 text-center border">Aluno</th>
                        <th class="w-10 text-center border">2ªf</th>
                        <th class="w-10 text-center border">3ªf</th>
                        <th class="w-10 text-center border">4ªf</th>
                        <th class="w-10 text-center border">5ªf</th>
                        <th class="w-10 text-center border">6ªf</th>
                        <th style="width: 0rem;"></th>
                        <th class="w-20 text-center border">Nr</th>
                        <th class="w-20 text-center border">Aluno</th>
                        <th class="w-10 text-center border">2ªf</th>
                        <th class="w-10 text-center border">3ªf</th>
                        <th class="w-10 text-center border">4ªf</th>
                        <th class="w-10 text-center border">5ªf</th>
                        <th class="w-10 text-center border">6ªf</th>
                    </tr>
                    @php
                        $c = 0;
                    @endphp
                    @foreach ($class->studentsPivot as $pivot)
                        @php
                            $c += 1;
                        @endphp
                        <tr class="class">
                            <td class="text-left border">{{ $pivot->students->number }}</td>
                            <td class="text-left border">{{ $pivot->students->nick }}</td>
                            <td class="text-center border"></td>
                            <td class="text-center border"></td>
                            <td class="text-center border"></td>
                            <td class="text-center border"></td>
                            <td class="text-center border"></td>
                            <td></td>
                            <td class="text-left border">{{ $pivot->students->number }}</td>
                            <td class="text-left border">{{ $pivot->students->nick }}</td>
                            <td class="text-center border"></td>
                            <td class="text-center border"></td>
                            <td class="text-center border"></td>
                            <td class="text-center border"></td>
                            <td class="text-center border"></td>
                        </tr>
                    @endforeach
                    <tr class="border">
                    <tr class="">
                        <td colspan="6" class="text-right border">Total</td>
                        <td class="text-center border">{{ $c }}</td>
                        <td></td>
                        <td colspan="6" class="text-right border">Total</td>
                        <td class="text-center border">{{ $c }}</td>
                    </tr>

                    </tr>
                </table>
            </div>
            @if (!$loop->last)
                <pagebreak />
            @endif
        @endforeach
    </div>


</body>


</html>
