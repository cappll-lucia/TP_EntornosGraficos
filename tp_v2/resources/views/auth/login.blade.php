@extends('layouts.app')
@section('content')

<!-- Session Status -->

<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="bg-light mx-auto mt-5 mb-5 card" style="width: 25rem; ">
                <div class="card-body">
                    <div class="mt-3 text-center mb-2">
                        <h4>Inicio de sesión</h4>
                    </div>

                    <hr class="my-4" style="border-top: 1px solid rgba(0, 0, 0, 0.5);">

                    <!-- Email Address -->
                    <div class="mt-2 mb-2">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                            required autofocus autocomplete="username" style="width: 100%;" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-3 mb-3">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required
                            autocomplete="current-password" style="width: 100%;" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="mt-3 mb-3 d-none">
                        <div class="form-check">
                            <input id="remember_me" class="form-check-input" type="checkbox" name="remember">
                            <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center">
                        @if (Route::has('password.request'))
                            <div class="me-4">
                                <a class="text-sm text-gray-600 underline" href="{{ route('password.request') }}">
                                    {{ __('Olvidaste tu contraseña?') }}
                                </a>
                            </div>
                        @endif

                        <button type="button submit" class="btn btn-primary">
                            {{ __('Iniciar sesion') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>


</form>


@endsection