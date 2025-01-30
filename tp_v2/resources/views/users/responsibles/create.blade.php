@extends('layouts.app')
@section('content')

<form method="POST" action="{{ route('storeNewResponsible') }}">
    @csrf

    <div class="container">
        <div class="bg-light mx-auto mt-5 mb-5 card" style="width: 25rem;">
            <div class="card-body">
                <h3 class="text-center h3">Nuevo Responsable</h3>
                <hr>

                {{-- Primer Nombre --}}
                <div class="mt-3">
                    <label for="first_name">Nombre</label>
                    <input id="first_name" class="form-control" type="text" name="first_name" value="{{ old('first_name') }}" required>
                    @error('first_name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Apellido --}}
                <div class="mt-3">
                    <label for="last_name">Apellido</label>
                    <input id="last_name" class="form-control" type="text" name="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Correo Electrónico --}}
                <div class="mt-3">
                    <label for="email">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Legajo --}}
                <div class="mt-3">
                    <label for="legajo">Legajo</label>
                    <input id="legajo" class="form-control" type="number" name="legajo" value="{{ old('legajo') }}" required>
                    @error('legajo')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="mt-3">
                    <label for="password">Contraseña</label>
                    <input id="password" class="form-control" type="password" name="password" required>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmar Contraseña --}}
                <div class="mt-3">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
                </div>

                {{-- Botón Enviar --}}
                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </div>
    </div>
</form>


@endsection