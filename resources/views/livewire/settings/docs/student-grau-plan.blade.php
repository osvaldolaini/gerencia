<table>
    <thead>
        <tr>
            <td>NR</td>
            <td>NOME</td>
            <td>GRAU</td>
            <td>COMPORTAMENTO</td>
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
