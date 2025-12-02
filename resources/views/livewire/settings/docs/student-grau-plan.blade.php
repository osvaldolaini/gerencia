@php
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
    $date = DateTime::createFromFormat('Y-m-d', $student->birthday);
    $birth = strftime('%d de %B de %Y', $date->getTimestamp());

    $d = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
    $today = strftime('%d de %B de %Y', $d->getTimestamp());

    $level = $grade->nick > 600 ? 'Fundamental' : 'Médio';
@endphp
<table>
    <thead>
        <tr>
            <td>Nr</td>
            <td>Nome</td>
            <td>Grau</td>
            <td>Comportamento</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="4">
                a)) Em {{ $today }}, o(a) do {{ $grade->name }} do Ensino
                {{ $level }}, encontra-se com o seguinte grau e conceito de comportamento:
            </td>
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
