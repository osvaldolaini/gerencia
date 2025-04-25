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

        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
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
            border-bottom: 1px solid #ccc;
            padding: 6px 0;
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
