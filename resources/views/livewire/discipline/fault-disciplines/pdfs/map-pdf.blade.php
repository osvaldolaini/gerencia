<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Relatório de Punições</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Relatório de Punições</h2>
    <p>Período: {{ $date_start }} a {{ $date_end }}</p>

    <table>
        <thead>
            <tr>
                <th>Série</th>
                <th>Decisão</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($punitions as $item)
                <tr>
                    <td>{{ $item->grade }}</td>
                    <td>{{ $item->decision }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
