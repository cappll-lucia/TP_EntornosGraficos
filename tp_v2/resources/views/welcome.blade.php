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
            <h3 class=" mt-2 text-center card-title h3">Docentes disponibles para PPS</h3>
                     </div>
            <div class="card-body">
                        <div class="m-t-20 table-responsive">
                            <table class="table stylish-table">
                                <thead>
                                    <tr>
                                        <th>Apellido</th>
                                        <th>Nombre</th>
                                        <th>Legajo</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teachers_available as $teacher)
                                    <tr>
                                        <td>{{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->first_name }}</td>
                                        <td>{{ $teacher->legajo }}</td>
                                        <td>{{ $teacher->email }}</td>
                                    </tr>                                      
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                
            </div>
        </div>
    </div>


@endsection