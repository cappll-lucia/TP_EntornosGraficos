@extends('layouts.app')
@section('content')
<div class=" font-sans page antialiased dark:bg-black dark:text-white/50" style="--bs-bg-opacity:.5">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="">
                <div class="">
                <div class=" d-flex justify-content-center align-items-start page-body" style="--bs-bg-opacity: .5">
            <div class="container mt-3">

        <div class="bg-light mx-auto mb-3 card">
          <div class="flex-row card-header d-flex justify-content-between align-items-center ">
            <h3 class=" mt-2 text-center card-title h3">Solicitudes de PPS de {{Auth::user()->first_name}} {{Auth::user()->last_name}}</h3>
            <button type="button submit" class="right-0 btn btn-success d-block"> <a href="{{ route('createPps') }}">
            <i class="fa-solid fa-plus"></i></a></button>

          </div>
            <div class="card-body">
                        <div class="m-t-20 table-responsive">
                            <table class="table stylish-table">
                                <thead>
                                    <tr>
                                        <th>Fecha de inicio</th>
                                        <th>Fecha de fin</th>
                                        <th>Responsable</th>
                                        <th>Docente</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pps as $p)
                                    <tr>
                                        <td>{{ $p->start_date }}</td>
                                        <td>{{ $p->finish_date }}</td>
                                        <td>{{ $p->responsible->first_name }} {{ $p->responsible->last_name }}</td>
                                        <td>{{ $p->teacher->first_name }} {{ $p->teacher->last_name }}</td>
                                        <!-- falta un boton de ver progreso -->
                                    </tr>                                      
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
</div>
</div>


@endsection