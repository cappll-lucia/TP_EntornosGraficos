@extends('layouts.app')
@section('content')
    <!-- Cartel Sistema de Gestión de PPS -->
    <div class="mt-4 text-center alert alert-info" role="alert">
        <h4>Sistema de Gestión de PPS</h4>
        <p>Bienvenido al sistema para la gestión de las prácticas profesionales supervisadas.</p>
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                        <div class="bg-light mx-auto mt-3 mb-5 card">
                            <div class="card-body">
                                <div class="mt-3 text-center mb-2">
                                    <h4>Inicio de sesión</h4>
                                </div>

                                <hr class="my-4" style="border-top: 1px solid rgba(0, 0, 0, 0.5);">

                                <!-- Email Address -->
                                <div class="mt-2 mb-2">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="form-control" type="email" name="email"
                                        :value="old('email')" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="mt-3 mb-3">
                                    <x-input-label for="password" :value="__('Contraseña')" />
                                    <div class="input-group">
                                        <x-text-input id="password" class="form-control" type="password" name="password"
                                            required autocomplete="current-password" />
                                        <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
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
                                            <a class="text-sm text-gray-600 underline"
                                                href="{{ route('password.request') }}" title="Olvidaste tu contraseña?">
                                                {{ __('Olvidaste tu contraseña?') }} 
                                            </a>
                                        </div>
                                    @endif

                                    <button type="submit" title="Iniciar sesion" class="btn btn-primary">
                                        {{ __('Iniciar sesion') }}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>


    <style>
        /* Ocultar el ojo predeterminado en Edge */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("password");
            const togglePasswordButton = document.getElementById("togglePassword");

            togglePasswordButton.addEventListener("click", function () {
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Cambia el ícono
                } else {
                    passwordInput.type = "password";
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    </script>
@endsection
