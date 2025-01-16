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

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-body">
                        <h2 class="box-title">Reporte final</h2>
                        @if (auth()->user()->role_id == '3' && !$existsFR)
                            <div class="mb-3">
                                <form id="generate-wt-form" action="{{ route('fr.generate', $pps->id) }}" method="POST">
                                    @csrf
                                    <button id="btnGeneratewts" class="btn btn-primary">
                                        Generar reporte final
                                    </button>
                                </form>
                            </div>
                        @endif
                        @if (!$existsFR)
                            <div class="alert alert-warning" role="alert">
                                El reporte final aún no han sido generado. Por favor, espera a que el responsable lo cree.
                            </div>
                        @else
                            <p class="box-subtitle">{{ $fr->created_at->format('d/m/Y') }}</p>
                            <hr class="m-t-0 m-b-20">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Reporte final del estudiante:</b></td>
                                        <td>
                                            @if ($fr->file_path != null)
                                                <a href="{{ Storage::url($fr->file_path) }}" target="_blank" class="btn btn-success btn-sm">
                                                    Ver archivo
                                                </a>
                                            @else
                                                <span class="text-danger">No se ha subido el archivo</span>
                                                @if (auth()->user()->role_id == '1')
                                                    <br>
                                                    <form id="uploadForm" action="{{ route('fr.saveFile', ['id' => $fr->id]) }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="fileInput" class="form-label">Selecciona un archivo</label>
                                                            <input type="file" class="form-control" id="fileInput" name="file" accept=".pdf,.doc,.docx" required>
                                                        </div>
                                                        <button id="btnConfirmar" type="submit" class="btn btn-primary">
                                                            Confirmar PDF
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-4">
                                            <b class="font-weight-bold">Observaciones:</b>
                                        </td>
                                        <td>{{ $fr->observation != null ? $fr->observation : "-" }}
                                            @if (auth()->user()->role_id == '2' && $fr->is_accepted === 0)
                                                <button class="btn btn-sm waves-effect waves-light" type="button"
                                                        data-bs-toggle="modal" data-bs-target="#modalObservation">
                                                    <i class="bi bi-pencil-square"></i> Escribir observación
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Estado:</b></td>
                                        <td>{{ $fr->is_accepted ? 'Aprobado' : 'Pendiente de aprobación' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <hr class="m-t-0 m-b-20"> --}}
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (auth()->user()->role_id == '2' && $fr->is_accepted === 0)
                                @if ($fr->file_path)
                                    <div class="d-flex justify-content-end">
                                        <form id="form-approve" action="{{ route('fr.approve', ['id' => $fr->id]) }}" method="post">
                                            @csrf
                                            <button id="btnAprobar" class="btn btn-success waves-effect waves-light"
                                                type="button">Aprobar solicitud</button>
                                        </form>
                                        {{-- Boton de rechazo: envia un mail para que cambie la desc o fechas? se tendria que justamente comentar en observaciones asi se envia eso x mail --}}
                                        <button class="btn btn-sm btn-danger">Rechazar</button>
                                        <hr class="m-t-0 m-b-20">
                                    </div>
                                @else
                                    <div class="alert alert-warning" role="alert">
                                        No se ha subido el reporte final en PDF.
                                    </div>
                                @endif
                            @endif
                            </div>
                            <div>
                                <button id="btnSeguimiento" class="btn btn-secondary" disabled>Ir a resumen</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar observaciones -->
@if (auth()->user()->role_id == '2')
<div class="modal fade" id="modalObservation" tabindex="-1" aria-labelledby="modalObservationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="observationForm" action="{{ route('fr.editObservation', $fr->id) }}" method="POST">
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
                    <button id="btnSaveObservation" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
    $("#btnConfirmar").on("click", function () {
        event.preventDefault();
            Swal.fire({
                title: 'Esta acción no se puede revertir',
                text: '¿Estás seguro de subir este archivo?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#uploadForm").submit();
                }
            });
    });

    $("#btnSaveObservation").on("click", function (e) {
    e.preventDefault();
    let form = $("#observationForm");
    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: form.serialize(),
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Observación guardada con éxito',
                confirmButtonColor: '#1e88e5',
            }).then(() => {
                location.reload();
            });
        },
        error: function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo guardar la observación.',
            });
        },
    });
    });

    $("#btnAprobar").on("click", function () {
        event.preventDefault();
            Swal.fire({
                title: 'Esta acción no se puede revertir',
                text: '¿Seguro deseas aprobar esta solicitud?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info waves-effect waves-light px-3 py-2',
                    cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#form-approve").submit();
                }
            });
        });

    if ("{{ $fr->is_accepted }}" == 1) {
        $("#btnSeguimiento").prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');
    } else {
        $("#btnSeguimiento").prop('disabled', true).removeClass('btn-success').addClass('btn-secondary');
    }

    $("#btnSeguimiento").on("click", function () {
        window.location.href = "{{ route('resume', ['id' => $pps->id]) }}";
    });
</script>

@endsection