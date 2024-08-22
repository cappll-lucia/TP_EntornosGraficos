@extends('layouts.app')
@section('content')
<div class=" font-sans page antialiased" style="--bs-bg-opacity:.5">
  <div class="bg-gray-50 text-black/50">
    <div class="">
      <div class="">
        <div class=" d-flex justify-content-center align-items-start page-body" style="--bs-bg-opacity: .5">
          <div class="container mt-3">

            <div class="bg-light mx-auto mb-3 card">
              <div class="flex-row card-header d-flex justify-content-between align-items-center ">
                <h3 class=" mt-2 text-center card-title h3">Responsables</h3>
                @if(Auth::check() && Auth::user()->role_id === 4)
          <a href="{{ route('createResponsible') }}" class="right-0 btn btn-success d-block">
            <i class="fa-solid fa-plus"></i>
          </a>
        @endif

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
                        @if(Auth::check() && Auth::user()->role_id === 4)
              <th></th>
            @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($responsibles as $responsible)
              <tr>
              <td>{{ $responsible->last_name }}</td>
              <td>{{ $responsible->first_name }}</td>
              <td>{{ $responsible->legajo }}</td>
              <td>{{ $responsible->email }}</td>
              @if(Auth::check() && Auth::user()->role_id === 4)
          <td class="d-flex justify-content-between align-items-center pe-4">
          <a href="{{route('editResponsible', ['id' => $responsible->id])}}"><i
            class="fa-solid fa-pen"></i></a>
          <a class="btn" data-bs-toggle="modal"
          data-bs-target="#deleteResponsibleModal{{ $responsible->id }}"><i
            class="fa-solid fa-trash"></i></a>

          <!-- Modal -->
          <div class="modal fade" id="deleteResponsibleModal{{ $responsible->id }}" tabindex="-1"
          aria-labelledby="deleteResponsibleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title h5" id="deleteResponsibleModalLabel">Eliminar Responsable</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
            </div>
            <div class="modal-body">
            ¿Está seguro de eliminar el responsable <b>{{ $responsible->last_name }},
            {{ $responsible->first_name }}</b>?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary"
            data-bs-dismiss="modal">Cancelar</button>
            <form action="{{ route('deleteResponsible', ['id' => $responsible->id]) }}"
            method="POST">
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
          <div class="modal " id="delete-responsible-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title h1 fs-5" id="exampleModalLabel">Eliminar Responsable</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                @if(isset($responsible))  
                  <span>

                    ¿Está seguro de eliminar el responsable <b style="font-style: italic">{{$responsible->last_name}},
                      {{$responsible->first_name}}</b>?
                  </span>
                @endif  
                </div>
                <div class="modal-footer">
                  <a type="button" class="w-50 btn btn-outline-secondary me-1" href="{{ route('getResponsibles') }}">
                    Cancelar
                  </a>
                  <button type="submit ml-3" class="w-50 btn btn-outline-primary ms-1">
                    <a class="text-sm text-gray-600 underline" href="{{ route('storeNewResponsible') }}">
                    </a>
                    Guardar Cambios
                  </button>
                </div>
              </div>
            </div>

            @endsection