<!DOCTYPE html>
<html lang="pt-BR">

@php
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
    $d = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
    $today = strftime('%d de %B de %Y', $d->getTimestamp());
    $level = $grade->nick > 600 ? 'Fundamental' : 'Médio';
    switch ($grade->nick) {
        case '200':
            $order = 'b';
            break;
        case '300':
            $order = 'c';
            break;
        case '700':
            $order = 'b';
            break;
        case '800':
            $order = 'c';
            break;
        case '900':
            $order = 'd';
            break;

        default:
            $order = 'a';
            break;
    }
@endphp

<head>
    <meta charset="UTF-8">
    <title>Comportamento do {{ $grade->name }}</title>
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
                    <td colspan="4" class="text-center border">
                        {{ $order }})) Em {{ $today }}, o(a) do {{ $grade->name }} do Ensino
                        {{ $level }}, encontra-se com o seguinte grau e conceito de comportamento:
                    </td>
                </tr>
                <tr class="class">
                    <td class="text-center border">Nr</td>
                    <td class="text-center border">Nome</td>
                    <td class="text-center border">Grau</td>
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
                                <td class="text-center border">{{ $pivot?->students?->name }}
                                    ({{ $pivot?->students?->nick }})
                                </td>
                                {{-- <td class="text-center border">{{ $pivot?->students?->al_class->title }}</td> --}}
                                <td class="text-center border">{{ $pivot?->students?->adjusted_grau }}</td>
                                <td class="text-center border">
                                    {{ ucfirst(strtolower($pivot?->students?->grau_status)) }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
