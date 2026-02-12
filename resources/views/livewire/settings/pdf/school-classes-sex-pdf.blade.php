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
        {{-- <div>
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
                        @endif
                    @endforeach
                @endforeach
                <tr class="border">
                    <td colspan="3" class="text-right border">Total</td>
                    <td class="text-center border">{{ $c }}</td>
                </tr>
            </table>
        </div> --}}
        @php
            $students = collect();

            foreach ($school_classes as $class) {
                foreach ($class->studentsPivot as $pivot) {
                    if (
                        $pivot->active &&
                        $pivot->students &&
                        $pivot->students->active &&
                        $pivot->students->sex === 'F'
                    ) {
                        $students->push($pivot);
                    }
                }
            }

            $students = $students->sortBy(fn($p) => $p->students->nick)->values();

            $half = ceil($students->count() / 2);

            $left = $students->slice(0, $half);
            $right = $students->slice($half);
        @endphp

        <table width="100%" cellpadding="5" cellspacing="0">
            <tr>

                {{-- COLUNA ESQUERDA --}}
                <td width="50%" valign="top">

                    <table class="turmas-table" width="100%" cellpadding="5" cellspacing="0">
                        <tr>
                            <th colspan="4" class="border header">
                                <small><span>Feminino</span></small>
                            </th>
                        </tr>
                        <tr class="class">
                            <td class="border">Nr</td>
                            <td class="border">Aluna</td>
                            <td class="border">Turma</td>
                            <td class="text-center border">P/F</td>
                        </tr>

                        @foreach ($table1 as $pivot)
                            <tr class="class">
                                <td class="border">{{ $pivot->students->number }}</td>
                                <td class="border">{{ $pivot->students->nick }}</td>
                                <td class="border">{{ $pivot->students->al_class->title }}</td>
                                <td class="text-center border"></td>
                            </tr>
                        @endforeach
                    </table>

                </td>

                {{-- COLUNA DIREITA --}}
                <td width="50%" valign="top">

                    <table class="turmas-table" width="100%" cellpadding="5" cellspacing="0">
                        <tr>
                            <th colspan="4" class="border header">
                                <small><span>Feminino</span></small>
                            </th>
                        </tr>
                        <tr class="class">
                            <td class="border">Nr</td>
                            <td class="border">Aluna</td>
                            <td class="border">Turma</td>
                            <td class="text-center border">P/F</td>
                        </tr>

                        @foreach ($table2 as $pivot)
                            <tr class="class">
                                <td class="border">{{ $pivot->students->number }}</td>
                                <td class="border">{{ $pivot->students->nick }}</td>
                                <td class="border">{{ $pivot->students->al_class->title }}</td>
                                <td class="text-center border"></td>
                            </tr>
                        @endforeach
                    </table>

                </td>

            </tr>
        </table>


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
                    @foreach ($class->studentsPivot->where('active', 1)->where('students.sex', 'M')->sortBy('students.nick') as $pivot)
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
                        @endif
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
