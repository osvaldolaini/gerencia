<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Comportamento do {{ $grade }}</title>
    <style>
        /* .container {
            margin-top: 50px;
            padding-top: 50px;
        } */

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

                <tr class="class">
                    <td class="text-center border">Nr</td>
                    <td class="text-center border">Aluna</td>
                    <td class="text-center border">Nome completo</td>
                    <td class="text-center border">Turma</td>
                    <td class="text-center border">Grau de comportamento</td>
                </tr>
                @php
                    $c = 0;
                @endphp
                @foreach ($school_classes as $class)
                    @foreach ($class->studentsPivot->where('active', 1)->sortBy('students.nick') as $pivot)
                        @if ($pivot?->students?->where('active', 1))
                            @php
                                $c += 1;
                            @endphp
                            <tr class="class">
                                <td class="text-center border">{{ $pivot?->students?->number }}</td>
                                <td class="text-center border">{{ $pivot?->students?->nick }}</td>
                                <td class="text-center border">{{ $pivot?->students?->name }}</td>
                                <td class="text-center border">{{ $pivot?->students?->al_class->title }}</td>
                                <td class="text-center border">{{ $pivot?->students?->adjusted_grau }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
