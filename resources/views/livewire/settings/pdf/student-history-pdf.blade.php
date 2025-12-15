<!DOCTYPE html>
<html lang="pt-BR">



<head>
    @php
        use App\Enums\Penalty;
        use App\Enums\ComplimentType;
        use App\Enums\MilitaryRank;
        use App\Enums\SchoolFault;
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
            /* page-break-inside: avoid; */
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
            border-bottom: 1px solid #000;
            padding: 6px 0;
        }

        .border-bottom {
            border-bottom: 1px solid #333;
        }

        .text-center {
            text-align: center;
        }

        .w-full {
            width: 100%
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
                        <div class="linha-info"><strong>Nome aluno:</strong> {{ $student->nick }}</div>
                        <div class="linha-info"><strong>Nr:</strong> {{ $student->number }}</div>
                        <div class="linha-info"><strong>Turma:</strong> {{ $student->people_class }}</div>
                        <div class="linha-info"><strong>Grau de comportamento: </strong>{{ $student->grau_status }}
                            ({{ $student->adjusted_grau }})
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="section">
            <div class="section-title">Atividades extra</div>
            @if ($student->activities->where('active', 1)->count() > 0)
                <table class="w-full" style="border-collapse: collapse;">
                    <tr>
                        <th class="text-left">Tipo</th>
                        <th class="text-center">Atividade</th>
                        <th class="text-center">GIP</th>
                        <th class="text-center">Bônus</th>
                    </tr>
                    @foreach ($student->activities->where('active', 1)->sortByDesc('gip') as $extra)
                        <tr class="linha-tabela">
                            <td class="text-left border-bottom">
                                {{ $extra->activity->modality->title }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $extra->activity->title }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $extra->gip ? 'Sim' : 'Não' }}
                            </td>


                            <td class="text-center border-bottom">
                                {{ $extra->bonus ? 'Sim' : 'Não' }}
                            </td>
                        </tr>
                    @endforeach

                </table>
            @else
                <div class="linha-tabela">Não possui</div>
            @endif
        </div>
        <div class="section">
            <div class="section-title">Formulários de Apuração de Falta Disciplinar (FAFD)</div>
            @if ($student->fafd->count() > 0)
                <table class="w-full" style="border-collapse: collapse;">
                    <tr>
                        <th class="text-center">Nr</th>
                        <th class="text-center">Data</th>
                        <th class="text-center">Falta(s)</th>
                        <th class="text-center">Fato</th>
                        <th class="text-center">Solução</th>
                        <th class="text-center">Desconto</th>
                    </tr>
                    @foreach ($student->fafd->where('active', 1)->sortByDesc('fact_date') as $fafd)
                        <tr class="linha-tabela">
                            <td class="text-center border-bottom">
                                {{ $fafd->number }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $fafd->f_date }}
                            </td>

                            <td class="text-center border-bottom">
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
                            <td class="border-bottom">
                                {{ $fafd->fact }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $fafd->decision ? Penalty::from($fafd->decision)->label() : 'Aguardando' }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $fafd->total_grau }}
                                @if ($fafd->decision)
                                    {{ $fafd->decision != 'fo' ? ($fafd->supplement_number ? '' : '*') : '' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </table>
                <div style="padding-top: 20px;text-align:left;width:100%;">*Aguardando publicação</div>
            @else
                <div class="linha-tabela">Não possui</div>
            @endif
        </div>
        <div class="section">
            <div class="section-title">Elogios</div>
            @if ($student->compliments->where('active', 1)->count() > 0)
                <table class="w-full" style="border-collapse: collapse;">
                    <tr>
                        <th class="text-center">Nr</th>
                        <th class="text-center">Data</th>
                        <th class="text-center">Fato</th>
                        <th class="text-center">Tipo do Elogio</th>
                        <th class="text-center">Bônus</th>
                    </tr>
                    @foreach ($student->compliments->where('active', 1)->sortByDesc('fact_date') as $compliment)
                        <tr class="linha-tabela">
                            <td class="text-center border-bottom">
                                {{ $compliment->number }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $compliment->f_date }}
                            </td>


                            <td class="border-bottom">
                                {{ $compliment->fact }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $compliment->compliment_type ? ComplimentType::from($compliment->compliment_type)->label() : 'Aguardando' }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $compliment->total_grau }}
                                @if ($compliment->decision)
                                    {{ $compliment->supplement_number ? '' : '*' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </table>
                <div style="padding-top: 20px;text-align:left;width:100%;">*Aguardando publicação</div>
            @else
                <div class="linha-tabela">Não possui</div>
            @endif
        </div>
        <div class="section">
            <div class="section-title">Fatos Observados (FO)</div>
            @if ($student->fo->count() > 0)
                <table class="w-full" style="border-collapse: collapse;">
                    <tr>
                        <th class="text-center">Data</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">FO</th>
                        <th class="text-center">Falta(s)</th>
                    </tr>
                    @foreach ($student->fo->where('active', 1)->where('fafd', '!=', 1)->where('compliment', '!=', 1)->sortByDesc('fact_date') as $fo)
                        <tr class="border-t">
                            <td class="text-center border-bottom">
                                {{ $fo->f_date }}
                            </td>
                            <td class="text-center border-bottom">
                                @if ($fo->fact_type == 'negativo')
                                    <span class="badge badge-error">FO-</span>
                                @endif
                                @if ($fo->fact_type == 'positivo')
                                    <span class="badge badge-info">FO+</span>
                                @endif
                                @if ($fo->fact_type == 'informativo')
                                    <span class="badge badge-success">FO!</span>
                                @endif
                            </td>
                            <td class="border-bottom">
                                {{ $fo->fact }}
                            </td>
                            <td class="text-center border-bottom">
                                @if ($fo->faults)
                                    @php
                                        $vowels = ['[', ']'];
                                        $faults = str_replace($vowels, '', $fo->faults);
                                    @endphp
                                    {{-- (@fafdreach ($fafd->json_faults as $fault) --}}
                                    <span>{{ $faults }}</span>
                                    {{-- @endforeach) --}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="linha-tabela">Não possui</div>
            @endif
        </div>
        <div class="section">
            <div class="section-title">Faltas</div>
            @if ($student->faults->where('active', 1)->count() > 0)

                <table class="w-full" style="border-collapse: collapse;">
                    <tr>
                        <th class="text-center">Data</th>
                        <th class="text-center">Períodos</th>
                        <th class="text-center">Justificada</th>
                        <th class="text-center">%</th>
                    </tr>
                    @php
                        $acumulado = 0;
                        $faultsOrdenadas = $student->faults->where('active', 1)->sortBy('date'); // ordem CRESCENTE
                        $dados = [];

                        foreach ($faultsOrdenadas as $fault) {
                            if ($fault->justified != 2) {
                                $acumulado += $fault->qtd;
                            }

                            $percentual = number_format(
                                ($acumulado / ($fault->students->company->workload ?? 1200)) * 100,
                                2,
                                ',',
                                '',
                            );

                            $dados[] = [
                                'date_view' => $fault->date_view,
                                'qtd' => $fault->qtd,
                                'justified' => SchoolFault::from($fault->justified)->label(),
                                'percentual' => $percentual,
                            ];
                        }
                    @endphp

                    @foreach (array_reverse($dados) as $fault)
                        <tr>
                            <td class="text-center border-bottom">
                                {{ $fault['date_view'] }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $fault['qtd'] }}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $fault['justified'] }}
                                {{-- @if ($fault['justified'] == 0)
                                    <span class="badge badge-error">Não</span>
                                @endif
                                @if ($fault['justified'] == 1)
                                    <span class="badge badge-success">Sim</span>
                                @endif --}}
                            </td>
                            <td class="text-center border-bottom">
                                {{ $fault['percentual'] }}%
                            </td>
                        </tr>
                    @endforeach

                </table>
            @else
                <div class="linha-tabela">Não possui</div>
            @endif
        </div>
        @if ($signature)
            <table>
                <tr>
                    <td
                        style="
                    width: 45%;
                    text-align: center;
                    padding-top: 30px;">
                        &nbsp;</td>
                    <td
                        style="
                            width: 55%;
                            text-align: center;
                            padding-top: 30px;">

                        {{-- Imagem da assinatura acima do texto --}}
                        <img src="{{ $signature }}" style="width: 150px; margin-bottom: -25px;">
                        {{-- Nome do comandante --}}
                        <p style="margin: 0;">
                            {{ mb_strtoupper($student?->company?->comandant->name) }} -
                            {{ mb_strtoupper(MilitaryRank::fromDb($student?->company?->comandant->posto_grad)?->label() ?? '') }}

                        </p>

                        {{-- Cargo abaixo --}}
                        <p style="margin: 0;">
                            COMANDANTE DA {{ mb_strtoupper($student?->company?->name) }}
                        </p>
                    </td>
                </tr>
            </table>
        @endif

    </div>
</body>

</html>
