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
            <h3 class=" mt-2 text-center card-title h3">Alumnos</h3>
            @if(Auth::check() && Auth::user()->role_id===4)
            <button type="button submit" class="right-0 btn btn-success d-block"> <a href="{{ route('createStudent') }}">
            <i class="fa-solid fa-plus"></i></a></button>
            @endif

          </div>
            <div class="card-body">
                        <div class="m-t-20 table-responsive">
                            <table class="table stylish-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
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
                                    @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->last_name }}</td>
                                        <td>{{ $student->first_name }}</td>
                                        <td>{{ $student->legajo }}</td>
                                        <td>{{ $student->email }}</td>
                                        @if(Auth::check() && Auth::user()->role_id===4)
                                        <td class="d-flex justify-content-between align-items-center pe-4">
                                            <a href="{{route('editStudent', ['id' => $student->id])}}"><i class="fa-solid fa-pen"></i></a>
                                            <a class="btn" data-bs-toggle="modal" data-bs-target="#deleteStudentModal{{ $student->id }}"><i class="fa-solid fa-trash"></i></a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title h5" id="deleteStudentModalLabel">Eliminar Docente</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Está seguro de eliminar el alumno <b>{{ $student->last_name }}, {{ $student->first_name }}</b>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <form action="{{ route('deleteStudent', ['id' => $student->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
        <div class="modal " id="delete-student-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title h1 fs-5" id="exampleModalLabel">Eliminar Alumno</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <span>

          ¿Está seguro de eliminar el alumno <b style="font-style: italic">{{$student->last_name}}, {{$student->first_name}}</b>?
        </span>
      </div>
      <div class="modal-footer">
                   <a type="button" class="w-50 btn btn-outline-secondary me-1" href="{{ route('getStudents') }}">
                Cancelar
            </a>
          <button type="submit ml-3" class="w-50 btn btn-outline-primary ms-1">
            <a class="text-sm text-gray-600 underline" href="{{ route('storeNewStudent') }}">
            </a>
              Guardar Cambios
            </button>
      </div>
    </div>
  </div>

@endsection