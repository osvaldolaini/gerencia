<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Espelho da Classe</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table td {
            border: none;
            text-align: center;
            padding: 10px;
            font-size: 12px;
        }


        . <svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" /></svg> {
            background-color: #facc15;
            font-weight: bold;
        }

        /* .ocupado {
            background-color: #bbf7d0;
        }

        .vazio {
            background-color: #e5e7eb;
        } */

        .h2 {
            margin-top: 40px;
            padding-top: 40px;
            text-align: center;
        }

        .square {
            background-color: #1043cf;
            text-align: center;
            font-size: 16pt;
            color: white;

        }

        .square_bottom {
            background-color: #a9b0c2;
            text-align: center;
            font-size: 16pt;
            color: rgb(15, 15, 15);

        }

        .door {
            background-color: #fbfcd5;
            text-align: center;
            font-size: 16pt;
            max-width: 10%;

        }

        .top_bottom_door {
            /* background-color: #e0e411; */
            text-align: top;
            font-size: 16pt;
            width: 10%;
            background-color: #fbfcd5;
        }

        .door_icon {
            background-color: #d3d610;
            border-radius: 10px;
            border: solid 1px #d3d610;
            padding: 20px;
            margin: 20px;
            width: 50px;

        }

        .charir {
            width: 25px;
            color: #676a70;
        }
    </style>
</head>

<body>
    @foreach ($school_classes as $class)
        <h2 class="h2" style="text-align: center; margin-top: 40px;">
            @if ($class->classroom_board_side == 'front')
                Espelho da Turma: {{ $class->title }}
            @else
                <svg width="500" height="40" viewBox="0 0 500 40" xmlns="http://w3.org">
                    <!-- x="250" y="20" coloca o texto no centro do SVG de 500x40 -->
                    <text x="250" y="25" text-anchor="middle" transform="rotate(180, 250, 20)"
                        style="font-family: sans-serif; font-size: 16pt; font-weight: bold; fill: #000;">
                        Espelho da Turma: {{ $class->title }}
                    </text>
                </svg>
            @endif

        </h2>

        <table>
            <tr>
                <td class="top_bottom_door" style="width:20%;align-items: left; text-align:center;align-items: center; "
                    rowspan="{{ $class->rows }}">
                    @if ($class->door_side === 'top_left')
                        <div class="door_icon"><svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                            </svg>
                        </div>
                    @endif
                </td>
                <td class="square" style="width:80%; height:40px; padding: 0;">
                    @if ($class->classroom_board_side == 'front')
                        <span>Quadro</span>
                    @else
                        <!-- SVG com largura 100% da célula -->
                        <svg width="100%" height="40" viewBox="0 0 400 40" xmlns="http://w3.org">
                            <!-- Fundo Azul (Opcional, caso o CSS da TD falhe) -->
                            <rect width="400" height="40" fill="#1043cf" />

                            <!-- Texto Branco Invertido -->
                            <text x="200" y="26" text-anchor="middle" transform="rotate(180, 200, 20)"
                                style="font-family: sans-serif; font-size: 16pt; font-weight: bold; fill: #ffffff;">
                                Quadro
                            </text>
                        </svg>
                    @endif
                </td>


                <td class="top_bottom_door" style="width:20%;text-align:center;align-items: center;"
                    rowspan="{{ $class->rows }}">
                    @if ($class->door_side === 'top_right')
                        <div class="door_icon" style="padding:10px;display:flex;">
                            <svg fill="#000000" width="30px;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                            </svg>
                        </div>
                    @endif
                </td>
            </tr>
        </table>
        <table class="table" style=" border:none; margin: 0px; padding:0px;">
            @for ($r = 1; $r <= $class->rows; $r++)
                <tr style="margin: 0px; padding:0px;">
                    @if ($r === 1)
                        <td class="door" style="width:10%;align-items: top; vertical-align:top;"
                            rowspan="{{ $class->rows }}">
                            @if ($class->door_side === 'left')
                                <div class="door_icon"><svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        {{ $class->rows - 1 }}
                    @endif

                    {{-- @for ($r = 1; $r <= $rows; $r++) --}}
                    @for ($c = 1; $c <= $class->columns; $c++)
                        {{-- @for ($c = $class->columns; $c >= 1; $c--) --}}
                        @php
                            $seat = $class->seats->first(fn($s) => (int) $s->row === $r && (int) $s->column === $c);
                            $number = $seat?->students?->number ?? 'Vazio';
                            $classe = $seat?->students ? 'ocupado' : 'vazio';
                        @endphp
                        <td class="{{ $classe }}" style="margin: 2px; padding:2px;">
                            @if ($class->classroom_board_side == 'front')
                                @if ($seat?->students)
                                    <table style="border-collapse: collapse; border:none; margin: 0px; padding:0px;">
                                        <tr style="margin: 0px; padding:0px;">
                                            <td style="border:none; margin: 0px; padding:0px;">
                                                <img width="45px"
                                                    src="{{ url('storage/student/' . $seat?->students?->id . '/' . $seat?->students?->code_image . '_list.png') }}"
                                                    alt="{{ $seat?->students?->name }}">
                                            </td>
                                        </tr>
                                        <tr style="margin: 0px; padding:0px;">
                                            <td style="margin: 0px; padding:0px; font-size:8pt;">
                                                <span style="page-break-after: always;">
                                                    {{-- {{ $seat?->students?->nick }} --}}
                                                    {!! str_replace(' ', '<br>', $seat?->students?->nick) !!}
                                                </span>

                                            </td>
                                        </tr>
                                        <tr style="margin: 0px; padding:0px; font-size:6pt;">
                                            <td style="border:none; margin: 0px; padding:0px; font-size:6pt;">
                                                {{ $number }}
                                            </td>
                                        </tr>
                                    </table>
                                @else
                                    <table style="border-collapse: collapse; border:none;">
                                        <tr>
                                            <td style="border:none;">
                                                <svg class="chair" viewBox="0 0 32 32"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <defs>
                                                        <clipPath id="clip-desk">
                                                            <rect width="32" height="32" />
                                                        </clipPath>
                                                    </defs>
                                                    <g id="desk" clip-path="url(#clip-desk)">
                                                        <g id="Group_3242" data-name="Group 3242"
                                                            transform="translate(-312 -52)">
                                                            <g id="Group_3241" data-name="Group 3241">
                                                                <g id="Group_3240" data-name="Group 3240">
                                                                    <g id="Group_3239" data-name="Group 3239">
                                                                        <g id="Group_3238" data-name="Group 3238">
                                                                            <g id="Group_3237" data-name="Group 3237">
                                                                                <g id="Group_3236"
                                                                                    data-name="Group 3236">
                                                                                    <g id="Group_3235"
                                                                                        data-name="Group 3235">
                                                                                        <path id="Path_4015"
                                                                                            data-name="Path 4015"
                                                                                            d="M341.25,61.45H329.583a1,1,0,0,0,0,2h4.761a5.554,5.554,0,0,1-2.077,3.742H321.111l-4.462-11.526a1.5,1.5,0,0,0-2.8,1.084l4.833,12.484a1.5,1.5,0,0,0,1.4.958h.771L318.37,76l0,.006L316.7,79.9a1,1,0,0,0,.528,1.313.986.986,0,0,0,.392.08,1,1,0,0,0,.92-.607l1.4-3.288h14.392l1.4,3.289a1,1,0,0,0,1.84-.788l-4.149-9.706h1.979a1.5,1.5,0,0,0,0-3H335a7.711,7.711,0,0,0,1.363-3.742h4.884a1,1,0,0,0,0-2ZM333.486,75.4H320.8l2.225-5.205h8.231Z"
                                                                                            fill="#344952" />
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border:none;">
                                                {{ $number }}
                                            </td>
                                        </tr>
                                    </table>
                                @endif
                            @else
                                @if ($seat?->students)
                                    <table style="border-collapse: collapse; width: 100%; margin: 0; padding: 0;">
                                        <!-- NÚMERO - Altura reduzida para 10 -->
                                        <tr>
                                            <td style="text-align: center; padding: 0; line-height: 1px;">
                                                <svg width="60" height="10" viewBox="0 0 60 10"
                                                    xmlns="http://w3.org" style="display: block;">
                                                    <text x="30" y="8" text-anchor="middle"
                                                        transform="rotate(180, 30, 5)"
                                                        style="font-family: sans-serif; font-size: 8px; fill: #000;">
                                                        {{ $number }}
                                                    </text>
                                                </svg>
                                            </td>
                                        </tr>

                                        <!-- NOME COMPOSTO - Altura ajustada e Ys aproximados -->
                                        <tr>
                                            <td style="text-align: center; padding: 0; line-height: 1px;">
                                                @php
                                                    $nomePartes = explode(' ', $seat?->students?->nick);
                                                    $linha1 = $nomePartes[0] ?? '';
                                                    $linha2 = isset($nomePartes[1])
                                                        ? implode(' ', array_slice($nomePartes, 1))
                                                        : '';
                                                @endphp

                                                <svg width="80" height="{{ $linha2 ? '22' : '11' }}"
                                                    viewBox="0 0 80 {{ $linha2 ? '22' : '11' }}"
                                                    xmlns="http://w3.org" style="display: block;">
                                                    <!-- Linha 1 -->
                                                    <text x="40" y="8" text-anchor="middle"
                                                        transform="rotate(180, 40, {{ $linha2 ? '11' : '5.5' }})"
                                                        style="font-family: sans-serif; font-size: 8px; fill: #000;">
                                                        {{ $linha1 }}
                                                    </text>

                                                    @if ($linha2)
                                                        <!-- Linha 2 aproximada (y=18 em vez de 22) -->
                                                        <text x="40" y="18" text-anchor="middle"
                                                            transform="rotate(180, 40, 11)"
                                                            style="font-family: sans-serif; font-size: 8px; fill: #000;">
                                                            {{ $linha2 }}
                                                        </text>
                                                    @endif
                                                </svg>
                                            </td>
                                        </tr>

                                        <!-- FOTO -->
                                        <tr>
                                            <td style="text-align: center; padding: 0; line-height: 1px;">
                                                <img width="45px"
                                                    style="transform: rotate(180deg); display: block; margin: 0 auto;"
                                                    src="{{ url('storage/student/' . $seat?->students?->id . '/' . $seat?->students?->code_image . '_list.png') }}">
                                            </td>
                                        </tr>
                                    </table>
                                @else
                                    <table style="border-collapse: collapse; border:none;">
                                        <tr>
                                            <td style="border:none;">
                                                <svg class="chair" viewBox="0 0 32 32"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <defs>
                                                        <clipPath id="clip-desk">
                                                            <rect width="32" height="32" />
                                                        </clipPath>
                                                    </defs>
                                                    <g id="desk" clip-path="url(#clip-desk)">
                                                        <g id="Group_3242" data-name="Group 3242"
                                                            transform="translate(-312 -52)">
                                                            <g id="Group_3241" data-name="Group 3241">
                                                                <g id="Group_3240" data-name="Group 3240">
                                                                    <g id="Group_3239" data-name="Group 3239">
                                                                        <g id="Group_3238" data-name="Group 3238">
                                                                            <g id="Group_3237" data-name="Group 3237">
                                                                                <g id="Group_3236"
                                                                                    data-name="Group 3236">
                                                                                    <g id="Group_3235"
                                                                                        data-name="Group 3235">
                                                                                        <path id="Path_4015"
                                                                                            data-name="Path 4015"
                                                                                            d="M341.25,61.45H329.583a1,1,0,0,0,0,2h4.761a5.554,5.554,0,0,1-2.077,3.742H321.111l-4.462-11.526a1.5,1.5,0,0,0-2.8,1.084l4.833,12.484a1.5,1.5,0,0,0,1.4.958h.771L318.37,76l0,.006L316.7,79.9a1,1,0,0,0,.528,1.313.986.986,0,0,0,.392.08,1,1,0,0,0,.92-.607l1.4-3.288h14.392l1.4,3.289a1,1,0,0,0,1.84-.788l-4.149-9.706h1.979a1.5,1.5,0,0,0,0-3H335a7.711,7.711,0,0,0,1.363-3.742h4.884a1,1,0,0,0,0-2ZM333.486,75.4H320.8l2.225-5.205h8.231Z"
                                                                                            fill="#344952" />
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border:none;">
                                                {{ $number }}
                                            </td>
                                        </tr>
                                    </table>
                                @endif
                            @endif

                        </td>
                    @endfor

                    @if ($r === 1)
                        <td class="door" style="width:10%;align-items: top; vertical-align:top; "
                            rowspan="{{ $class->rows }}">
                            @if ($class->door_side === 'right')
                                <div class="door_icon">
                                    <svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        {{ $class->rows - 1 }}
                    @endif
                </tr>
            @endfor
        </table>

        <table style="margin-bottom: 5px;">
            <tr>
                <td class="top_bottom_door"
                    style="width:20%;align-items: left; text-align:center;align-items: center; "
                    rowspan="{{ $class->rows }}">
                    @if ($class->door_side === 'bottom_left')
                        <div class="door_icon"><svg fill="#000000" class="w-10 h-10" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                            </svg>
                        </div>
                    @endif
                </td>
                <td class="square_bottom" style="width:80%; height:40px; padding: 0;">
                    @if ($class->classroom_board_side == 'front')
                        <span>FUNDO</span>
                    @else
                        <!-- SVG com largura 100% da célula -->
                        <svg width="100%" height="40" viewBox="0 0 400 40" xmlns="http://w3.org">
                            <!-- Fundo Azul (Opcional, caso o CSS da TD falhe) -->
                            <rect width="400" height="40" />

                            <!-- Texto Branco Invertido -->
                            <text x="200" y="26" text-anchor="middle" transform="rotate(180, 200, 20)"
                                style="font-family: sans-serif; font-size: 16pt; font-weight: bold; fill: #ffffff;">
                                FUNDO
                            </text>
                        </svg>
                    @endif

                </td>
                {{-- <td class="square_bottom" style="width:80%;">FUNDO</td> --}}

                <td class="top_bottom_door" style="width:20%;text-align:center;align-items: center;"
                    rowspan="{{ $class->rows }}">
                    @if ($class->door_side === 'bottom_right')
                        <div class="door_icon" style=" padding:10px;">
                            <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4,23H20a1,1,0,0,0,0-2V2a1,1,0,0,0-1-1H5A1,1,0,0,0,4,2V21a1,1,0,0,0,0,2ZM6,3H18V21H6Zm3,8v2a1,1,0,0,1-2,0V11a1,1,0,0,1,2,0Z" />
                            </svg>
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        {{-- quebra de página --}}
        @if (!$loop->last)
            <pagebreak />
        @endif
    @endforeach

</body>

</html>
