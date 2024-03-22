@extends('layouts.base')
@section('content')
    <div class="font-sans antialiased dark:bg-black dark:text-white/50" style="--bs-bg-opacity:.5">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="flex flex-col min-h-screen relative items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="w-full max-w-2xl px-6 relative lg:max-w-7xl">
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