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

    <div class="section">
        <div class="section-title">ALUNOS DA ATIVIDADE {{ $data->title }}</div>
        @if ($data->students->count() > 0)
            <table class="w-full" style="border-collapse: collapse;">
                <tr>
                    <th class="text-center">Nr</th>
                    <th class="text-center">Aluno</th>
                    <th class="text-center">GIP</th>
                    <th class="text-center">Bônus</th>
                </tr>
                @foreach ($data->students->where('active', 1)->sortBy('gip') as $student)
                    <tr class="linha-tabela">
                        <td class="text-center border-bottom">
                            {{ $student->student->number }}
                        </td>
                        <td class="text-center border-bottom">

                        </td>

                        <td class="text-center border-bottom">

                        </td>
                        <td class="text-center border-bottom">

                        </td>
                @endforeach



            </table>
        @else
            <div class="linha-tabela">Nenhum aluno cadastrado</div>
        @endif
    </div>
</body>

</html>
