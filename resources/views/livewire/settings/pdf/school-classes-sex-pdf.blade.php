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

        .turmas-table {

            width: 100%;
            font-size: 6pt;
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
            <table class="turmas-table">
                <tr class="w-full py-5">
                    <th colspan="4" class="border header">
                        <small>
                            <span>Feminino</span>
                        </small>
                    </th>
                </tr>
                <tr class="class">
                    <td class="text-left border">Nr</td>
                    <td class="text-left border">Aluna</td>
                    <td class="text-left border">Turma</td>
                    <td class="text-center border">P/F</td>
                </tr>
                @php
                    $c = 0;
                @endphp
                @foreach ($school_classes as $class)
                    @foreach ($class->studentsPivot->where('active', 1)->where('students.sex', 'F')->sortBy('students.nick') as $pivot)
                        @if ($pivot->students->where('active', 1))
                            @php
                                $c += 1;
                            @endphp
                            <tr class="class">
                                <td class="text-left border">{{ $pivot->students->number }}</td>
                                <td class="text-left border">{{ $pivot->students->nick }}</td>
                                <td class="text-left border">{{ $pivot->students->al_class->title }}</td>
                                <td class="text-center border"></td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
                <tr class="border">
                    <td colspan="3" class="text-right border">Total</td>
                    <td class="text-center border">{{ $c }}</td>
                </tr>
            </table>
        </div>
        <pagebreak />
        <div>
            <table class="turmas-table">
                <tr class="w-full py-5">
                    <th colspan="4" class="border header">
                        <small>
                            <span>Masculino</span>
                        </small>
                    </th>
                </tr>
                <tr class="class">
                    <td class="text-left border">Nr</td>
                    <td class="text-left border">Aluno</td>
                    <td class="text-left border">Turma</td>
                    <td class="text-center border">P/F</td>
                </tr>
                @php
                    $c = 0;
                @endphp
                @foreach ($school_classes as $class)
                    @foreach ($class->studentsPivot->where('students.sex', 'M')->sortBy('students.nick') as $pivot)
                        @php
                            $c += 1;
                        @endphp
                        <tr class="class">
                            <td class="text-left border">{{ $pivot->students->number }}</td>
                            <td class="text-left border">{{ $pivot->students->nick }}</td>
                            <td class="text-left border">{{ $pivot->students->al_class->title }}</td>
                            <td class="text-center border"></td>
                        </tr>
                    @endforeach
                @endforeach
                <tr class="border">
                    <td colspan="3" class="text-right border">Total</td>
                    <td class="text-center border">{{ $c }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
