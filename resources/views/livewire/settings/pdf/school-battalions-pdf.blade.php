<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <title>Batalhão</title>
    <style>
        .container {
            margin-top: 30px;
            padding-top: 40px;
            width: 100%;
            font-family: sans-serif;
        }

        .grade-title {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        .container table {
            width: 100%;
            border-collapse: collapse;
        }

        .container td {
            width: 33.33%;
            /* Garante três colunas iguais */
            padding: 1px;
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
            width: 5rem;
            height: auto;
            border-radius: 50%;
            display: block;
            margin: 0 auto 2px;
        }

        .student-item {
            padding-top: 3px;
            padding-bottom: 3px;
            border-bottom: 1px solid #eee;
        }

        .student-image {
            width: 10rem;
            height: auto;
            margin: 0 auto 3px;
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
                        <table class="w-full">
                            @php
                                $filteredItems = $items->where('active', 1)->filter(fn($item) => $item->people_id);
                                $total = $filteredItems->count();
                                $count = 0;
                            @endphp

                            @foreach ($filteredItems as $item)
                                @if ($total === 1)
                                    <tr>
                                        <td colspan="2" class="py-2 text-center border-b">
                                            @if ($item->students)
                                                @if ($item->students->code_image)
                                                    <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_list.png') }}"
                                                        class="student-image">
                                                @else
                                                    <img src="{{ Storage::url('ranks/fundo/default.png') }}"
                                                        class="student-image">
                                                @endif
                                                <h3 class="font-semibold">Al. {{ $item->students->nick }}</h3>
                                                <p>T. {{ $item->students->people_class }}</p>
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    @if ($count % 2 == 0)
                                        <tr>
                                    @endif

                                    <td class="w-1/2 py-2 text-center border-b">
                                        @if ($item->students)
                                            @if ($item->students->code_image)
                                                <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_list.png') }}"
                                                    class="student-image">
                                            @else
                                                <img src="{{ Storage::url('ranks/fundo/default.png') }}"
                                                    class="student-image">
                                            @endif
                                            <h3 class="font-semibold">Al. {{ $item->students->nick }}</h3>
                                            <p>T. {{ $item->students->people_class }}</p>
                                        @endif
                                    </td>

                                    @php $count++; @endphp

                                    @if ($count % 2 == 0)
            </tr>
            @endif
            @endif
            @endforeach

            @if ($total > 1 && $count % 2 != 0)
                <td class="w-1/2"></td>
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
