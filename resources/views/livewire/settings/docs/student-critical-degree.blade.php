@php
    setlocale(LC_TIME, 'pt_BR.UTF-8', 'pt_BR', 'Portuguese_Brazil');
    $d = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
    $today = strftime('%d de %B de %Y', $d->getTimestamp());
    // $level = $grade->nick > 600 ? 'Fundamental' : 'Médio';
    // switch ($grade->nick) {
    //     case '200':
    //         $order = 'b';
    //         break;
    //     case '300':
    //         $order = 'c';
    //         break;
    //     case '700':
    //         $order = 'b';
    //         break;
    //     case '800':
    //         $order = 'c';
    //         break;
    //     case '900':
    //         $order = 'd';
    //         break;

    //     default:
    //         $order = 'a';
    //         break;
    // }
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
            <th>Aluno</th>
            <th>Nome completo</th>
            <th class="text-center">Turma</th>
            <th class="text-center">Grau</th>
            <th class="text-center">Comportamento</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($students as $student)
            <tr>
                <td>{{ $student->nick . ' ( ' . $student->num . ' )' ?? '-' }}</td>
                <td>{{ $student->name ?? '-' }}</td>
                <td class="text-center">{{ $student?->al_class->title ?? 'sem turma' }}</td>
                <td class="text-center">{{ $student->adjusted_grau }}</td>
                <td class="px-2 py-1 font-bold text-center">
                    {{ $student->grau_status }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
