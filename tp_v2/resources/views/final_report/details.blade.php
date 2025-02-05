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
                            <p class="box-subtitle">{{ $fr->created_at->format('d/m/Y') }}</p>
                            <hr class="m-t-0 m-b-20">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Reporte final del estudiante:</b>
                                        </td>
                                        <td>
                                            @if ($fr->file_path != null && $fr->is_editable == false)
                                                <a href="{{ url('/finalReport/downloadFinalReport/' . $fr->id) }}"
                                                    class="btn btn-success btn-sm">
                                                    Ver archivo
                                                </a>
                                            @else
                                                <span class="text-danger">No se ha subido el archivo</span>
                                            @endif
                                            @if (auth()->user()->role_id == '1' && $fr->is_editable == true)
                                                <br>
                                                <form id="uploadForm"
                                                    action="{{ route('fr.saveFile', ['id' => $fr->id]) }}" method="POST"
                                                    enctype="multipart/form-data" class="border rounded shadow-sm p-4">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="fileInput" class="form-label">Selecciona un
                                                            archivo</label>
                                                        <input type="file" class="form-control" id="fileInput"
                                                            name="file" accept=".pdf" data-max-file-size="2M" required>
                                                    </div>
                                                    <button id="btnConfirmar" type="submit" class="btn btn-primary">
                                                        Confirmar PDF
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-4">
                                            <b class="font-weight-bold">Observaciones:</b>
                                        </td>
                                        <td>{{ $fr->observation != null ? $fr->observation : '-' }}
                                            @if (auth()->user()->role_id == '2' && $fr->is_accepted === 0 && $fr->is_editable == false)
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
                            @if (auth()->user()->role_id == '2' && $fr->is_accepted === 0)
                                @if ($fr->file_path && $fr->is_editable == false)
                                    <div class="d-flex justify-content-end">
                                        <button id="btnAprobar" class="mb-2 btn btn-success waves-effect waves-light me-2"
                                            data-id="{{ $fr->id }}">Aprobar solicitud</button>
                                        <button id="btnRechazar" class="mb-2 btn btn-danger waves-effect waves-light me-2"
                                            data-id="{{ $fr->id }}">Rechazar solicitud</button>
                                        <hr class="m-t-0 m-b-20">
                                    </div>
                                @else
                                    <div class="alert alert-warning" role="alert">
                                        No se ha subido el reporte final en PDF.
                                    </div>
                                @endif
                            @endif
                        </div>
                        @if (isset($fr) && $fr->is_accepted)
                            <button id="btnResumen" class="btn btn-success">Ir a resumen</button>
                        @endif
                        @if (isset($fr) && $fr->is_accepted && !$fr->is_checked && auth()->user()->role_id == '3')
                            <hr class="m-t-0 m-b-20">
                            <button id="btnChecked" class="btn btn-success waves-effect waves-light"
                                data-id="{{ $pps->id }}">Finalizar PPS</button>
                        @endif
                    </div>

                    <!-- Modal para agregar observaciones -->
                    @if (auth()->user()->role_id == '2')
                        <!-- Modal para agregar observaciones -->
                        <div class="modal fade" id="modalObservation" tabindex="-1" aria-labelledby="modalObservationLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalObservationLabel">Escriba Observaciones</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="observationForm" method="post"
                                            action="{{ route('fr.editObservation', $fr->id) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="observationInput" class="form-label">Observación</label>
                                                <textarea class="form-control" id="observationInput" name="observation" rows="3" required>{{ old('observation', $fr->observation) }}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div id="loadingSpinner" class="d-none">
                    <div class="text-primary spinner-border" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#btnConfirmar").prop('disabled', true);
            $("#fileInput").change(function() {
                if ($(this).val() != '') {
                    $("#btnConfirmar").prop('disabled', false);
                } else {
                    $("#btnConfirmar").prop('disabled', true);
                }
            });
        });

        $("#btnConfirmar").on("click", function() {
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

        $("#btnSaveObservation").on("click", function(e) {
            e.preventDefault();
            let form = $("#observationForm");
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Observación guardada con éxito',
                        confirmButtonColor: '#1e88e5',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo guardar la observación.',
                    });
                },
            });
        });

        $(document).on("click", "#btnAprobar", function() {
            event.stopPropagation();
            const id = $(this).data('id');

            Swal.fire({
                title: '¿Está seguro?',
                text: `¿Desea aprobar el reporte final?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, aprobar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loadingSpinner").removeClass('d-none');

                    $.ajax({
                        url: `{{ route('fr.approve', ':id') }}`.replace(':id', id),
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message ||
                                    'El reporte final ha sido aprobado correctamente.',
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: xhr.responseJSON?.title || 'Error!',
                                text: xhr.responseJSON?.message ||
                                    'Hubo un problema al aprobar el reporte.',
                            });
                        },
                        complete: function() {
                            $("#loadingSpinner").addClass('d-none');
                        }
                    });
                }
            });
        });

        $(document).on("click", "#btnRechazar", function() {
            event.stopPropagation();

            const id = $(this).data('id');


            $.ajax({
                url: `{{ route('fr.getObservation', ':id') }}`.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    const observation = response.observation || "";


                    $("textarea[name='observation']").val(observation);

                    Swal.fire({
                        title: '¿Está seguro?',
                        text: '¿Desea rechazar el reporte final?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, rechazar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const updatedObservation = $("textarea[name='observation']").val()
                                .trim();

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
                                url: `{{ route('fr.reject', ':id') }}`.replace(':id',
                                    id),
                                method: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    observation: updatedObservation,
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Éxito!',
                                        text: response.message ||
                                            'El reporte final ha sido rechazado correctamente.',
                                    }).then(() => {
                                        location.reload();
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: xhr.responseJSON?.title ||
                                            'Error!',
                                        text: xhr.responseJSON?.message ||
                                            'Hubo un problema al rechazar el reporte final.',
                                    });
                                },
                                complete: function() {
                                    $("#loadingSpinner").addClass('d-none');
                                }
                            });
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al cargar la observación',
                        text: 'No se pudo cargar la observación desde la base de datos.',
                    });
                }
            });
        });

        $("#btnResumen").on("click", function() {
            window.location.href = "{{ route('resume', ['id' => $pps->id]) }}";
        });

        $(document).on("click", "#btnChecked", function() {
            event.stopPropagation();
            const id = $(this).data('id');

            Swal.fire({
                title: '¿Está seguro?',
                text: `¿Desea finalizar la PPS?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, finalizar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loadingSpinner").removeClass('d-none');

                    $.ajax({
                        url: `{{ route('fr.finish', ':id') }}`.replace(':id', id),
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message ||
                                    'El proceso de PPS ha sido cerrado correctamente.',
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: xhr.responseJSON?.title || 'Error!',
                                text: xhr.responseJSON?.message ||
                                    'Hubo un problema al cerrar el proceoso de PPS.',
                            });
                        },
                        complete: function() {
                            $("#loadingSpinner").addClass('d-none');
                        }
                    });
                }
            });
        });
    </script>

@endsection
