<!DOCTYPE html>
<html lang="pt-BR">
@php
    use App\Enums\ComplimentType;

    // Garante que $data seja iterável mesmo que seja null
    $data = $data ?? collect();
@endphp

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        .container {
            margin-top: 50px;
            padding-top: 50px;
        }

        .class {
            width: 100%;
            font-size: 12pt;
        }

        .turmas-table {
            width: 100%;
            font-size: 12pt;
            border-collapse: collapse;
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

        .text-left {
            text-align: left;
        }
    </style>
    <x-app.favicons></x-app.favicons>
</head>

<body>
    <div class="container">
        @if ($title == 'Justificativa')
            <div>
                <h2 style="text-align: center;padding:20px;">Aguardando {{ $title }}</h2>
            </div>
            <table class="turmas-table">
                <tr class="class">
                    <td class="text-left border">FAFD Nº</td>
                    <td class="text-left border">Nr</td>
                    <td class="text-left border">Aluno</td>
                    <td class="text-left border">Turma</td>
                    <td class="text-center border">Data prevista</td>
                </tr>
                @php $c = 0; @endphp
                @foreach ($data as $fafd)
                    @php $c++; @endphp
                    <tr class="class">
                        <td class="text-left border">{{ $fafd->number }}/{{ $fafd->year }}</td>
                        <td class="text-left border">{{ $fafd?->students?->number }}</td>
                        <td class="text-left border">{{ $fafd?->students?->nick }}</td>
                        <td class="text-left border">{{ $fafd?->students?->al_class->title }}</td>
                        <td class="text-center border">{{ $fafd->deliv_date }}</td>
                    </tr>
                @endforeach
                <tr class="border">
                    <td colspan="4" class="text-right border">Total</td>
                    <td class="text-center border">{{ $c }}</td>
                </tr>
            </table>
        @endif

        @if ($title == 'Solução')
            <div>
                <h2 style="text-align: center;padding:20px;">Aguardando {{ $title }}</h2>
            </div>
            <table class="turmas-table">
                <tr class="class">
                    <td class="text-left border">Elogio Nº</td>
                    <td class="text-left border">Nr</td>
                    <td class="text-left border">Aluno</td>
                    <td class="text-left border">Turma</td>
                    <td class="text-center border">Data</td>
                </tr>
                @php $c = 0; @endphp
                @foreach ($data as $fafd)
                    @php $c++; @endphp
                    <tr class="class">
                        <td class="text-left border">{{ $fafd->number }}/{{ $fafd->year }}</td>
                        <td class="text-left border">{{ $fafd?->students?->number }}</td>
                        <td class="text-left border">{{ $fafd?->students?->nick }}</td>
                        <td class="text-left border">{{ $fafd?->students?->al_class->title }}</td>
                        <td class="text-center border">{{ $fafd->sol_date }}</td>
                    </tr>
                @endforeach
                <tr class="border">
                    <td colspan="4" class="text-right border">Total</td>
                    <td class="text-center border">{{ $c }}</td>
                </tr>
            </table>
        @endif

        @if ($title == 'Publicação')
            <div>
                <h2 style="text-align: center;">Aguardando {{ $title }}</h2>
            </div>
            @php
                $c = 0;
                $decision = 'null';
            @endphp
            @foreach ($data as $fafd)
                @php
                    $c++;
                    $newdecision = $fafd->compliment_type;
                @endphp
                @if ($newdecision != $decision)
                    @php $decision = $newdecision; @endphp
                    <h2>{{ mb_strtoupper(ComplimentType::from($newdecision)->label()) }}</h2>
                @endif
                <div style="padding: 5px 5px; text-align:justify; text-indent:1.5cm;">
                    {{ $fafd->note }}
                </div>
            @endforeach
        @endif

        @if ($title == 'Todas')
            <div style="padding-top:20px;">
                <h2 style="text-align: center;padding:20px;">Aguardando {{ $title }}</h2>
            </div>
            <table class="turmas-table">
                <tr class="class">
                    <td class="text-left border">FAFD Nº</td>
                    <td class="text-left border">Status</td>
                    <td class="text-left border">Aluno</td>
                    <td class="text-left border">Turma</td>
                    <td class="text-left border">Abertura</td>
                    <td class="text-left border">Solução</td>
                    <td class="text-left border">Nota</td>
                    <td class="text-left border">SINCOMIL</td>
                    <td class="text-center border">Status</td>
                </tr>
                @php $c = 0; @endphp
                @foreach ($data as $fafd)
                    @php $c++; @endphp
                    <tr class="class" @if ($fafd->active == 0) style="background-color:#f00;" @endif>
                        <td class="text-left border">{{ $fafd->number }}/{{ $fafd->year }}</td>
                        <td class="text-left border">{{ $fafd->active == 1 ? 'Ativa' : 'Excluida' }}</td>
                        <td class="text-left border">{{ $fafd?->students?->nick ?? $fafd->al_nick }}
                            ({{ $fafd?->students?->number ?? $fafd->al_number }})
                        </td>
                        <td class="text-left border">{{ $fafd?->students?->al_class->title }}</td>
                        <td class="text-left border">{{ $fafd?->f_date }}</td>
                        <td class="text-left border">{{ $fafd?->s_date }}</td>
                        <td class="text-left border">{{ $fafd?->b_date }}</td>
                        <td class="text-left border">{{ $fafd?->sim_date }}</td>
                        <td class="text-center border">
                            @if ($fafd->active == 1)
                                {{ $fafd->decision ? ComplimentType::from($fafd->decision)->label() : 'Aguardando' }}
                            @else
                                Excluida
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr class="border">
                    <td colspan="4" class="text-right border">Total</td>
                    <td class="text-center border">{{ $c }}</td>
                </tr>
            </table>
        @endif
    </div>
</body>

</html>
