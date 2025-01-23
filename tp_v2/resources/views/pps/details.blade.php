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
{{-- <link rel="stylesheet" href="{{ asset('css/colors/default-dark.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
<script src="{{ asset('js/waves.js') }}"></script>
<link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/icheck/skins/all.css') }}" rel="stylesheet" />
<link href="{{ asset('plugins/wizard/steps.css') }}" rel="stylesheet" />
<!-- Switchery -->
<link href="{{ asset('plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
<!-- Datepicker -->
<link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">

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
            <h3 class="text-themecolor m-b-0 m-t-0">Solicitudes</h3>
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
    <div class="modal fade" id="modalObservation" tabindex="-1" aria-labelledby="modalObservationLabel" aria-hidden="true">
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
                            <textarea class="form-control" id="observationInput" name="observation" rows="3" required>{{ old('observation', $pps->observation) }}</textarea>
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
                                    @if (auth()->user()->role_id == '3' && $pps->is_finished == 0)
                                        <td class="col-4"><b class="font-weight-bold">Cambiar profesor:</b></td>
                                        <td><select id="TeacherSelect" name="TeacherSelect" class="form-control">
                                            @foreach($teachers as $teach)
                                            <option value="{{ $teach->id }}">{{ $teach->first_name }} {{ $teach->last_name }}</option>
                                            @endforeach
                                            </select>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Fecha de inicio/fin:</b></td>
                                    <td>{{ \Carbon\Carbon::parse($pps->start_date)->format('d/m/Y') }} -
                                        {{ \Carbon\Carbon::parse($pps->finish_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Plan de trabajo</b></td>
                                    <td>
                                        <a href="{{ Storage::url($wp->file_path) }}" target="_blank" class="btn btn-success btn-sm">
                                        Ver archivo
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Descripción:</b></td>
                                    <td>{{ $pps->description }}</td>
                                </tr>
                                <tr>
                                    <td class="col-4">
                                        <b class="font-weight-bold">Observaciones:</b>
                                        @if (auth()->user()->role_id == '2' && $pps->is_finished === 1 && $pps->is_approved === 0)
                                            <button class="btn btn-sm waves-effect waves-light" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#modalObservation">
                                                <i class="bi bi-pencil-square"></i> Escribir observación
                                            </button>
                                        @endif
                                    </td>
                                    <td>{{ $pps->observation != null ? $pps->observation : "-" }}</td>
                                </tr>
                                <tr>
                                    <td class="col-4"><b class="font-weight-bold">Estado de la solicitud incial:</b></td>
                                    @if ($pps->is_approved == true)
                                            <td><span class="label label-success">Aprobada</span></td>
                                        @else
                                            <td><span class="label label-warning">Pendiente de aprobación</span></td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                        {{-- <hr class="m-t-0 m-b-20"> --}}
                        @if (auth()->user()->role_id == '3' && $pps->is_finished == false)
                            <form id="form-finalizar" action="{{ route('assignTeacher', ['id' => $pps->id]) }}" method="POST">
                                @csrf
                                 <!-- Campo oculto para enviar el profesor seleccionado -->
                                <input type="hidden" id="selectedTeacher" name="selectedTeacher" value="{{ $pps->teacher_id }}">
                                <td><button id="btnFinalizar" class="btn btn-sm btn-success take-btn">Finalizar</button></td>
                            </form>
                            <hr class="m-t-0 m-b-20">
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
                        @if (auth()->user()->role_id == '2' && $pps->is_finished == true && $pps->is_approved == false)
                            <div class="d-flex justify-content-end">
                                <form id="form-approve" action="{{ route('pps.approve', ['id' => $pps->id]) }}" method="post">
                                    @csrf
                                    <button id="btnFinish" class="btn btn-success waves-effect waves-light"
                                        type="button">Aprobar solicitud</button>
                                </form>
                                {{-- Boton de rechazo: envia un mail para que cambie la desc o fechas? se tendria que justamente comentar en observaciones asi se envia eso x mail --}}
                                <button class="btn btn-sm btn-danger">Rechazar</button>
                                <hr class="m-t-0 m-b-20">
                            </div>
                        @endif
                        </div>
                        <div>
                            <button id="btnSeguimiento" class="btn btn-secondary" disabled>Ir a seguimientos semanales</button>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <br>
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

    $("#btnFinalizar").on("click", function () {
    Swal.fire({
        title: 'Esta acción no se puede revertir',
        text: '¿Seguro deseas finalizar esta solicitud?',
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
            let form = $("#form-finalizar");
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
                    Swal.fire({
                        icon: 'error',
                        title: errorThrown.responseJSON.title || 'Error',
                        text: errorThrown.responseJSON.message || 'Hubo un error al finalizar la solicitud',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        }
    });
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
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                confirmButtonColor: '#1e88e5',
                                allowOutsideClick: false,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(errorThrown) {
                            SwalError(errorThrown.responseJSON.title, errorThrown.responseJSON.message);
                        }
                    });
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