<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <x-favicons></x-favicons>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        .break-page {
            page-break-before: always;
        }

        .container {
            width: 100%;
            border: 1px solid black;
            margin-top: 20px;
        }

        p {
            text-align: justify;
            text-indent: 1.5cm;
        }

        .header {
            width: 100%;
            border: 1px solid black;
        }

        .header table {
            padding: 10px;
            width: 100%;
            border-collapse: collapse;
        }

        .header tr td {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            vertical-align: center;
            font-weight: bold;
        }

        .identification {
            width: 100%;
            border: 1px solid black;
        }

        .identification table {
            padding: 10px;
            width: 100%;
            border-collapse: collapse;
        }

        .identification tr td {
            text-align: left;
            vertical-align: center;
            padding-left: 5px;
            font-weight: thin;
        }

        .title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        .section {
            margin-top: 10px;
            padding: 5px;
            border: 1px solid black;
        }

        .label {
            font-weight: bold;
        }

        .signature {
            margin-top: 20px;
            text-align: center;
        }

        .checkbox {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 1px solid black;
            margin-right: 5px;
        }

        .small-text {
            font-size: 10px;
            text-align: justify;
        }
    </style>
    <title>{{ $title_postfix }} </title>
</head>

<body>

    <div class="title">APURAÇÃO DE FALTA DISCIPLINAR/ELOGIO </div>
    <div class="container">
        <div class="header">
            <table>
                <tr>
                    <td style="border-right: 1px solid black;">
                        <div class="title">MINISTÉRIO DA DEFESA</div>
                        <div class="title">EXÉRCITO BRASILEIRO</div>
                        <div class="title">{{ $config->name }}</div>
                    </td>
                    <td>
                        <div class="title">FICHA DE APURAÇÃO DE FALTA DISCIPLINAR/ELOGIO</div>
                        <div style="font-size: 16px;">
                            Nr:</span>{{ $fault_discipline->number }}/{{ $fault_discipline->year }} <br>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 1px solid black;">
                        <div class="title">{{ $fault_discipline->cia }} - {{ $fault_discipline->year }}</div>
                    </td>
                </tr>
            </table>
            <table class="identification">
                <tr>
                    <td style="border-right: 1px solid black;">
                        Alu Nr: {{ $fault_discipline->al_number }}
                    </td>
                    <td colspan="2" style=" border-right: 1px solid black;">
                        NOME: {{ $fault_discipline->al_name }}
                    </td>
                    <td style="border-top: 1px solid black;">
                        TURMA: {{ $fault_discipline->al_class }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border-top: 1px solid black;border-right: 1px solid black;">
                        OBSERVADOR: {{ $fault_discipline->fact_observer }}
                    </td>
                    <td style="border-top: 1px solid black;">
                        DATA: {{ $fault_discipline->f_date }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                        RELATO DO FATO
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">
                        {{ $fault_discipline->fact }}
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid black;border-right: 1px solid black;">
                        FATO OBSERVADO:
                    </td>
                    <td style="border-top: 1px solid black;border-right: 1px solid black;">
                        POSITIVO: ( {{ $fault_discipline->fact_type == 'positivo' ? 'X' : '' }} )
                    </td>
                    <td style="border-top: 1px solid black; border-right: 1px solid black;">
                        NEGATIVO: ( {{ $fault_discipline->fact_type == 'negativo' ? 'X' : '' }} )
                    </td>
                    <td style="border-top: 1px solid black;">
                        INFORMATIVO: ( {{ $fault_discipline->fact_type == 'informativo' ? 'X' : '' }} )
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">
                        COMPETÊNCIA SOCIOEMOCIONAL:
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                        ALEGAÇÕES DO(A) ALUNO(A) SOBRE O FATO OBSERVADO
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid black; border-right: 1px solid black;">
                        Alu Nr: {{ $fault_discipline->al_number }}
                    </td>
                    <td colspan="2" style="border-top: 1px solid black; border-right: 1px solid black;">
                        NOME: {{ $fault_discipline->al_nick }}
                    </td>
                    <td style="border-top: 1px solid black;">
                        TURMA: {{ $fault_discipline->al_class }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border-top: 1px solid black; border-right: 1px solid black;">
                        ASSINATURA DO ALUNO: __________________________________________
                    </td>
                    <td style="border-top: 1px solid black; ">
                        DATA: ___/___/20___
                    </td>
                </tr>
                <tr>
                    <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                        ALEGAÇÕES DO RESPONSÁVEL SOBRE O FATO OBSERVADO
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">

                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border-top: 1px solid black; border-right: 1px solid black;">
                        NOME DO RESPONSÁVEL: __________________________________________
                    </td>
                    <td style="border-top: 1px solid black; border-right: 1px solid black;">
                        PARENTESCO: ________________
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border-top: 1px solid black; border-right: 1px solid black;">
                        ASSINATURA DO RESPONSÁVEL: __________________________________________
                    </td>
                    <td style="border-top: 1px solid black; ">
                        DATA: ___/___/20___
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="break-page"></div>
    <div class="container">
        <div class="header">

            <table class="identification">
                <tr>
                    <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                        ÁREA DESTINADA AO CONTROLE DO RECEBIMENTO PELO(A) ALUNO(A)
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">
                        <p style="text-align: justify;">
                            O prazo para a devolução deste documento é de 3 (três) dias úteis. O não cumprimento deste
                            prazo constitui falta disciplinar constante no Apêndice 1 do Anexo F do Regimento Interno
                            dos Colégios Militares – RICM (nº 18 - Deixar de devolver à subunidade, dentro do prazo
                            estipulado, qualquer documento, devidamente visado pelo pai ou responsável.)
                        </p>
                        <p>
                            Após passadas os 3 (três) dias úteis, e não havendo a apresentação das alegações dentro do
                            prazo estipulado, o julgamento da medida disciplinar correspondente será efetuado à revelia
                            das possíveis explicações do aluno e/ou dos responsáveis.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border: 1px solid black;">
                        Recebi a presente Ficha de Informação de Ocorrência em ___/___/20___
                    </td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid black;">
                        Alu Nr: {{ $fault_discipline->al_number }}
                    </td>
                    <td colspan="2" style=" border-right: 1px solid black;">
                        Nome de guerra: {{ $fault_discipline->al_nick }}
                    </td>
                    <td style="border-right: 1px solid black;">
                        Turma: {{ $fault_discipline->al_class }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">
                        Assinatura do(a) Aluno(a): _______________________________________________________________
                    </td>
                </tr>

            </table>
            <table class="identification">
                <tr>
                    <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                        ÁREA DESTINADA AO CONTROLE DO RECEBIMENTO PELO RESPONSÁVEL
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">
                        <p>
                            Sr./Sra. Responsável, favor dar o ciente após a apresentação das alegações, tanto pelo aluno
                            quanto pelo(a) Sr.(a), sobre o fato observado em apuração. O prazo para a devolução deste
                            documento é de 3(três) dias úteis. O não cumprimento deste prazo constitui falta disciplinar
                            constante no Apêndice 1 do Anexo F do RICM (nº 18 - Deixar de devolver à subunidade, dentro
                            do prazo estipulado, qualquer documento, devidamente visado pelo pai ou responsável.)
                        </p>
                        <p>
                            Após passadas os 3 (três) dias úteis, e não havendo a apresentação das alegações dentro do
                            prazo estipulado, o julgamento da medida disciplinar correspondente será efetuado à revelia
                            das possíveis explicações do aluno e/ou dos responsáveis.
                        </p>

                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;border-right: 1px solid black;">
                        Tomei ciência da presente Ficha de Informação de Ocorrência em ___/___/20___
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">
                        Nome do Responsável:__________________________________________________________________
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border-top: 1px solid black; border-right: 1px solid black;">
                        Assinatura do Responsável
                    </td>
                    <td style="border-top: 1px solid black; "> em ____/____/20___ </td>
                </tr>

            </table>
        </div>
    </div>
</body>

</html>
