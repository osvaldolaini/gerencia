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

        .porta {
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
            background-color: #e0e411;
            text-align: center;
            font-size: 16pt;
            max-width: 10%;

        }

        .charir {
            width: 25px;
            color: #676a70;
        }
    </style>
</head>

<body>
    @foreach ($school_classes as $class)
        <h2 class="h2">Espelho da Turma: {{ $class->title }}</h2>
        <table style="margin-bottom: 5px;">
            <tr>
                @if ($class->door_side === 'top_left')
                    <td class="door" rowspan="{{ $class->rows }}">PORTA</td>
                @endif


                <td class="square" colspan="{{ $class->columns }}">Quadro</td>

                @if ($class->door_side === 'top_right')
                    <td class="door" rowspan="{{ $class->rows }}">PORTA</td>
                @endif
            </tr>
        </table>
        <table class="table">

            @for ($r = 1; $r <= $class->rows; $r++)
                <tr>
                    @if ($class->door_side === 'left' && $r === 1)
                        <td class="door" rowspan="{{ $class->rows }}">PORTA</td>
                        {{ $class->rows - 1 }}
                    @endif

                    @for ($c = 1; $c <= $class->columns; $c++)
                        @php

                            $seat = $class->seats->first(fn($s) => (int) $s->row === $r && (int) $s->column === $c);
                            $number = $seat?->students?->number ?? 'Vazio';
                            $classe = $seat?->students ? 'ocupado' : 'vazio';
                        @endphp
                        <td class="{{ $classe }}">

                            @if ($seat?->students)
                                <table style="border-collapse: collapse; border:none;">
                                    <tr>
                                        <td style="border:none;">
                                            <img src="{{ url('storage/student/' . $seat?->students?->id . '/' . $seat?->students?->code_image . '_list.png') }}"
                                                alt="{{ $seat?->students?->name }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:none;">
                                            Nr {{ $number }}
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <table style="border-collapse: collapse; border:none;">
                                    <tr>
                                        <td style="border:none;">
                                            <svg class="chair" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"
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
                                                                            <g id="Group_3236" data-name="Group 3236">
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



                        </td>
                    @endfor

                    @if ($class->door_side === 'right' && $r === 1)
                        <td class="door" rowspan="{{ $class->rows }}">PORTA</td>
                    @endif
                </tr>
            @endfor
        </table>
        @if ($class->door_side === 'bottom_left' or $class->door_side === 'bottom_right')
        @endif
        <table style="margin-bottom: 5px; width:100%">
            <tr>
                @if ($class->door_side === 'bottom_left')
                    <td class="door" rowspan="{{ $class->rows }}">PORTA</td>
                @endif


                <td class="square_bottom" colspan="{{ $class->columns }}">Fundo</td>

                @if ($class->door_side === 'bottom_right')
                    <td class="door" rowspan="{{ $class->rows }}">PORTA</td>
                @endif
            </tr>
        </table>

        {{-- quebra de página --}}
        @if (!$loop->last)
            <pagebreak />
        @endif
    @endforeach

</body>

</html>
