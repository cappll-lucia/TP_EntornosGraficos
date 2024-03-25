@extends('layouts.app')
@section('content')
    <div class=" page font-sans antialiased dark:bg-black dark:text-white/50" style="--bs-bg-opacity:.5">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="">
                <div class="">
                <div class=" d-flex justify-content-center align-items-start page-body" style="--bs-bg-opacity: .5">
            <div class="container mt-3">



        <div class="bg-light mx-auto mb-3 card">
                     <div class="card-header d-flex justify-content-between flex-row align-items-center ">
            <h3 class=" h3 mt-2 text-center card-title">Docentes disponibles para PPS</h3>
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
                                        <td class="d-flex justify-content-between pe-4">
                                            <a href="{{route('editTeacher', ['id' => $teacher->id])}}"><i class="fa-solid fa-pen"></i></a>
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