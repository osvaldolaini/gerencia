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
            border: 1px solid #ddd;
            border-radius: 8px;
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
            width: 3rem;
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

        /* Estilos para mPDF */
        @media print {
            .container {
                width: 100%;
                font-family: sans-serif;
                margin-top: 40px;
            }

            .grade-title {
                display: block;
                width: 100%;
                text-align: center;
                font-size: 50px !important;
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
                padding: 16px;
                border: 1px solid #ddd;
                border-radius: 8px;
                text-align: center;
                vertical-align: top;
            }

            .posto-container h2 {
                font-size: 18px !important;
                font-weight: bold;
                margin-bottom: 10px;
                width: 100%;
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
                width: 3rem;
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
        }
    </style>
</head>

<body>
    @php
        use App\Enums\Rank;
    @endphp
    <div class="container">
        @forelse ($companies->where('active',1)->sortByDesc('nick') as $company)
            @forelse ($company->grade->where('active',1)->sortByDesc('nick') as $grade)
                @if ($grade->battalion->where('active', 1)->sortBy('order')->groupBy('posto_grad')->count() > 0)
                    <small class="grade-title ">
                        {{ $grade->name }}
                    </small>
                @endif

                <table>
                    <tr>
                        @php
                            $postos = $grade->battalion->where('active', 1)->sortBy('order')->groupBy('posto_grad');
                            $colunas = $postos->chunk(ceil($postos->count() / 3)); // Divide em 3 colunas
                        @endphp

                        @foreach ($colunas as $coluna)
                            <td>
                                @foreach ($coluna as $posto => $items)
                                    <div class="posto-container">
                                        <h2 width="100%">
                                            {{ Rank::fromDb($posto)?->label() ?? 'Patente' }}
                                        </h2>
                                        <p width="100%">
                                            <img src="{{ Rank::fromDb($posto)?->imageBg() ?? Storage::url('ranks/fundo/default.png') }}"
                                                alt="Patente" class="rank-image">

                                        </p>

                                        @foreach ($items as $item)
                                            <div class="student-item">
                                                <img src="{{ url('storage/student/' . $item->students->id . '/' . $item->students->code_image . '_list.png') }}"
                                                    class="student-image">
                                                <h3>
                                                    Al. {{ $item->students->nick }}
                                                </h3>
                                                <p>T. {{ $item->students->people_class }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                </table>
            @empty
                <p>Nenhuma ano cadastrado</p>
            @endforelse
        @empty
            <p>Nenhuma companhia cadastrada</p>
        @endforelse
    </div>
</body>

</html>
