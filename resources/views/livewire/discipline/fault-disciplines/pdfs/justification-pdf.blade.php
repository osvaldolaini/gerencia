<!DOCTYPE html>
@php
    use App\Enums\MilitaryRank;
@endphp

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

        .number {
            font-weight: bold;
            font-size: 18pt;
            width: 100%;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .assign {
            border-top: 1px solid black;
            width: 100%;
            text-align: center;
            padding: 30px;
        }

        .mt-0 {
            margin-top: opx;
        }

        .pt-0 {
            padding-top: opx;
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
                            Nr:{{ $fault_discipline->number }}/{{ $fault_discipline->year }} <br>
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
                        ({{ count($fault_discipline->json_faults) > 0 ? 'itens' : 'item' }}
                        @if (is_array($fault_discipline->json_faults) && count($fault_discipline->json_faults) > 0)
                            @foreach ($fault_discipline->json_faults as $key => $item)
                                {{ $item }}@if ($loop->remaining === 1)
                                    e
                                @elseif (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @endif do
                        apêndice 1 do anexo F do RICM 2024)
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
                    <td colspan="4" class="assign"
                        style="border-top: 1px solid black;
                        width: 100%;
                        text-align: center;
                        padding-top: 15px;">

                        {{-- Imagem da assinatura acima do texto --}}
                        @if ($signature)
                            <img src="{{ $signature }}" style="width: 150px; margin-bottom: -25px;">
                        @endif


                        {{-- Nome do comandante --}}
                        <p style="margin: 0;">
                            {{ mb_strtoupper($fault_discipline?->cmt_cia_posto ?? $fault_discipline?->company?->comandant?->posto_grad) }}
                            {{ mb_strtoupper($fault_discipline?->cmt_cia ?? $fault_discipline?->company?->comandant?->posto_grad) }}
                        </p>

                        {{-- Cargo abaixo --}}
                        <p style="margin: 0;">
                            COMANDANTE DA {{ mb_strtoupper($fault_discipline->cia) }}
                        </p>
                    </td>

                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black;">
                        COMPETÊNCIA SOCIOEMOCIONAL:
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
    <div>
        <div class="header" style="border: none;">

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
                            prazo constitui falta disciplinar constante no apêndice 1 do anexo F do Regimento Interno
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
                        Recebi a Ficha de Informação de Ocorrência
                        nr:{{ $fault_discipline->number }}/{{ $fault_discipline->year }} em ___/___/20___
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
            <div style="margin-bottom: 10px;margin-top:10px;">
                <svg viewBox="0 0 600 600" version="1.1" id="svg9724" sodipodi:docname="cut.svg"
                    inkscape:version="1.2.2 (1:1.2.2+202212051550+b0a8486541)" width="15" height="15"
                    xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                    xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                    xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                    <defs id="defs9728" />
                    <sodipodi:namedview id="namedview9726" pagecolor="#ffffff" bordercolor="#666666"
                        borderopacity="1.0" inkscape:showpageshadow="2" inkscape:pageopacity="0.0"
                        inkscape:pagecheckerboard="0" inkscape:deskcolor="#d1d1d1" showgrid="true"
                        inkscape:zoom="0.84118632" inkscape:cx="342.96801" inkscape:cy="245.48664"
                        inkscape:window-width="1920" inkscape:window-height="1009" inkscape:window-x="0"
                        inkscape:window-y="1080" inkscape:window-maximized="1" inkscape:current-layer="g10449"
                        showguides="true">
                        <inkscape:grid type="xygrid" id="grid9972" originx="0" originy="0" />
                        <sodipodi:guide position="-260,300" orientation="0,-1" id="guide383"
                            inkscape:locked="false" />
                        <sodipodi:guide position="300,520" orientation="1,0" id="guide385"
                            inkscape:locked="false" />
                        <sodipodi:guide position="240,520" orientation="0,-1" id="guide939"
                            inkscape:locked="false" />
                        <sodipodi:guide position="220,80" orientation="0,-1" id="guide941"
                            inkscape:locked="false" />
                        <sodipodi:guide position="470,130" orientation="-0.70710678,-0.70710678" id="guide960"
                            inkscape:locked="false" />
                        <sodipodi:guide position="210,210" orientation="0.70710678,-0.70710678" id="guide962"
                            inkscape:locked="false" />
                    </sodipodi:namedview>

                    <g id="g10449" transform="matrix(0.95173205,0,0,0.95115787,13.901174,12.168794)"
                        style="stroke-width:1.05103">
                        <path id="path294-3"
                            style="color:#000000;fill:#020202;stroke-linecap:round;stroke-linejoin:round;-inkscape-stroke:none;paint-order:stroke fill markers"
                            d="M 100.97462 -12.787504 C 37.500351 -12.787504 -14.612341 39.366977 -14.612341 102.8487 C -14.612341 166.33042 37.500351 218.49106 100.97462 218.49106 C 123.26336 218.49106 144.13783 212.03892 161.86073 200.9446 L 252.96519 292.102 L 248.48528 292.102 A 10.5103 10.5103 0 0 0 237.97402 302.61139 A 10.5103 10.5103 0 0 0 248.48528 313.12079 L 252.96519 313.12079 L 161.86073 404.27819 C 144.13783 393.18387 123.26336 386.73173 100.97462 386.73173 C 37.500351 386.73173 -14.612341 438.89236 -14.612341 502.37409 C -14.612341 565.8558 37.500351 618.01029 100.97462 618.01029 C 164.44888 618.01029 216.56568 565.8558 216.56568 502.37409 C 216.56568 480.07229 210.11237 459.17896 199.01544 441.443 L 289.47141 350.93448 L 544.05043 605.68567 A 42.041351 42.041351 0 0 0 573.77215 618.01029 A 42.041351 42.041351 0 0 0 603.50412 605.70826 A 42.041351 42.041351 0 0 0 603.52465 546.24948 L 370.55507 313.12079 L 374.60813 313.12079 A 10.5103 10.5103 0 0 0 385.11939 302.61139 A 10.5103 10.5103 0 0 0 374.60813 292.102 L 370.55507 292.102 L 603.52465 58.973307 A 42.041351 42.041351 0 0 0 603.50412 -0.48547435 A 42.041351 42.041351 0 0 0 573.77215 -12.787504 A 42.041351 42.041351 0 0 0 544.05043 -0.46288675 L 289.47141 254.2883 L 199.01544 163.77772 C 210.11237 146.04177 216.56568 125.15049 216.56568 102.8487 C 216.56568 39.366977 164.44888 -12.787504 100.97462 -12.787504 z M 100.97462 50.272973 C 130.34718 50.272973 153.5022 73.427543 153.5022 102.8487 C 153.5022 132.26985 130.34718 155.42853 100.97462 155.42853 C 71.602067 155.42853 48.449083 132.26985 48.449083 102.8487 C 48.449083 73.427543 71.602067 50.272973 100.97462 50.272973 z M -3.7645203 292.102 A 10.5103 10.5103 0 0 0 -14.273732 302.61139 A 10.5103 10.5103 0 0 0 -3.7645203 313.12079 L 17.258006 313.12079 L 38.278481 313.12079 A 10.5103 10.5103 0 0 0 48.789744 302.61139 A 10.5103 10.5103 0 0 0 38.278481 292.102 L 17.258006 292.102 L -3.7645203 292.102 z M 80.31943 292.102 A 10.5103 10.5103 0 0 0 69.808167 302.61139 A 10.5103 10.5103 0 0 0 80.31943 313.12079 L 101.3399 313.12079 L 122.36038 313.12079 A 10.5103 10.5103 0 0 0 132.87164 302.61139 A 10.5103 10.5103 0 0 0 122.36038 292.102 L 101.3399 292.102 L 80.31943 292.102 z M 164.40133 292.102 A 10.5103 10.5103 0 0 0 153.89212 302.61139 A 10.5103 10.5103 0 0 0 164.40133 313.12079 L 185.4218 313.12079 L 206.44433 313.12079 A 10.5103 10.5103 0 0 0 216.95354 302.61139 A 10.5103 10.5103 0 0 0 206.44433 292.102 L 185.4218 292.102 L 164.40133 292.102 z M 416.64908 292.102 A 10.5103 10.5103 0 0 0 406.13781 302.61139 A 10.5103 10.5103 0 0 0 416.64908 313.12079 L 437.66955 313.12079 L 458.69003 313.12079 A 10.5103 10.5103 0 0 0 469.20129 302.61139 A 10.5103 10.5103 0 0 0 458.69003 292.102 L 437.66955 292.102 L 416.64908 292.102 z M 500.73303 292.102 A 10.5103 10.5103 0 0 0 490.21971 302.61139 A 10.5103 10.5103 0 0 0 500.73303 313.12079 L 521.75145 313.12079 L 542.77398 313.12079 A 10.5103 10.5103 0 0 0 553.28319 302.61139 A 10.5103 10.5103 0 0 0 542.77398 292.102 L 521.75145 292.102 L 500.73303 292.102 z M 584.81492 292.102 A 10.5103 10.5103 0 0 0 574.30366 302.61139 A 10.5103 10.5103 0 0 0 584.81492 313.12079 L 604.97964 313.12079 A 10.5103 10.5103 0 0 0 615.4909 302.61139 A 10.5103 10.5103 0 0 0 604.97964 292.102 L 584.81492 292.102 z M 100.97462 449.79426 C 130.34718 449.79426 153.5022 472.95294 153.5022 502.37409 C 153.5022 531.79524 130.34718 554.94981 100.97462 554.94981 C 71.602067 554.94981 48.449083 531.79524 48.449083 502.37409 C 48.449083 472.95294 71.602067 449.79426 100.97462 449.79426 z " />
                    </g>
                </svg>

                <div style="width:100%;border-bottom:#333 1px dashed;top-20"></div>
            </div>
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
                        Tomei ciência da Ficha de Informação de Ocorrência
                        nr:{{ $fault_discipline->number }}/{{ $fault_discipline->year }} em ___/___/20___
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
            <div style="margin-bottom: 10px;margin-top:10px;">
                <svg viewBox="0 0 600 600" version="1.1" id="svg9724" sodipodi:docname="cut.svg"
                    inkscape:version="1.2.2 (1:1.2.2+202212051550+b0a8486541)" width="15" height="15"
                    xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                    xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                    xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
                    <defs id="defs9728" />
                    <sodipodi:namedview id="namedview9726" pagecolor="#ffffff" bordercolor="#666666"
                        borderopacity="1.0" inkscape:showpageshadow="2" inkscape:pageopacity="0.0"
                        inkscape:pagecheckerboard="0" inkscape:deskcolor="#d1d1d1" showgrid="true"
                        inkscape:zoom="0.84118632" inkscape:cx="342.96801" inkscape:cy="245.48664"
                        inkscape:window-width="1920" inkscape:window-height="1009" inkscape:window-x="0"
                        inkscape:window-y="1080" inkscape:window-maximized="1" inkscape:current-layer="g10449"
                        showguides="true">
                        <inkscape:grid type="xygrid" id="grid9972" originx="0" originy="0" />
                        <sodipodi:guide position="-260,300" orientation="0,-1" id="guide383"
                            inkscape:locked="false" />
                        <sodipodi:guide position="300,520" orientation="1,0" id="guide385"
                            inkscape:locked="false" />
                        <sodipodi:guide position="240,520" orientation="0,-1" id="guide939"
                            inkscape:locked="false" />
                        <sodipodi:guide position="220,80" orientation="0,-1" id="guide941"
                            inkscape:locked="false" />
                        <sodipodi:guide position="470,130" orientation="-0.70710678,-0.70710678" id="guide960"
                            inkscape:locked="false" />
                        <sodipodi:guide position="210,210" orientation="0.70710678,-0.70710678" id="guide962"
                            inkscape:locked="false" />
                    </sodipodi:namedview>

                    <g id="g10449" transform="matrix(0.95173205,0,0,0.95115787,13.901174,12.168794)"
                        style="stroke-width:1.05103">
                        <path id="path294-3"
                            style="color:#000000;fill:#020202;stroke-linecap:round;stroke-linejoin:round;-inkscape-stroke:none;paint-order:stroke fill markers"
                            d="M 100.97462 -12.787504 C 37.500351 -12.787504 -14.612341 39.366977 -14.612341 102.8487 C -14.612341 166.33042 37.500351 218.49106 100.97462 218.49106 C 123.26336 218.49106 144.13783 212.03892 161.86073 200.9446 L 252.96519 292.102 L 248.48528 292.102 A 10.5103 10.5103 0 0 0 237.97402 302.61139 A 10.5103 10.5103 0 0 0 248.48528 313.12079 L 252.96519 313.12079 L 161.86073 404.27819 C 144.13783 393.18387 123.26336 386.73173 100.97462 386.73173 C 37.500351 386.73173 -14.612341 438.89236 -14.612341 502.37409 C -14.612341 565.8558 37.500351 618.01029 100.97462 618.01029 C 164.44888 618.01029 216.56568 565.8558 216.56568 502.37409 C 216.56568 480.07229 210.11237 459.17896 199.01544 441.443 L 289.47141 350.93448 L 544.05043 605.68567 A 42.041351 42.041351 0 0 0 573.77215 618.01029 A 42.041351 42.041351 0 0 0 603.50412 605.70826 A 42.041351 42.041351 0 0 0 603.52465 546.24948 L 370.55507 313.12079 L 374.60813 313.12079 A 10.5103 10.5103 0 0 0 385.11939 302.61139 A 10.5103 10.5103 0 0 0 374.60813 292.102 L 370.55507 292.102 L 603.52465 58.973307 A 42.041351 42.041351 0 0 0 603.50412 -0.48547435 A 42.041351 42.041351 0 0 0 573.77215 -12.787504 A 42.041351 42.041351 0 0 0 544.05043 -0.46288675 L 289.47141 254.2883 L 199.01544 163.77772 C 210.11237 146.04177 216.56568 125.15049 216.56568 102.8487 C 216.56568 39.366977 164.44888 -12.787504 100.97462 -12.787504 z M 100.97462 50.272973 C 130.34718 50.272973 153.5022 73.427543 153.5022 102.8487 C 153.5022 132.26985 130.34718 155.42853 100.97462 155.42853 C 71.602067 155.42853 48.449083 132.26985 48.449083 102.8487 C 48.449083 73.427543 71.602067 50.272973 100.97462 50.272973 z M -3.7645203 292.102 A 10.5103 10.5103 0 0 0 -14.273732 302.61139 A 10.5103 10.5103 0 0 0 -3.7645203 313.12079 L 17.258006 313.12079 L 38.278481 313.12079 A 10.5103 10.5103 0 0 0 48.789744 302.61139 A 10.5103 10.5103 0 0 0 38.278481 292.102 L 17.258006 292.102 L -3.7645203 292.102 z M 80.31943 292.102 A 10.5103 10.5103 0 0 0 69.808167 302.61139 A 10.5103 10.5103 0 0 0 80.31943 313.12079 L 101.3399 313.12079 L 122.36038 313.12079 A 10.5103 10.5103 0 0 0 132.87164 302.61139 A 10.5103 10.5103 0 0 0 122.36038 292.102 L 101.3399 292.102 L 80.31943 292.102 z M 164.40133 292.102 A 10.5103 10.5103 0 0 0 153.89212 302.61139 A 10.5103 10.5103 0 0 0 164.40133 313.12079 L 185.4218 313.12079 L 206.44433 313.12079 A 10.5103 10.5103 0 0 0 216.95354 302.61139 A 10.5103 10.5103 0 0 0 206.44433 292.102 L 185.4218 292.102 L 164.40133 292.102 z M 416.64908 292.102 A 10.5103 10.5103 0 0 0 406.13781 302.61139 A 10.5103 10.5103 0 0 0 416.64908 313.12079 L 437.66955 313.12079 L 458.69003 313.12079 A 10.5103 10.5103 0 0 0 469.20129 302.61139 A 10.5103 10.5103 0 0 0 458.69003 292.102 L 437.66955 292.102 L 416.64908 292.102 z M 500.73303 292.102 A 10.5103 10.5103 0 0 0 490.21971 302.61139 A 10.5103 10.5103 0 0 0 500.73303 313.12079 L 521.75145 313.12079 L 542.77398 313.12079 A 10.5103 10.5103 0 0 0 553.28319 302.61139 A 10.5103 10.5103 0 0 0 542.77398 292.102 L 521.75145 292.102 L 500.73303 292.102 z M 584.81492 292.102 A 10.5103 10.5103 0 0 0 574.30366 302.61139 A 10.5103 10.5103 0 0 0 584.81492 313.12079 L 604.97964 313.12079 A 10.5103 10.5103 0 0 0 615.4909 302.61139 A 10.5103 10.5103 0 0 0 604.97964 292.102 L 584.81492 292.102 z M 100.97462 449.79426 C 130.34718 449.79426 153.5022 472.95294 153.5022 502.37409 C 153.5022 531.79524 130.34718 554.94981 100.97462 554.94981 C 71.602067 554.94981 48.449083 531.79524 48.449083 502.37409 C 48.449083 472.95294 71.602067 449.79426 100.97462 449.79426 z " />
                    </g>
                </svg>

                <div style="width:100%;border-bottom:#333 1px dashed;top-20"></div>
            </div>
            <div class="number">
                FAFD Nº {{ $fault_discipline->number }}/{{ $fault_discipline->year }}
            </div>
            <table class="identification" style="margin-top: 10px;">

                @if ($selectedFaults)
                    <tr>
                        <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                            Enquadramento
                        </td>
                    </tr>
                    @foreach ($selectedFaults as $number => $title)
                        <tr>
                            <td style="text-align:center;border-top: 1px solid black;">
                                {{ $number }})
                            </td>
                            <td style="text-align:center;border-top: 1px solid black;">
                                {{ $title }}
                            </td>
                        </tr>
                    @endforeach
                @endif

                @if ($selectedMitigating)
                    <tr>
                        <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                            Atenuantes
                        </td>
                    </tr>
                    @foreach ($selectedMitigating as $number => $title)
                        <tr>
                            <td style="text-align:center;border-top: 1px solid black;">
                                {{ $number }})
                            </td>
                            <td style="text-align:center;border-top: 1px solid black;">
                                {{ $title }}
                            </td>
                        </tr>
                    @endforeach
                @endif
                @if ($selectedAggravating)
                    <tr>
                        <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                            Agravantes
                        </td>
                    </tr>
                    @foreach ($selectedAggravating as $number => $title)
                        <tr>
                            <td style="text-align:center;border-top: 1px solid black;">
                                {{ $number }})
                            </td>
                            <td style="text-align:center;border-top: 1px solid black;">
                                {{ $title }}
                            </td>
                        </tr>
                    @endforeach
                @endif

                @if ($selectedFaults)
                    <tr>
                        <td colspan="4" Style="font-weight: bold;text-align:center;border-top: 1px solid black;">
                            Reincidente na(s) falta(s) nr
                        </td>
                    </tr>
                    @foreach ($selectedFaults as $faults)
                        {{ $faults }}
                        {{ $fault_discipline->reincident($faults, $fault_discipline->fact_date, $fault_discipline->student_id) }}
                        @if ($fault_discipline->reincident($faults, $fault_discipline->fact_date, $fault_discipline->student_id) > 0)
                            <tr>
                                <td style="text-align:center;border-top: 1px solid black;">
                                    {{ $faults }}
                                </td>
                                <td style="text-align:center;border-top: 1px solid black;">
                                    {{ $fault_discipline->reincident($faults, $fault_discipline->fact_date, $fault_discipline->student_id) }}x
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</body>

</html>
