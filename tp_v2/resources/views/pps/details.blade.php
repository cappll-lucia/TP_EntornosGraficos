@php
    use Carbon\Carbon;
    $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));
    $pps_end_date = Carbon::parse($pps->finish_date);
@endphp
@extends('layouts.app')

@section('content')

<!-- Styles -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/popper/popper.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/colors/default-dark.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/waves.js') }}"></script>
<link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/icheck/skins/all.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/wizard/steps.css') }}" rel="stylesheet" />
<!-- Switchery -->
<link href="{{ asset('plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
<!-- Datepicker -->
<link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}"
    rel="stylesheet">

<link href="{{ asset('plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">

<!-- Switchery -->
<script src="{{ asset('plugins/switchery/dist/switchery.min.js') }}"></script>
<!-- Datepicker -->
<script src="{{ asset('plugins/moment/moment-with-locales.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<!-- Editable -->
<script src="{{ asset('plugins/jquery-datatables-editable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>
<!-- icheck -->
<script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/icheck/icheck.init.js') }}"></script>
<!-- Steps -->
<script src="{{ asset('plugins/wizard/jquery.steps.min.js') }}"></script>

<!-- Make the form -->
@livewireStyles

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Solicitudes</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/pps/index') }}">Solicitudes</a></li>
                <li class="breadcrumb-item active">Detalles</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->

    <!-- Modal -->
    <div id="modalObservation" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form role="form" class="needs-validation" method="POST" action="{{ url('/pps/editObservation') }}"
                id="form-observation" autocomplete="off" novalidate>
                @csrf
                <input type="hidden" name="pps_id" value="{{ $pps->id }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar observaciones</h4>
                        <button type="button" class="close" id="btnCloseModal" data-dismiss="modal"
                            aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-column">
                                    <div class="col-12 mb-3">
                                        <textarea class="form-control" name="observation" style="height: 300px"
                                            required>{{ $pps->observation }}</textarea>
                                        <div class="invalid-feedback">
                                            Por favor, ingrese una observación
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                        <button id="btnSendObservation" type="button"
                            class="btn btn-success waves-effect waves-light">Editar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Modal -->

<div class="container">
    <!-- Primera parte del formulario -->
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-body">
                        <h2 class="box-title">Detalles de la solicitud #{{ $pps->id }}</h2>
                        <p class="box-subtitle">{{ $pps->created_at->format('d/m/Y') }}</p>
                        <hr class="m-t-0 m-b-20">
                        {{-- Table con 4 columnas que contenga los datos de la pps --}}
                        <table class="table no-border">
                            <tbody>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Estudiante:</b></td>
                                    <td>{{ $pps->Student->last_name }}, {{ $pps->Student->first_name }} -
                                        Legajo: {{ $pps->Student->legajo }}</td>
                                </tr>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Responsable:</b></td>
                                    @if ($pps->responsible_id != null)
                                        <td>{{ $pps->Responsible->last_name }},
                                            {{ $pps->Responsible->first_name }}</td>
                                    @else
                                        <td>Sin asignar</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Profesor a cargo:</b></td>
                                    @if ($pps->teacher_id != null)
                                        <td>{{ $pps->Teacher->last_name }},
                                            {{ $pps->Teacher->first_name }}</td>
                                    @else
                                        <td>Sin asignar</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Fecha de inicio/fin:</b></td>
                                    <td>{{ \Carbon\Carbon::parse($pps->start_date)->format('d/m/Y') }} -
                                        {{ \Carbon\Carbon::parse($pps->finish_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Descripción:</b></td>
                                    <td>{{ $pps->description }}</td>
                                </tr>
                                <tr>
                                    <td class="col-4">
                                        <b class="font-weight-bold">Observaciones:</b>
                                        @if (auth()->user()->role_id == 2)
                                            <button class="btn btn-sm waves-effect waves-light" type="button"
                                                data-toggle="modal" data-target="#modalObservation"><i
                                                    class="bi bi-pencil-square"></i></button>
                                        @endif
                                    </td>
                                    <td>{{ $pps->observation != null ? $pps->observation : "-" }}</td>
                                </tr>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Estado:</b></td>
                                    @if ($pps->is_approved == true)
                                        @if ($pps->is_finished == true)
                                            <td><span class="label label-success">Finalizada</span> - <span
                                                    class="label label-success">Aprobada</span></td>
                                        @else
                                            <td><span class="label label-warning">Sin finalizar</span> - <span
                                                    class="label label-success">Aprobada</span></td>
                                        @endif
                                    @else
                                        @if ($pps->is_finished == true)
                                            <td><span class="label label-success">Finalizada</span> - <span
                                                    class="label label-danger">Pendiente de aprobación</span></td>
                                        @else
                                            <td><span class="label label-warning">Sin finalizar</span> - <span
                                                    class="label label-danger">Pendiente de aprobación</span></td>
                                        @endif
                                    @endif
                                    <td>{{ $pps->status }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr class="m-t-0 m-b-20">
                        @if (auth()->user()->role_id == '3' && $pps->id_responsible != null)
                            <td>
                                <button class="btn btn-sm btn-success take-btn" data-id="{{$pps->id}}" data-student="{{ $pps->Student->first_name }} {{ $pps->Student->last_name }}">Tomar</button>
                                <button class="btn btn-sm btn-danger">Rechazar</button>
                            </td>
                        @endif
                        @if (auth()->user()->role_id == 2 && $pps->is_finished === true && $pps->is_approved === false)
                            <hr>
                            <div class="d-flex justify-content-end">
                                <form id="form-approve" action="/pps/approve/{{ $pps->id }}" method="post">
                                    @csrf
                                    <button id="btnFinish" class="btn btn-success waves-effect waves-light"
                                        type="button">Aprobar solicitud</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Second part of the form (only if it is approved) -->
        @if ($approved)
            <div>
                <input type="text" name="input2" value="Quiero ver si funciona">
                <!-- Aca va lo de los planes semanales -->
            </div>
        @endif
</div>
        @if (auth()->user()->role_id == 4)
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title"
                                    style="@if ($today >= $pps_end_date) text-decoration: line-through; @endif">
                                    Subir seguimiento semanal</h2>
                                <form id="form-uploadWT" action="/pps/uploadWeeklyTracking" method="post">
                                    @csrf
                                    <input name="file" type="file" class="dropify" accept=".pdf" data-max-file-size="2M" @if ($today >= $pps_end_date) disabled @endif />
                                    <input type="hidden" name="pps_id" value="{{ $pps->id }}">
                                    <div class="d-flex justify-content-end mt-2">
                                        <button id="btn-uploadWT" onclick="uploadWT()"
                                            class="btn btn-secondary waves-effect waves-light" type="button"
                                            style="display: none;"><span class="btn-label"><i
                                                    class="bi bi-upload"></i></span>Subir</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@livewireScripts
<script src="//unpkg.com/alpinejs" defer></script>

<style>
    .dataTables_scrollHeadInner {
        width: 100% !important;
    }

    .dataTables_scrollHeadInner table {
        width: 100% !important;
    }
</style>

<script>
    $(document).ready(function () {
        let drEvent = $('.dropify').dropify({
            messages: {
                'default': 'Arrastre el archivo aquí o haga clic',
                'replace': 'Arrastre el archivo aquí o haga clic para reemplazar',
                'remove': 'Eliminar',
                'error': 'Ooops, ocurrió un error.'
            },
            error: {
                'fileSize': 'El tamaño del archivo es demasiado grande. Máximo 2MB.',
            }
        });

        drEvent.on('dropify.afterClear', function (event, element) {
            $('#btn-uploadWT').hide();
            $('#btn-uploadFR').hide();
        });
        drEvent.on('dropify.errors', function (event, element) {
            $('#btn-uploadWT').hide();
            $('#btn-uploadFR').hide();
        });
    });

    const SwalError = (title, text = "") => {
        Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonColor: '#1e88e5',
        });
    };
</script>

<script>
    $('#form-uploadFR input[type="file"]').change(function () {
        if ($(this).get(0).files.length > 0) {
            $('#btn-uploadFR').show();
        } else {
            $('#btn-uploadFR').hide();
        }
    });
    $('#form-uploadWT input[type="file"]').change(function () {
        if ($(this).get(0).files.length > 0) {
            $('#btn-uploadWT').show();
        } else {
            $('#btn-uploadWT').hide();
        }
    });

    $('input').on('ifClicked', function (ev) {
        $("#btnTeacher").show();
    });

    $("#btnFinish").on("click", function () {
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
                let form = $("#form-approve");
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: $(form).serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            confirmButtonColor: '#1e88e5',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (errorThrown) {
                        SwalError(errorThrown.responseJSON.title, errorThrown.responseJSON.message);
                    }
                });
            }
        });
    });

    $("#btnDeleteTeacher").on("click", function () {
        let professor_name = $(this).data('name');
        Swal.fire({
            text: `¿Seguro deseas eliminar a ${professor_name} de esta PPS?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-danger waves-effect waves-light px-3 py-2',
                cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let form = $("#form-deleteTeacher");
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: $(form).serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            confirmButtonColor: '#1e88e5',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (errorThrown) {
                        SwalError(errorThrown.responseJSON.message);
                    }
                });
            }
        });
    });

    $("#btnTeacher").on("click", function () {
        let professor_name = $(`#form-teacher input[name='teacher_id']:checked`).parent().parent().parent().find('td:nth-child(1)').text();
        Swal.fire({
            text: `¿Seguro deseas asignar a ${professor_name} a esta PPS?`,
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
                let form = $("#form-teacher");
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: $(form).serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            confirmButtonColor: '#1e88e5',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (errorThrown) {
                        SwalError(errorThrown.responseJSON.message);
                    }
                });
            }
        });
    });

    $("#btnSendObservation").on("click", function () {
        let form = $("#form-observation");
        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: $(form).serialize(),
            success: function (response) {
                $("#btnCloseModal").click();
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    confirmButtonColor: '#1e88e5',
                    allowOutsideClick: false,
                });
            },
            error: function (errorThrown) {
                SwalError(errorThrown.responseJSON.message);
            }
        });
    });

    
    $(document).on("click", ".take-btn", function () {
        event.stopPropagation();
        const id = $(this).data('id');
        const studentName = $(this).data('student');
        
        Swal.fire({
            title: '¿Está seguro?',
            text: `¿Desea tomar la pps de ${studentName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, tomar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('pps.tomar', ':id') }}`.replace(':id', id),
                    method: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}", // Agrega el token CSRF para seguridad
                    },
                    success: function(response) {
                        Swal.fire(
                            'Tomado!',
                            'La solicitud ha sido actualizada.',
                            'success'
                        );
                        location.reload(); // Recarga la página para actualizar la tabla
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al actualizar la solicitud.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    function uploadWT() {
        let form = $("#form-uploadWT");
        let formData = new FormData();
        let file = $("#form-uploadWT input[name='file']")[0].files[0];
        formData.append('pps_id', $("#form-uploadWT input[name='pps_id']").val());
        formData.append('_token', $("#form-uploadWT input[name='_token']").val());
        formData.append('file', file);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    confirmButtonColor: '#1e88e5',
                    allowOutsideClick: false,
                }).then(() => {
                    location.reload();
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

    function deleteWT(id) {
        let form = $(`#form-deleteWT_${id}`);
        Swal.fire({
            title: "Esta acción no se puede revertir",
            text: '¿Seguro deseas eliminar este archivo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-danger waves-effect waves-light px-3 py-2',
                cancelButton: 'btn btn-default waves-effect waves-light px-3 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: $(form).serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            confirmButtonColor: '#1e88e5',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (errorThrown) {
                        SwalError(errorThrown.responseJSON.message);
                    }
                });
            }
        });
    }

    function acceptWT(id) {
        let form = $(`#form-acceptWT_${id}`);
        Swal.fire({
            title: "Esta acción no se puede revertir",
            text: '¿Seguro deseas aceptar este seguimiento?',
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
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: $(form).serialize(),
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            confirmButtonColor: '#1e88e5',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (errorThrown) {
                        SwalError(errorThrown.responseJSON.message);
                    }
                });
            }
        });
    }

    function uploadFR() {
        let form = $("#form-uploadFR");
        let formData = new FormData();
        let file = $("#form-uploadFR input[name='file']")[0].files[0];
        formData.append('pps_id', $("#form-uploadFR input[name='pps_id']").val());
        formData.append('_token', $("#form-uploadFR input[name='_token']").val());
        formData.append('file', file);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    confirmButtonColor: '#1e88e5',
                    allowOutsideClick: false,
                }).then(() => {
                    location.reload();
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

<!-- jQuery file upload -->
<script src="{{ asset('plugins/dropify/dist/js/dropify.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection