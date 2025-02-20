@extends('layouts.app')
@section('content')

<div class=" font-sans page antialiased" style="--bs-bg-opacity:.5">
  <div class="bg-gray-50 text-black/50">
    <div class="">
      <div class="">
        <div class=" d-flex justify-content-center align-items-start page-body" style="--bs-bg-opacity: .5">
          <div class="container mt-3">
            <ol class="breadcrumb ms-2">
              <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Inicio</a></li>
              <li class="breadcrumb-item active">Alumnos</li>
          </ol>
            <div class="bg-light mx-auto mb-3 card">
              <div class="flex-row card-header d-flex justify-content-between align-items-center ">
                <h3 class=" mt-2 text-center card-title h3">Alumnos</h3>
                @if(Auth::check() && Auth::user()->role_id === 4)
          <a href="{{ route('createStudent') }}" class="right-0 btn btn-success d-block" title="Crear estudiante">
            <i class="fa-solid fa-plus"></i>
          </a>
        @endif

              </div>
              <div class="card-body ">
                <div class="m-t-20 table-responsive">
                  <table class="table stylish-table">
                    <thead>
                      <tr>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Legajo</th>
                        <th>Email</th>
                        @if(Auth::check() && Auth::user()->role_id === 4)
              <th></th>
            @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($students as $student)
              <tr>
              <td>{{ $student->last_name }}</td>
              <td>{{ $student->first_name }}</td>
              <td>{{ $student->legajo }}</td>
              <td>{{ $student->email }}</td>
              @if(Auth::check() && Auth::user()->role_id === 4)
          <td class="d-flex justify-content-between align-items-center pe-4">
          <a href="{{route('editStudent', ['id' => $student->id])}}" title="Editar"><i class="fa-solid fa-pen"></i></a>
          <a class="btn" data-bs-toggle="modal"
          data-bs-target="#deleteStudentModal{{ $student->id }}" title="Eliminar"><i class="fa-solid fa-trash"></i></a>

          <!-- Modal -->
          <div class="modal fade" id="deleteStudentModal{{ $student->id }}" tabindex="-1"
          aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title h5" id="deleteStudentModalLabel">Eliminar Alumno</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
            </div>
            <div class="modal-body">
            ¿Está seguro de eliminar el alumno <b>{{ $student->last_name }},
            {{ $student->first_name }}</b>?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary"
            data-bs-dismiss="modal" title="Cancelar">Cancelar</button>
            <form action="{{ route('deleteStudent', ['id' => $student->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" title="Eliminar">Eliminar</button>
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
          <div class="modal " id="delete-student-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title h1 fs-5" id="exampleModalLabel">Eliminar Alumno</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                @if(isset($student))  
                  <span>

                    ¿Está seguro de eliminar el alumno <b style="font-style: italic">{{$student->last_name}},
                      {{$student->first_name}}</b>?
                  </span>
                @endif  
                </div>
                <div class="modal-footer">
                  <a type="button" class="w-50 btn btn-outline-secondary me-1" href="{{ route('getStudents') }}" title="Cancelar">
                    Cancelar
                  </a>
                  <button type="submit ml-3" class="w-50 btn btn-outline-primary ms-1" title="Guardar">
                    <a class="text-sm text-gray-600 underline" href="{{ route('storeNewStudent') }}">
                    </a>
                    Guardar Cambios
                  </button>
                </div>
              </div>
            </div>
@endsection