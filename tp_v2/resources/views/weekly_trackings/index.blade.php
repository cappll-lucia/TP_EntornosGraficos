@extends('layouts.app')
@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('plugins/datatables/media/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    {{--
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="{{ asset('plugins/datatables/datatables.min.js') }}"></script>
    <div class="row">
        <div class="col-lg-12">
            <div class="shadow-lg m-2 card-body">
                <div class="col-md-5 col-8 align-self-center">
                    <h3 class="m-b-0 m-t-0 text-themecolor">Seguimientos semanales</h3>
                </div>
                <div class="mt-1 table-responsive">
                    <table id="DataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Semana</th>
                                <th>Archivo</th>
                                <th>Observaciones</th>
                                <th>Aprobado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ($pps->WeeklyTrackings as $wt)
                                <tr data-id="{{ $wt->id }}" class="clickable" data-url="/weeklyTracking">
                                    <td>{{ $counter }}</td>
                                    <td>
                                        @if ($wt->file_path == null)
                                            <span class="text-danger">No se ha subido el archivo</span>
                                        @else
                                            <a href="{{ url('/weeklyTracking/downloadWeeklyTracking/' . $wt->id) }}"
                                                class="btn btn-success btn-sm">
                                                Ver archivo
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $wt->observation != null ? $wt->observation : '-' }}
                                        @if (auth()->user()->role_id == '2' && $pps->is_finished == true && $pps->is_approved == false)
                                            <button class="btn btn-sm waves-effect waves-light" type="button"
                                                data-bs-toggle="modal" data-bs-target="#modalObservation">
                                                <i class="bi bi-pencil-square"></i> Escribir observación
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($wt->is_accepted == true)
                                            <i class="bi bi-check2" style="font-size: 1.5rem"></i>
                                        @else
                                            <i class="bi bi-x-lg" style="font-size: 1.3rem"></i>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $counter++;
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="m-t-0 m-b-20">
            @if (!$existsFR)
                <form id="generate-fr-form" action="{{ route('fr.generate', $pps->id) }}" method="POST">
                    @csrf
                    <button id="btnSeguimiento" class="btn btn-primary">
                        Ir a acta de finalización
                    </button>
                </form>
            @else
                <form id="generate-fr-form" action="{{ route('fr.details', $pps->id) }}" method="GET">
                    @csrf
                    <button id="btnSeguimiento" class="btn btn-primary">
                        Ir a acta de finalización
                    </button>
                </form>
            @endif
            <hr class="m-t-0 m-b-10">
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#DataTable').DataTable({
                paging: false,
                searching: false,
                info: false
            });
        });

        $(document).on("click", ".clickable", function(event) {
            if (!$(event.target).closest('.btn').length) {
                let url = $(this).data('url');
                let id = $(this).data('id');
                window.location.href = url + "/" + id;
            }
        });

        if ("{{ $isLastWtApproved }}" == true) {
            $("#btnSeguimiento").prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');
        } else {
            $("#btnSeguimiento").prop('disabled', true).removeClass('btn-success').addClass('btn-secondary');
        }

        $("#btnSeguimiento").on("click", function() {
            window.location.href = "{{ route('fr.details', ['id' => $pps->id]) }}";
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
