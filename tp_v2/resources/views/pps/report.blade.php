<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe PPS</title>
    <style>
        /* Estilos para el PDF */
        body {
            font-family: Arial, sans-serif;
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
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Informe de Solicitudes PPS</h1>
    <p>Docente: {{ $teacher->first_name }} {{ $teacher->last_name }}</p>

    <h2>Solicitudes</h2>
    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Descripción</th>
                <th>Semana</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pps as $pp)
                        <tr>
                            <td>{{ $pp->Student->last_name }}, {{ $pp->Student->first_name }}</td>
                            <td>{{ $pp->description }}</td>
                            <td>
                                @php
                                    $numSemanasCargadas = $pp->weeklyTrackings->whereNotNull('file_path')->count();
                                @endphp

                                @if ($numSemanasCargadas > 0)
                                    {{ $numSemanasCargadas }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pp->start_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pp->finish_date)->format('d/m/Y') }}</td>
                        </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>