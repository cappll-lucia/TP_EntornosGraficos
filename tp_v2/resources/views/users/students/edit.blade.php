@extends('layouts.app')
@section('content')

<form method="POST" action="{{ route('updateStudent', ['id' => $student->id]) }}">
        @csrf

<div class=" page-body d-flex justify-content-center align-items-center vh-70" style="--bs-bg-opacity: .5">
            <div class="container">
                <div class="bg-light mx-auto mt-5 mb-5 card" style="width: 25rem; ">
                    <div class="card-body">
                        <div class="mt-3 text-center mb-2">
                            <h3 class="h3">Editar Alumno</h3>
                        </div>

                        <hr class="my-4" style="border-top: 1px solid rgba(0, 0, 0, 0.5);">
                        
        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('Nombre')" />
            <x-text-input id="first_name" class="mt-1 w-full block" type="text" name="first_name" value="{{$student->first_name}}" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Apellido')" />
            <x-text-input id="last_name" class="mt-1 w-full block" type="text" name="last_name" value="{{$student->last_name}}"  required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 w-full block" type="email" name="email" value="{{$student->email}}" required autocomplete="username" />
            @error('email')
                        <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Legajo -->
        <div class="mt-4">
            <x-input-label for="legajo" :value="__('Legajo')" />
            <x-text-input id="legajo" class="mt-1 w-full block" type="number" name="legajo" value="{{$student->legajo}}"  required autocomplete="legajo" />
            <x-input-error :messages="$errors->get('legajo')" class="mt-2" />
        </div>

        <div class="mt-5 d-flex justify-content-end align-items-center ">

          <div class="w-100 d-flex justify-content-between">
            <a type="button" class="w-50 btn btn-outline-primary me-1" href="{{ route('getStudents') }}" title="Cancelar">
                Cancelar
            </a>
            <button type="submit ml-3" class="w-50 btn btn-primary ms-1" title="Guardar">
            <a class="text-sm text-gray-600 underline" href="{{ route('storeNewStudent') }}">
            </a>
              Guardar Cambios
            </button>
          </div>
        </div>
                    </div>
                </div>
            </div>
        </div>



    </form>

@endsection