<!DOCTYPE html>
<html lang="pt-BR">
@php
    use Carbon\Carbon;
@endphp

<head>
    <meta charset="UTF-8">
    <title>Mapa de Faltas Disciplinares</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .box {
            border: 1.5px solid black;
        }

        .bt {
            border-top: 1px solid black;
        }

        table {
            border-collapse: collapse;

        }

        h1 {
            text-align: center;
            font-size: 12pt;
        }

        .assinaturas {
            margin-top: 40px;
            font-size: 10pt;
        }

        .assinaturas p {
            margin: 6px 0;
        }

        span {
            font-weight: bold;
        }

        .t-left {
            text-align: left;
        }

        .t-right {
            text-align: right;
        }

        .vertical-text {
            writing-mode: vertical-rl;
            text-align: center;
        }

        .rotate-text {
            transform: rotate(-90deg);
            transform-origin: left top;
            white-space: nowrap;
        }
    </style>

</head>

<body>

    <h1>MAPA DE FALTAS DISCIPLINARES</h1>
    <div class="box">
        <table>
            <tr>
                <td class="t-left" width="80%">
                    <table>
                        <tr>
                            <td>
                                <span>MINISTÉRIO DA DEFESA</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span>EXÉRCITO BRASILEIRO</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: ">
                                <span>{{ $config->nick }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <th style="text-align: right;">
                    <table>
                        <tr>
                            <td class="t-left">
                                <span>QIE – 10</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="t-left">
                                <span>
                                    Assunto:
                                </span> estatística do ensino
                            </td>
                        </tr>
                        <tr>
                            <td class="t-left">
                                <span>Referência:</span> NRRD
                            </td>
                        </tr>
                    </table>
                </th>
            </tr>
        </table>
        <div class="bt" style="padding-top: 5px;padding-bottom:5px;text-align:center;">
            <span class="vertical-text">
                MAPA DISCIPLINAR DO CORPO DE ALUNOS DO {{ $config->nick }} NO PERÍODO DE
                {{ Carbon::createFromFormat('Y-m-d', $date_start)->format('d/m/Y') }}
                A
                {{ Carbon::createFromFormat('Y-m-d', $date_end)->format('d/m/Y') }}
            </span>
        </div>
        <table class="bt">
            <tr>
                <td width="10%">
                    <table>
                        <tr>
                            <td style="text-align: center">
                                Medidas disciplinares
                                e comportamentos

                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <p style="vertical-align: bottom;">
                                    Anos escolares
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <thead>
                            <tr>
                                <td colspan="6">
                                    Distribuição das medidas disciplinares
                                </td>
                            </tr>
                            <tr>
                                <th class="rotate-text">S<br>é<br>r<br>i<br>e</th>
                                <th>A<br>d<br>v<br>e<br>r<br>t<br>ê<br>n<br>c<br>i<br>a</th>
                                <th>R<br>e<br>p<br>r<br>e<br>e<br>n<br>s<br>ã<br>o</th>
                                <th>A<br>O<br>E</th>
                                <th>R<br>e<br>t<br>i<br>r<br>a<br>d<br>a</th>
                                <th>E<br>x<br>c<br>l<br>u<br>s<br>ã<br>o</th>
                                <th>T<br>O<br>T<br>A<br>L</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tabela as $serie => $valores)
                                <tr>
                                    <td>{{ $serie }}</td>
                                    <td>{{ $valores['advertencia'] ?? 0 }}</td>
                                    <td>{{ $valores['repreensao'] ?? 0 }}</td>
                                    <td>{{ $valores['atividade_orientacao_educacional'] ?? 0 }}</td>
                                    <td>{{ $valores['retirada_cm'] ?? 0 }}</td>
                                    <td>{{ $valores['exclusao_disciplinar'] ?? 0 }}</td>
                                    <td><strong>{{ $valores['TOTAL'] ?? 0 }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </td>
                <td>
                    <table>
                        <thead>
                            <tr>
                                <td colspan="6">
                                    Efetivo de Alunos por comportamento
                                </td>
                            </tr>
                            <tr>
                                <th class="vertical-text" style="writing-mode: vertical-rl;">Excepcional</th>
                                <th>Ótimo</th>
                                <th>Bom</th>
                                <th>Regular</th>
                                <th>Insuficiente</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            <tr>

                            </tr>
                        </tbody> --}}
                    </table>

                </td>
            </tr>
        </table>
        <table class="bt">
            <tr>
                <td class="t-left" width="80%">
                    <table>
                        <tr>
                            <td>
                                <strong>Guarnição / Data:</strong> ______ / ______ / 20__
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span><strong>Cmt CA:</strong> ___________________________________________</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="t-left" width="80%">
                    <table>
                        <tr>
                            <td>
                                <strong>Visto:</strong> _____________________________________________
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span><strong>Cmt CM:</strong> ___________________________________________</span>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>

    </div>


</body>

</html>
