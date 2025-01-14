@extends('layouts.app')

@section('content')

<!-- Estilos -->
<link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/icheck/skins/all.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/wizard/steps.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="{{ asset('plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/css/dropify.min.css">
<link href="{{ asset('plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script> --}}
<script src="{{ asset('plugins/switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment-with-locales.js') }}"></script>
<script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/wizard/jquery.steps.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('plugins/dropify/dist/js/dropify.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> --}}

<div class="container mt-4">
    <h2>Detalles del seguimiento</h2>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table no-border">
                <tbody>
                    <tr>
                        <td class="col-4"><b class="font-weight-bold">Semana:</b></td>
                        <td>{{ $wt->id }}</td>
                    </tr>
                    <tr>
                        <td class="col-4"><b class="font-weight-bold">Archivo:</b></td>
                        <td>
                            @if ($wt->file_path != null)
                                <a href="{{ Storage::url($wt->file_path) }}" target="_blank" class="btn btn-success btn-sm">
                                    Ver archivo
                                </a>
                            @else
                                <span class="text-danger">No se ha subido el archivo</span>
                                @if (auth()->user()->role_id == '1')
                                    <br>
                                    <form id="uploadForm" action="{{ route('wt.saveFile', ['id' => $wt->id]) }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="fileInput" class="form-label">Selecciona un archivo</label>
                                            <input type="file" class="form-control" id="fileInput" name="file" accept=".pdf,.doc,.docx" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            Confirmar PDF
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4"><b class="font-weight-bold">Observaciones:</b></td>
                        <td>
                            {{ $wt->observation != null ? $wt->observation : "-" }}
                        </td>
                        <td>
                            @if (auth()->user()->role_id == '2' && $wt->is_accepted == 0)
                                <button class="btn btn-sm waves-effect waves-light" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#modalObservation">
                                                <i class="bi bi-pencil-square"></i> Escribir observación
                                            </button>
                            @endif    
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4"><b class="font-weight-bold">Estado:</b></td>
                        <td>{{ $wt->is_accepted ? 'Aprobado' : 'Pendiente de aprobación' }}</td>
                    </tr>
                </tbody>
            </table>
            @if (auth()->user()->role_id == '2' && $wt->is_accepted == 0)
                @if ($wt->file_path)
                    <form action="{{ route('wt.approve', ['id' => $wt->id]) }}" method="POST" id="form_data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $wt->id }}">
                        <button type="submit" class="btn btn-success btn-sm">Aprobar</button>
                    </form>
                @else
                    <div class="alert alert-warning" role="alert">
                        No se ha subido el seguimiento semanal en PDF.
                    </div>
                @endif
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('getWeeklyTrackings', ['id' => $pps->id]) }}" class="btn btn-link">Volver</a>
</div>

<!-- Modal para agregar observaciones -->
@if (auth()->user()->role_id == '2')
<div class="modal fade" id="modalObservation" tabindex="-1" aria-labelledby="modalObservationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('wt.editObservation', $wt->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <br>
                    <h5 class="modal-title" id="modalObservationLabel">Agregar Observación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <textarea name="observation" class="form-control" rows="4" placeholder="Escribe tu observación aquí"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>

$(document).ready(function () {
        moment.locale('es');

        let drEvent = $('.dropify').dropify({
            messages: {
                'default': 'Arrastre el archivo aquí o haga clic',
                'replace': 'Arrastre el archivo aquí o haga clic para reemplazar',
                'remove': 'Eliminar',
                'error': 'Ops, ocurrió un error.'
            },
            error: {
                'fileSize': 'El tamaño del archivo es demasiado grande. Máximo 2MB.',
            }
        });

        drEvent.on('dropify.errors', function (event, element) {
            console.log('Has Errors');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const confirmButtonContainer = document.getElementById('confirmButtonContainer');

        // Detectar cuando se selecciona un archivo
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                confirmButtonContainer.style.display = 'block';
            } else {
                confirmButtonContainer.style.display = 'none';
            }
        });
    });

    function sendFile(id) {
    let form = $("#form_data");
    let formData = new FormData();
    let file = $("input[name='file']")[0].files[0];

    $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    title: response.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#1e88e5',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = window.location.origin;
                    }
                });
            },
            error: function (errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: errorThrown.responseJSON.title,
                    text: errorThrown.responseJSON.message,
                    confirmButtonColor: '#1e88e5',
                });
            }
        });
}


</script>

@endsection
