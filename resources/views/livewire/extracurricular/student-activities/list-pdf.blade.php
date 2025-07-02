<!DOCTYPE html>
<html lang="pt-BR">
@php
    use App\Enums\Penalty;

    // Garante que $data seja iterável mesmo que seja null
    $data = $data ?? collect();
@endphp

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        .container {
            margin-top: 50px;
            padding-top: 50px;
        }

        .class {
            width: 100%;
            font-size: 12pt;
        }

        .turmas-table {
            width: 100%;
            font-size: 12pt;
            border-collapse: collapse;
        }

        .border {
            border: solid thin #000;
        }

        .w-20 {
            min-width: 20%;
        }

        .w-10 {
            min-width: 10%;
        }

        .header {
            font-size: 20px;
        }

        .turma-wrapper {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
    <x-app.favicons></x-app.favicons>
</head>

<body>
    <div class="container">
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
