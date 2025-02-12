@php
    use Carbon\Carbon;
    $today = Carbon::now(new \DateTimeZone('America/Argentina/Buenos_Aires'));
@endphp

@extends('layouts.app')

@section('content')
    <!-- Styles -->
    <link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/icheck/skins/all.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/wizard/steps.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Switchery -->
    <link href="{{ asset('plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <!-- Datepicker -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">

    <!-- Switchery -->
    <script src="{{ asset('plugins/switchery/dist/switchery.min.js') }}"></script>
    <!-- Datepicker -->
    <script src="{{ asset('plugins/moment/moment-with-locales.js') }}"></script>
    <!-- Editable -->
    <script src="{{ asset('plugins/jquery-datatables-editable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>
    <!-- icheck -->
    <script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('plugins/icheck/icheck.init.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('plugins/wizard/jquery.steps.min.js') }}"></script>

    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="m-b-0 m-t-0 text-themecolor">Solicitudes</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/pps') }}">Solicitudes</a></li>
                    <li class="breadcrumb-item active">Nueva</li>
                </ol>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card justify-content ">
                    <div class="m-b-2 card-body wizard-content">
                        <h3 class="card-title">Nueva solicitud</h3>
                        <h6 class="mt-3 mb-3 card-subtitle">{{ $today->format('d/m/Y') }}</h6>
                        <form action={{ route('pps.create') }} class="tab-wizard wizard-circle" id="form_data"
                            method="POST">
                            @csrf
                            <!-- Step 1 -->
                            <h6>Alumno</h6>
                            <section>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-body">
                                            <h4 class="box-title">Tus datos</h4>
                                            <hr class="m-t-0 m-b-20" style="width: 100%">
                                            <div class="row col-md-15">
                                                <div class="col-md-4">
                                                    <div class="row form-group">
                                                        <label class="text-md-right col-4 control-label">Nombre:</label>
                                                        <div class="pr-0 col-7">
                                                            <p class="form-control-static">
                                                                {{ $student->first_name }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="row form-group">
                                                        <label class="text-md-right col-4 control-label">Apellido:</label>
                                                        <div class="pr-0 col-7">
                                                            <p class="form-control-static">
                                                                {{ $student->last_name }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row form-group">
                                                        <label class="text-md-right col-4 control-label">Legajo:</label>
                                                        <div class="pr-0 col-7">
                                                            <p class="form-control-static">
                                                                {{ $student->legajo }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="row form-group">
                                                        <label class="text-md-right col-4 control-label">Email:</label>
                                                        <div class="pr-0 col-7">
                                                            <p class="form-control-static">
                                                                {{ $student->email }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 2 -->
                            <h6>Datos</h6>
                            <section>
                                <h4 class="box-title">Datos de la PPS</h4>
                                <hr class="m-t-0 m-b-20" style="width: 100%">
                                <div class="m-0 p-0 row col-12">
                                    <!-- Date from -->
                                    <div class="mb-3 col-12 col-md-2">
                                        <label for="DatePickerFrom" class="mb-0">Fecha de inicio</label>
                                        <input type="date" id="DatePickerFrom" class="form-control" name="DatePickerFrom"
                                            placeholder="dd/mm/aaaa" required />
                                    </div>

                                    <!-- Date to -->
                                    <div class="mb-3 col-12 col-md-2">
                                        <label for="DatePickerTo" class="mb-0">Fecha de finalización</label>
                                        <input type="date" id="DatePickerTo" name="DatePickerTo" class="form-control"
                                            placeholder="dd/mm/aaaa" readonly />
                                    </div>
                                    <div class="mb-3 col-12 col-md-2">
                                        <label for="TeacherSelect" class="mb-0">Docente de tu preferencia</label>
                                        <select id="TeacherSelect" name="TeacherSelect" class="form-control">
                                            @foreach ($teachers as $teach)
                                                <option value="{{ $teach->id }}">{{ $teach->first_name }}
                                                    {{ $teach->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted form-text">
                                            Nota: Que este sea tu docente elegido no quiere decir que sea el asignado. Eso
                                            es decisión del responsable de las PPS.
                                        </small>
                                    </div>

                                </div>
                                <div class="m-0 p-0 row col-12">
                                    <!-- Description  -->
                                    <div class="mb-3 col-12 col-md-6">
                                        <label for="description" class="mb-0">Descripción</label>
                                        <textarea id="description" name="description" class="form-control" style="height: 100px;"></textarea>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 3 -->
                            <h6>Planes de trabajo</h6>
                            <section>
                                <h4 class="box-title">Archivos</h4>
                                <hr class="m-t-0 m-b-20" style="width: 100%">
                                <div class="m-0 p-0 row col-12" style="width: 70%">
                                    <div class="card ">
                                        <div class="card-body">
                                            <h5 class="card-title">Subir plan de trabajo</h5>
                                            <input name="file" type="file" class="dropify" accept=".pdf"
                                                data-max-file-size="2M" />
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #DataTable_wrapper>div:nth-child(2)>div>div>div.dataTables_scrollHead>div,
        #DataTable_wrapper>div:nth-child(2)>div>div>div.dataTables_scrollHead>div>table {
            width: 100% !important;
        }

        .dropify-wrapper .dropify-message p {
            font-size: 15px !important;
            padding: 2px !important;
            margin: 0 !important;
        }

        .actions a {
            margin-top: 15px !important;
        }
    </style>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let startDateInput = document.getElementById("DatePickerFrom");
            let endDateInput = document.getElementById("DatePickerTo");

            startDateInput.addEventListener("input", function() {
                let startDate = new Date(this.value);
                if (isNaN(startDate)) return; // Evita errores si la fecha es inválida

                let daysAdded = 0;

                while (daysAdded < 50) { // 10 semanas hábiles (5 días x 10 semanas)
                    startDate.setDate(startDate.getDate() + 1);
                    let dayOfWeek = startDate.getDay();
                    if (dayOfWeek !== 0 && dayOfWeek !== 6) { // Evitar sábados (6) y domingos (0)
                        daysAdded++;
                    }
                }

                let year = startDate.getFullYear();
                let month = String(startDate.getMonth() + 1).padStart(2, '0');
                let day = String(startDate.getDate()).padStart(2, '0');

                endDateInput.value = `${year}-${month}-${day}`;
            });
        });

        function validatePPS() {
            let dateFrom = $("input[name='DatePickerFrom']").val();
            let dateTo = $("input[name='DatePickerTo']").val();
            let description = $("textarea[name='description']").val();

            if (dateFrom == "") return fireAlert("Debes ingresar una fecha de inicio");
            if (dateTo == "") return fireAlert("Debes ingresar una fecha de finalización");
            if (description == "") return fireAlert("Debes ingresar una descripción");
            if (dateFrom > dateTo) return fireAlert("La fecha de inicio no puede ser mayor a la fecha de finalización");

            return true;
        }

        function validateFile() {
            let file = $("input[name='file']").val();
            if (!file) return fireAlert("Debes subir un plan de trabajo");
            return true;
        }

        function validateData() {
            if (!validatePPS()) return false;
            if (!validateFile()) return false;
            return true;
        }

        const fireAlert = (text) => {
            Swal.fire({
                icon: 'warning',
                title: 'ALERTA',
                text: text,
                showCancelButton: false,
                confirmButtonColor: '#1e88e5',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            });
            return false;
        };

        function sendForm() {
            let form = $("#form_data");
            let formData = new FormData();
            let file = $("input[name='file']")[0].files[0];
            formData.append('start_date', $('#DatePickerFrom').val());
            formData.append('finish_date', $('#DatePickerTo').val());
            formData.append('description', $("#description").val());
            formData.append('teacher_id', $("#TeacherSelect").val());
            formData.append('_token', $("input[name='_token']").val());
            formData.append('file', file);

            // Enviar solicitud AJAX
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
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
                error: function(errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: errorThrown.responseJSON.title,
                        text: errorThrown.responseJSON.message,
                        confirmButtonColor: '#1e88e5',
                    });
                }
            });
        }

        $(".tab-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                cancel: "Cancelar",
                next: "Siguiente",
                previous: "Anterior",
                finish: "Enviar",
            },
            onFinished: function(event, currentIndex) {
                if (validateData()) {
                    sendForm();
                }
            }
        });

        $(document).ready(function() {
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

            drEvent.on('dropify.errors', function(event, element) {
                console.log('Has Errors');
            });
        });
    </script>


    <script></script>

    <!-- jQuery file upload -->
    <script src="{{ asset('plugins/dropify/dist/js/dropify.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
