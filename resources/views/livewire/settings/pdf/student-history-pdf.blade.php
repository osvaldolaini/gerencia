<!DOCTYPE html>
<html lang="pt-BR">



<head>
    @php
        use App\Enums\Penalty;
    @endphp
    <meta charset="UTF-8">
    <title>Ficha individual</title>
    <style>
        .container {
            margin-top: 30px;
            padding-top: 40px;
            width: 100%;
            font-family: sans-serif;
        }

        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
        }

        .dados-container {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
        }

        .col-esquerda {
            width: 60%;
            vertical-align: top;
            border-right: 1px solid #000;
            padding: 10px;
        }

        .col-direita {
            width: 40%;
            vertical-align: top;
            text-align: center;
            padding: 10px;
        }

        .foto {
            width: 100px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #000;
        }

        .linha-info {
            padding: 5px 0;
            text-align: left;
        }

        .linha-tabela {
            border-bottom: 1px solid #ccc;
            padding: 6px 0;
        }
    </style>
</head>

<body>
    <div class="container">


        <div class="section">
            <div class="section-title">Dados Individuais</div>
            <table class="dados-container">
                <tr>
                    <td class="col-direita">
                        <img src="{{ $studentImage }}" class="foto">
                    </td>
                    <td class="col-esquerda">
                        <div class="linha-info"><strong>Nome:</strong> {{ $student->name }}</div>
                        <div class="linha-info"><strong>Nome aluno:</strong> {{ $student->name }}</div>
                        <div class="linha-info"><strong>Nr:</strong> {{ $student->nick }}</div>
                        <div class="linha-info"><strong>Turma:</strong> {{ $student->people_class }}</div>

                    </td>

                </tr>
            </table>
        </div>
        <div class="section">
            @if ($student->fafd->count() > 1)
                <div class="section-title">Formulários de apuração de falta</div>
                <table>
                    @foreach ($student->fafd->sortByDesc('fact_date') as $fafd)
                        <tr class="linha-tabela">
                            <td class="text-center ">
                                {{ $fafd->f_date }}
                            </td>
                            <td class="text-center">
                                {{ $fafd->number }}
                            </td>
                            <td class="text-center">
                                @if ($fafd->faults)
                                    @php
                                        $vowels = ['[', ']'];
                                        $faults = str_replace($vowels, '', $fafd->faults);
                                    @endphp
                                    {{-- (@fafdreach ($fafd->json_faults as $fault) --}}
                                    <span>{{ $faults }}</span>
                                    {{-- @endforeach) --}}
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $fafd->decision ? Penalty::from($fafd->decision)->label() : '' }}
                            </td>
                        </tr>
                    @endforeach

                </table>
            @else
                <div class="linha-tabela">Não possui</div>
            @endif



        </div>

    </div>
</body>

</html>
