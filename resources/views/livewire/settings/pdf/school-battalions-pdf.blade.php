<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <title>Batalhão</title>
    <style>
        .container {
            margin-top: 50px;
            padding-top: 70px;
            width: 100%;
            font-family: sans-serif;
        }

        .grade-title {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 50px;
            font-weight: bold;
            color: #555;
            margin-bottom: 20px;
        }

        .container table {
            width: 100%;
            border-collapse: collapse;
        }

        .container td {
            width: 33.33%;
            /* Garante três colunas iguais */
            padding: 16px;
            /* border: 1px solid #ddd;
            border-radius: 8px; */
            text-align: center;
            vertical-align: top;
        }

        .posto-container h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .rank-image {
            width: 3rem;
            height: auto;
            border-radius: 50%;
            display: block;
            margin: 0 auto 10px;
        }

        .student-item {
            padding-top: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .student-image {
            width: 6rem;
            height: auto;
            margin: 0 auto 8px;
            border-radius: 50%;
        }

        .student-item h3 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .student-item p {
            font-size: 14px;
        }
    </style>
</head>

<body>
    @php
        use App\Enums\Rank;
    @endphp
    <div class="container">

        <small class="grade-title">
            {{ $grade->name }}
        </small>


        <table>
            <tr>

                <!-- Define número de colunas -->
                @foreach ($school_battalion->where('active', 1)->sortBy('order')->groupBy('posto_grad') as $posto => $items)
                    <td>

                        <!-- Exibir nome do posto -->
                        <h2 class="text-lg font-bold text-center">
                            {{ Rank::fromDb($posto)?->label() ?? 'Patente' }}
                        </h2>

                        <!-- Exibir ícone da patente -->
                        <div class="flex justify-center my-2">
                            <img src="{{ Rank::fromDb($posto)?->imageBg() ?? Storage::url('ranks/fundo/default.png') }}"
                                alt="Patente" class="rank-image">
                        </div>
                        <!-- Listar os alunos dentro do posto -->
                        <table>
                            @php $count = 0; @endphp
                            @foreach ($items->where('active', 1) as $item)
                                @if ($item->people_id)
                                    @if ($count % 2 == 0)
                                        <tr>
                                    @endif

                                    <td class="py-2 text-center border-b">
                                        @if ($item->students->code_image)
                                            <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_list.png') }}"
                                                class="student-image">
                                        @else
                                            <img src="{{ Storage::url('ranks/fundo/default.png') }}"
                                                class="student-image">
                                        @endif
                                        <h3 class="font-semibold">
                                            Al. {{ $item->students->nick }}
                                        </h3>
                                        <p>T. {{ $item->students->people_class }}</p>
                                    </td>

                                    @php $count++; @endphp

                                    @if ($count % 2 == 0)
            </tr>
            @endif
            @endif
            @endforeach

            {{-- Fecha a linha se tiver número ímpar de itens --}}
            @if ($count % 2 != 0)
                <td></td>
                </tr>
            @endif
        </table>

        </td>
        @endforeach

        </tr>
        </table>

    </div>
</body>

</html>
