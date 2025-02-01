@php
    $contador = 1;
@endphp
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

    <div class="mb-4 card">
        <div class="card-body">
            <table class="table no-border">
                <tbody>
                    <tr>
                        <td class="col-4"><b class="font-weight-bold">Archivo:</b></td>
                        <td>
                            @if ($wt->file_path != null)
                                <a href="{{ Storage::url($wt->file_path) }}" target="_blank" class="btn btn-success btn-sm">
                                    Ver archivo
                                </a>
                            @else
                                <span class="text-danger">No se ha subido el archivo</span>
                            @endif
                            @if (auth()->user()->role_id == '1' && $wt->is_editable == 1)
                                    <br>
                                    <form id="uploadForm" action="{{ route('wt.saveFile', ['id' => $wt->id]) }}" method="POST" enctype="multipart/form-data" class="border rounded shadow-sm p-4">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="fileInput" class="form-label">Selecciona un archivo</label>
                                            <input type="file" class="form-control" id="fileInput" name="file" accept=".pdf" required>
                                        </div>
                                        <button id="btnConfirmar" type="submit" class="btn btn-primary">
                                            Confirmar PDF
                                        </button>
                                    </form>
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="col-4"><b class="font-weight-bold">Observaciones:</b></td>
                        <td>
                            {{ $wt->observation != null ? $wt->observation : "-" }}
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
            @if (auth()->user()->role_id == '2' && $wt->is_accepted == false)
                @if ($wt->file_path && $wt->is_editable == false)
                    <button id="btnAprobar" class="btn btn-success waves-effect waves-light" data-id="{{$wt->id}}">Aprobar</button>
                    <button id="btnRechazar" class="btn btn-danger waves-effect waves-light" data-id="{{$wt->id}}">Rechazar</button>
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

    <div>
        <a href="{{ route('getWeeklyTrackings', ['id' => $pps->id]) }}" class="btn btn-link">Volver</a>
    </div>
    <div id="loadingSpinner" class="d-none">
        <div class="text-primary spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>
</div>

<!-- Modal para agregar observaciones -->
@if (auth()->user()->role_id == '2')
<div class="modal fade" id="modalObservation" tabindex="-1" aria-labelledby="modalObservationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="observationForm" action="{{ route('wt.editObservation', $wt->id) }}" method="POST">
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
    $(document).ready(function () {
        $("#btnConfirmar").prop('disabled', true);
        $("#fileInput").change(function () {
            if ($(this).val() != '') {
                $("#btnConfirmar").prop('disabled', false);
            } else {
                $("#btnConfirmar").prop('disabled', true);
            }
        });
    });


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
            $("#loadingSpinner").removeClass('d-none');
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

    $(document).on("click", "#btnAprobar", function () {
        event.preventDefault();
        const id = $(this).data('id');

        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Desea aprobar el seguimiento semanal?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, aprobar'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#loadingSpinner").removeClass('d-none');

                $.ajax({
                    url: `{{ route('wt.approve', ':id') }}`.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message || 'El seguimiento ha sido aprobado correctamente.',
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: xhr.responseJSON?.title || 'Error!',
                            text: xhr.responseJSON?.message || 'Hubo un problema al aprobar el seguimiento.',
                        });
                    },
                    complete: function () {
                        $("#loadingSpinner").addClass('d-none');
                    }
                });
            }
        });
    });

    $(document).on("click", "#btnRechazar", function () {
    event.stopPropagation();  

    const id = $(this).data('id');

    
    $.ajax({
        url: `{{ route('wt.getObservation', ':id') }}`.replace(':id', id),  
        method: 'GET',
        success: function (response) {
            const observation = response.observation || ""; 


            $("textarea[name='observation']").val(observation);  

            Swal.fire({
                title: '¿Está seguro?',
                text: '¿Desea rechazar el seguimiento semanal?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, rechazar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const updatedObservation = $("textarea[name='observation']").val().trim(); 

                    if (!updatedObservation) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Debes ingresar una observación antes de rechazar.',
                        });
                        return;  
                    }

                    $("#loadingSpinner").removeClass('d-none');  

                    
                    $.ajax({
                        url: `{{ route('wt.reject', ':id') }}`.replace(':id', id),
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            observation: updatedObservation, 
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message || 'El seguimiento ha sido rechazado correctamente.',
                            }).then(() => {
                                location.reload();  
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: xhr.responseJSON?.title || 'Error!',
                                text: xhr.responseJSON?.message || 'Hubo un problema al rechazar el seguimiento.',
                            });
                        },
                        complete: function () {
                            $("#loadingSpinner").addClass('d-none');  
                        }
                    });
                }
            });
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error al cargar la observación',
                text: 'No se pudo cargar la observación desde la base de datos.',
            });
        }
    });
});

</script>

@endsection
