<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <title>Ficha individual</title>
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
    <div class="container">


        <div class="section">
            <div class="section-title">Dados Individuais</div>
            <table class="dados-container">
                <tr>
                    <td class="col-direita">
                        <img src="{{ $studentImage }}" class="foto">
                    </td>
                    <td class="col-esquerda">
                        <div class="linha-info"><strong>Nome:</strong> João da Silva</div>
                        <div class="linha-info"><strong>Data de Nascimento:</strong> 01/01/2000</div>
                        <div class="linha-info"><strong>RG:</strong> 123456789</div>
                    </td>

                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Formação Acadêmica</div>
            <div class="linha-tabela">Ensino Médio - Colégio Exemplo - Concluído em 2017</div>
            <div class="linha-tabela">Graduação - Engenharia - Universidade X - Concluído em 2022</div>
        </div>

    </div>
</body>

</html>
