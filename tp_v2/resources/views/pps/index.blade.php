@extends('layouts.app')

@section('content')
<!-- Data table -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- This is data table -->

<script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="m-b-0 m-t-0 text-themecolor">Solicitudes</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Solicitudes</li>
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
        <div class="col-lg-12">
            <div class="shadow card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 card-title fw-bold fs-4">Listado de solicitudes</h2>
                        @if(auth()->user()->role_id == '1')
                            <a href="{{ route('pps.new') }}" class="btn btn-info btn-rounded waves-effect waves-light">Nueva
                                solicitud</a>
                        @endif
                    </div>
                    <div class="mt-1 table-responsive">
                        <table id="DataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Estudiante</th>
                                    <th>Responsable</th>
                                    <th>Profesor</th>
                                    <th>Descripción</th>
                                    <th>Fecha fin</th>
                                    <th>Aprobada</th>
                                    <th>Finalizada</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="table_body">
                                @foreach ($pps as $app)
                                    <tr data-id="{{ $app->id }}" class="clickable" data-url="/pps/details">
                                        <td>{{ $app->Student->last_name }}, {{ $app->Student->first_name }}</td>
                                        @if ($app->Responsible == null)
                                            <td>-</td>
                                        @else
                                            <td>{{ $app->Responsible->last_name }}, {{ $app->Responsible->first_name }}</td>
                                        @endif
                                        @if ($app->Teacher == null)
                                            <td>-</td>
                                        @else
                                            <td>{{ $app->Teacher->last_name }}, {{ $app->Teacher->first_name }}</td>
                                        @endif
                                        <td>{{ $app->description }}</td>
                                        <td>{{ \Carbon\Carbon::parse($app->finish_date)->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            @if ($app->FinalReport != null)
                                                @if ($app->FinalReport->is_accepted == true)
                                                    <i class="bi bi-check2" style="font-size: 1.5rem"></i>
                                                @else
                                                    <i class="bi bi-x-lg" style="font-size: 1.3rem"></i>
                                                @endif
                                            @else
                                                <i class="bi bi-x-lg" style="font-size: 1.3rem"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($app->FinalReport != null)
                                                @if ($app->FinalReport->is_checked == true)
                                                    <i class="bi bi-check2" style="font-size: 1.5rem"></i>
                                                @else
                                                    <i class="bi bi-x-lg" style="font-size: 1.3rem"></i>
                                                @endif
                                            @else
                                                <i class="bi bi-x-lg" style="font-size: 1.3rem"></i>
                                            @endif
                                        </td>
                                        @if (auth()->user()->role_id == '3' && $app->Responsible == null)
                                            <td>
                                                <button class="btn btn-sm btn-success take-btn" data-id="{{$app->id}}" data-student="{{ $app->Student->first_name }} {{ $app->Student->last_name }}">Tomar</button>
                                                {{-- <button class="btn btn-sm btn-danger">Rechazar</button> --}}
                                            </td>
                                        @else
                                            @if ($app->FinalReport != null && $app->FinalReport->is_approved == true)
                                                <td>
                                                    <a href="{{ route('resume', $app->id) }}" class="btn btn-sm btn-info">Ver</a>
                                                </td>
                                            @else
                                                <td>&nbsp;</td>
                                            @endif
                                        @endif    
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#DataTable').DataTable({
        "autoWidth": false,
        "language": {
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ solicitudes",
            "sInfoEmpty": "Mostrando 0 a 0 de 0 solicitudes",
            "sInfoFiltered": "(filtrado de _MAX_ solicitudes en total)",
            "emptyTable": 'No hay solicitudes que coincidan con la búsqueda',
            "sLengthMenu": "Mostrar _MENU_ solicitudes",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior",
            },
        },
        "columnDefs": [
        { "orderable": false, "targets": -1 }, 
        ]

    });

    $('#DataTable').on('draw.dt', function () {
        $('#DataTable tbody tr').addClass('clickable');
    });



    $(document).on("click", ".clickable", function (event) {
        if (!$(event.target).closest('.btn').length) {
        let url = $(this).data('url');
        let id = $(this).data('id');
        window.location.href = url + "/" + id;
        }
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