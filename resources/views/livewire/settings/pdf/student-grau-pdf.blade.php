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
            font-size: 10pt;
        }

        .turmas-table {
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
        <div>
            <table class="turmas-table">

                <tr class="class">
                    <td class="text-center border">NR</td>
                    <td class="text-center border">NOME</td>
                    <td class="text-center border">GRAU</td>
                    <td class="text-center border">Comportamento</td>
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
                                <td class="text-center border">{{ $pivot?->students?->name }} ({{ $pivot?->students?->nick }})</td>
                                {{-- <td class="text-center border">{{ $pivot?->students?->al_class->title }}</td> --}}
                                <td class="text-center border">{{ $pivot?->students?->adjusted_grau }}</td>
                                <td class="text-center border">{{ mb_strtoupper($pivot?->students?->grau_status) }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
