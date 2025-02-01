@extends('layouts.app')
@section('content')

<div class="card mb-4">
    <div class="card-header">
        <h4>Detalles de PPS</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Docente/a</th>
                    <th>Responsable</th>
                    <th>Fecha de creación</th>
                    <th>Archivo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $pps->id }}</td>
                    <td>{{ $pps->Student->first_name }} {{ $pps->Student->last_name }}</td>
                    <td>{{ $pps->Teacher->first_name }} {{ $pps->Teacher->last_name }}</td>
                    <td>{{ $pps->Responsible->first_name }} {{ $pps->Responsible->last_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($pps->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('wp.download', $pps->id) }}" class="btn btn-success btn-sm">Descargar</a>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h4>Detalles del Reporte Final</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha de creación</th>
                    <th>Archivo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($pps->FinalReport->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('fr.download', $pps->id) }}" class="btn btn-success btn-sm">Descargar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection