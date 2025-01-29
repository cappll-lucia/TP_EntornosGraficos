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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/popper/popper.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
{{--
<link rel="stylesheet" href="{{ asset('css/colors/default-dark.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="m-b-0 m-t-0 text-themecolor">Solicitudes</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('getPps') }}">Solicitudes</a></li>
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

    <!-- Modal para agregar observaciones -->
    <div class="modal fade" id="modalObservation" tabindex="-1" aria-labelledby="modalObservationLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalObservationLabel">Escriba Observaciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="observationForm" method="post" action="{{ route('pps.editObservation', $pps->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="observationInput" class="form-label">Observación</label>
                            <textarea class="form-control" id="observationInput" name="observation" rows="3"
                                required>{{ old('observation', $pps->observation) }}</textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-body">
                            <h2 class="box-title">Detalle de la solicitud #{{ $pps->id }}</h2>
                            <p class="box-subtitle">{{ $pps->created_at->format('d/m/Y') }}</p>
                            <hr class="m-t-0 m-b-20">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Estudiante:</b></td>
                                        <td>
                                            {{ $pps->Student->last_name }}, {{ $pps->Student->first_name }} - Legajo:
                                            {{ $pps->Student->legajo }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Responsable:</b></td>
                                        <td>
                                            @if ($pps->responsible_id != null)
                                                {{ $pps->Responsible->last_name }}, {{ $pps->Responsible->first_name }}
                                            @else
                                                Sin asignar
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Profesor a cargo:</b></td>
                                        <td>
                                            @if ($pps->teacher_id != null)
                                                {{ $pps->Teacher->last_name }}, {{ $pps->Teacher->first_name }}
                                            @else
                                                Sin asignar
                                            @endif
                                        </td>
                                    </tr>

                                    @if (auth()->user()->role_id == '3' && $pps->is_finished == 0 && $pps->is_editable == 0)
                                        <tr>
                                            <td class="col-4"><b class="font-weight-bold">Cambiar profesor:</b></td>
                                            <td>
                                                <select id="TeacherSelect" name="TeacherSelect" class="w-50 form-control">
                                                    @foreach($teachers as $teach)
                                                        <option value="{{ $teach->id }}">{{ $teach->first_name }}
                                                            {{ $teach->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endif

                                    {{-- Form para actualizar en caso de ser rechazado --}}
                                    <form action={{ route('pps.update', ['id' => $pps->id]) }} id="form_data"
                                        method="post" enctype="multipart/form-data">
                                        @csrf

                                        <tr>
                                            <td class="col-4"><b class="font-weight-bold">Fecha de inicio/fin:</b></td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($pps->start_date)->format('d/m/Y') }} -
                                                {{ \Carbon\Carbon::parse($pps->finish_date)->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                        @if (auth()->user()->role_id == '1' && $pps->is_editable == true)
                                            <tr>
                                                <td class="col-4"><b class="font-weight-bold">Editar fechas:</b></td>
                                                <td>
                                                    <label for="DatePickerFrom" class="mb-0">Fecha de inicio</label>
                                                    <input type="date" id="DatePickerFrom" class="w-50 form-control"
                                                        name="DatePickerFrom" />
                                                    <label for="DatePickerTo" class="mt-2 mb-0">Fecha de
                                                        finalización</label>
                                                    <input type="date" id="DatePickerTo" name="DatePickerTo"
                                                        class="w-50 form-control" />
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td class="col-4"><b class="font-weight-bold">Plan de trabajo:</b></td>
                                            <td>
                                                <a href="{{ Storage::url($pps->WorkPlan->file_path) }}" target="_blank"
                                                    class="btn btn-success btn-sm">
                                                    Ver archivo
                                                </a>
                                                @if (auth()->user()->role_id == '1' && $pps->is_editable == true)
                                                    <div class="mt-2">
                                                        <label for="fileInput" class="form-label">Selecciona un
                                                            archivo</label>
                                                        <input id="file" name="file" type="file" class="w-75 form-control"
                                                            accept=".pdf" />
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="col-4"><b class="font-weight-bold">Descripción:</b></td>
                                            <td>
                                                {{ $pps->description }}
                                                @if (auth()->user()->role_id == '1' && $pps->is_editable == true)
                                                    <textarea id="description" name="description"
                                                        class="mt-2 w-75 form-control" rows="3"></textarea>
                                                @endif
                                            </td>
                                        </tr>
                                    </form>
                                    {{-- Fin del form --}}

                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Observaciones:</b></td>
                                        <td>
                                            {{ $pps->observation != null ? $pps->observation : "-" }}
                                            @if (auth()->user()->role_id == '2' && $pps->is_finished === 1 && $pps->is_approved === 0)
                                                <button class="mt-2 btn btn-sm waves-effect waves-light" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#modalObservation">
                                                    <i class="bi bi-pencil-square"></i> Escribir observación
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="col-4"><b class="font-weight-bold">Estado de la solicitud
                                                inicial:</b></td>
                                        <td>
                                            @if ($pps->is_approved == true)
                                                <span class="label label-success">Aprobada</span>
                                            @else
                                                <span class="label label-warning">Pendiente de aprobación</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            {{--
                            <hr class="m-t-0 m-b-20"> --}}
                            @if (auth()->user()->role_id == '1' && $pps->is_editable == true)
                                <button id="btnEditar" class="btn btn-primary waves-effect waves-light"
                                    data-id="{{$pps->id}}">Finalizar cambios</button>
                                <hr class="m-t-0 m-b-20">
                            @endif
                            @if (auth()->user()->role_id == '3' && $pps->is_finished == false && $pps->is_editable == false)
                                <form id="form-finalizar">
                                    @csrf
                                    <input type="hidden" id="selectedTeacher" name="selectedTeacher"
                                        value="{{ $pps->teacher_id }}">
                                    <button id="btnFinalizar" class="btn btn-sm btn-success take-btn" type="button"
                                        data-id="{{ $pps->id }}">
                                        Aprobar solicitud inicial
                                    </button>
                                </form>
                                <hr class="m-t-0 m-b-20">
                            @endif

                            @if (auth()->user()->role_id == '2' && $pps->is_finished == true && $pps->is_approved == false && $pps->is_editable == false)
                                <div class="d-flex justify-content-end">
                                    <hr class="m-t-0 m-b-20">
                                    <button id="btnAprobar" class="btn btn-success waves-effect waves-light"
                                        data-id="{{$pps->id}}">Aprobar solicitud</button>
                                    <button id="btnRechazar" class="btn btn-danger waves-effect waves-light"
                                        data-id="{{$pps->id}}">Rechazar solicitud</button>
                                    <hr class="m-t-0 m-b-20">
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <button id="btnSeguimiento" class="btn btn-secondary" disabled>Ir a seguimientos
                                semanales</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>

<div id="loadingSpinner" class="d-none">
    <div class="text-primary spinner-border" role="status">
        <span class="visually-hidden">Cargando...</span>
    </div>
</div>

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
        $('#TeacherSelect').on('change', function () {
            const selectedTeacher = $(this).val();
            $('#selectedTeacher').val(selectedTeacher);
        });

        $('#modalObservation').on('shown.bs.modal', function () {
            $('#observationInput').trigger('focus');
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

        $(document).on("click", "#btnFinalizar", function () {
            event.stopPropagation();
            const id = $(this).data('id');

            Swal.fire({
                title: '¿Está seguro?',
                text: '¿Desea finalizar esta solicitud?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, finalizar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loadingSpinner").removeClass('d-none');

                    $.ajax({
                        url: `{{ route('assignTeacher', ':id') }}`.replace(':id', id),
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            selectedTeacher: $("#selectedTeacher").val(),
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message || 'La solicitud ha sido finalizada correctamente.',
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: xhr.responseJSON?.title || 'Error!',
                                text: xhr.responseJSON?.message || 'Hubo un problema al finalizar la solicitud.',
                            });
                        },
                        complete: function () {
                            $("#loadingSpinner").addClass('d-none');
                        }
                    });
                }
            });
        });



        $(document).on("click", "#btnAprobar", function () {
            event.stopPropagation();
            const id = $(this).data('id');

            Swal.fire({
                title: '¿Está seguro?',
                text: `¿Desea aprobar la PPS?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, aprobar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loadingSpinner").removeClass('d-none');

                    $.ajax({
                        url: `{{ route('pps.approve', ':id') }}`.replace(':id', id),
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            Swal.fire(
                                'Aprobado!',
                                'La solicitud ha sido aprobada con éxito.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Error!',
                                'Hubo un problema al aprobar la solicitud.',
                                'error'
                            );
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

            Swal.fire({
                title: '¿Está seguro?',
                text: `¿Desea rechazar la PPS?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, rechazar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loadingSpinner").removeClass('d-none');

                    $.ajax({
                        url: `{{ route('pps.reject', ':id') }}`.replace(':id', id),
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            Swal.fire(
                                'Rechazado!',
                                'La solicitud ha sido rechazada con éxito.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'Error!',
                                'Hubo un problema al rechazar la solicitud.',
                                'error'
                            );
                        },
                        complete: function () {
                            $("#loadingSpinner").addClass('d-none');
                        }
                    });
                }
            });
        });

        $("#btnEditar").on("click", function () {
            let form = $("#form_data");
            let formData = new FormData();

            let file = $("input[name='file']")[0].files[0];
            formData.append('start_date', $('#DatePickerFrom').val());
            formData.append('finish_date', $('#DatePickerTo').val());
            formData.append('description', $("#description").val());
            formData.append('_token', $("input[name='_token']").val());
            if (file) {
                formData.append('file', file);
            }

            $("#loadingSpinner").removeClass('d-none');

            $.ajax({
                url: $(form).attr('action'),
                method: 'POST',
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
                            window.location.reload();
                        }
                    });
                },
                error: function (errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: errorThrown.responseJSON?.title || 'Error',
                        text: errorThrown.responseJSON?.message || 'Ocurrió un error inesperado.',
                        confirmButtonColor: '#1e88e5',
                    });
                },
                complete: function () {
                    $("#loadingSpinner").addClass('d-none');
                }
            });
        });

        if ("{{ $pps->is_approved }}" == true) {
            $("#btnSeguimiento").prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');
        } else {
            $("#btnSeguimiento").prop('disabled', true).removeClass('btn-success').addClass('btn-secondary');
        }

        $("#btnSeguimiento").on("click", function () {
            window.location.href = "{{ route('getWeeklyTrackings', ['id' => $pps->id]) }}";
        });
    });
</script>

@endsection