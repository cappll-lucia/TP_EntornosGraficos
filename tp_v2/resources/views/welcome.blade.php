@extends('layouts.app')
@section('content')
    <div class="font-sans antialiased dark:bg-black dark:text-white/50" style="--bs-bg-opacity:.5">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="">
                <div class="">
                <div class="bg-primary d-flex justify-content-center align-items-center vh-70" style="--bs-bg-opacity: .5">
            <div class="container mt-3">


        <div class="bg-light mx-auto mb-3 card">
            <div class="card-body">
            <h4 class="text-center card-title">Profesores disponibles para PPS</h4>
                        <div class="m-t-20 table-responsive">
                            <table class="table stylish-table">
                                <thead>
                                    <tr>
                                        <th>Apellido</th>
                                        <th>Nombre</th>
                                        <th>Legajo</th>
                                        <th>Email</th>
                                        @if(Auth::check() && Auth::user()->role_id===4)
                                        <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teachers_available as $teacher)
                                    <tr>
                                        <td>{{ $teacher->last_name }}</td>
                                        <td>{{ $teacher->first_name }}</td>
                                        <td>{{ $teacher->legajo }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        @if(Auth::check() && Auth::user()->role_id===4)
                                        <td class="d-flex justify-content-between mx-2">
                                            <button><i class="fa-solid fa-pen"></i></button>
                                            <button><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                        
                                        @endif
                                    </tr>                                      
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                
            </div>
        </div>
    </div>

@endsection