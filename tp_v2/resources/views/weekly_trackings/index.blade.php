@extends('layouts.app')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>

<div class="container-fluid">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Seguimientos semanales</h3>
        @if (auth()->user()->role_id == '3' && !$wts)
        <div class="mb-3">
            <form id="generate-wt-form" action="{{ route('wt.generate', $pps->id) }}" method="POST">
                @csrf
                <button id="btnGeneratewts" class="btn btn-primary">
                    Generar Seguimientos Semanales
                </button>
            </form>
        </div>
        @endif
    </div>
    @if (!$wts)
        <div class="alert alert-warning" role="alert">
            Los seguimientos semanales aún no han sido generados. Por favor, espera a que el responsable los cree.
        </div>
    @else
        <table id="DataTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Semana</th>
                    <th>Archivo</th>
                    <th>Observaciones</th>
                    <th>Aprobado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pps->WeeklyTrackings as $wt)
                    {{-- CAMBIAR URL --}}
                    <tr data-id="{{ $wt->id }}" class="clickable" data-url="/weeklyTracking"> 
                        <td>{{ $wt->id }}</td>
                        <td>
                            @if ($wt->file_path == null)
                                <span class="text-danger">No se ha subido el archivo</span>
                            @else
                                <a href="{{ Storage::url($wt->file_path) }}" target="_blank" class="btn btn-success btn-sm">
                                    Ver archivo
                                </a>
                            @endif
                        </td>
                        <td>{{ $wt->observation != null ? $wt->observation : "-" }}
                            @if (auth()->user()->role_id == '2' && $pps->is_finished === 1 && $pps->is_approved === 0)
                                    <button class="btn btn-sm waves-effect waves-light" type="button"
                                        data-bs-toggle="modal" data-bs-target="#modalObservation">
                                    <i class="bi bi-pencil-square"></i> Escribir observación
                                </button>
                            @endif
                        </td>
                        <td>
                            @if ($wt->is_accepted == 1)
                                <i class="bi bi-check2" style="font-size: 1.5rem"></i>
                            @else
                                <i class="bi bi-x-lg" style="font-size: 1.3rem"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
        <div>
            <hr class="m-t-0 m-b-20">
            <button id="btnSeguimiento" class="btn btn-secondary" disabled>Ir a Acta de Finalización</button>
            <br>
            <hr class="m-t-0 m-b-20">
        </div>
    @endif

<script>

    $(document).ready(function () {
        $('#DataTable').DataTable({
            paging: false,
            searching: false,
            info: false
        });
    });

    $(document).on("click", ".clickable", function (event) {
        if (!$(event.target).closest('.btn').length) {
        let url = $(this).data('url');
        let id = $(this).data('id');
        window.location.href = url + "/" + id;
        }
    });

</script>    

<style>
    .clickable {
        cursor: pointer;
    }

    .clickable:hover {
        background-color: #7abcfd8c;
    }

</style>
@endsection