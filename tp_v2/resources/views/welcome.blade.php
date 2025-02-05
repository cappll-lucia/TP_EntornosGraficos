@extends('layouts.app')
@section('content')
    <div class=" font-sans page antialiased ">
        <div class=" text-black/50 ">
            <div class="">
                <div class="">
                    <div class=" d-flex justify-content-center align-items-start page-body">
                        <div class="container ">

                            <div class="mt-4 text-center alert alert-info" role="alert">
                                <h4>Sistema de Gestión de PPS</h4>
                            </div>

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
