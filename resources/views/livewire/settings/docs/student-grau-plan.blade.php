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
<style>
    tr {
        text-align: left;
    }

    tr td {
        text-align: left;
    }
</style>
<table>
    <thead>
        <tr>
            <td colspan="4">
                {{ $order }})) Em {{ $today }}, o(a) do {{ $grade->name }} do Ensino
                {{ $level }}, encontra-se com o seguinte grau e conceito de comportamento:
            </td>
        </tr>
        <tr>
            <td>Nr</td>
            <td width="50%">Nome</td>
            <td>Grau</td>
            <td>Comportamento</td>
        </tr>
    </thead>
    <tbody>

        @php
            $c = 0;
        @endphp
        @foreach ($school_classes as $class)
            @foreach ($class->studentsPivot->where('active', 1)->sortBy('students.nick') as $pivot)
                @if ($pivot?->students?->where('active', 1))
                    @php
                        $c += 1;
                    @endphp
                    <tr>
                        <td>
                            {{ $pivot?->students?->number }}
                        </td>
                        <td>
                            {{ $pivot?->students?->name }} ({{ $pivot?->students?->nick }})
                        </td>
                        <td>
                            {{ number_format($pivot?->students?->adjusted_grau, 2, ',', '') }}
                            {{-- {{ $pivot?->students?->adjusted_grau }} --}}
                        </td>
                        <td>
                            {{ ucfirst(strtolower($pivot?->students?->grau_status)) }}
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>
