<!-- resources/views/admin/controleacesso/pdf.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Controle de Acessos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Relatório de Controle de Acessos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Unidade</th>
                <th>Tipo</th>
                <th>Data de Entrada</th>
                <th>Data de Saída</th>
             
                <th>Motivo</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($controleAcessos as $acesso)
                <tr>
                    <td>{{ $acesso->id }}</td>
                    <td>{{ $acesso->unidade_id }}</td>
                    <td>{{ $acesso->tipo }}</td>
                    <td>{{ $acesso->data_entrada }}</td>
                    <td>{{ $acesso->data_saida }}</td>
                 
                    <td>{{ $acesso->motivo }}</td>
                    <td>{{ $acesso->observacao }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
