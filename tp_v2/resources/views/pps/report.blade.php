<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de PPS</title>
    <style>
        /* Agrega estilos aquí para que el PDF tenga un buen formato */
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Informe de PPS del Profesor {{ $teacher->first_name }}</h1>
    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Descripción</th>
                <th>Fecha de Fin</th>
                <th>Aprobada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pps as $app)
                <tr>
                    <td>{{ $app->Student->last_name }}, {{ $app->Student->first_name }}</td>
                    <td>{{ $app->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($app->finish_date)->format('d/m/Y') }}</td>
                    <td>{{ $app->FinalReport && $app->FinalReport->is_accepted ? 'Sí' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>