@extends('layouts.base')
@section('content')

<form method="POST" action="{{ route('register') }}">
        @csrf

<div class="d-flex justify-content-center align-items-center vh-70 bg-primary" style="--bs-bg-opacity: .5">
            <div class="container mb-5">
                <div class="text-center mb-2 mt-3">
                    <p>Registrarse</p>
                </div>

                <div class="card mx-auto bg-light" style="width: 25rem; ">
                    <div class="card-body">
                        
        <!-- First Name -->
        <div>
            <x-input-label for="first_name" :value="__('Nombre')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Apellido')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="d-flex justify-content-end align-items-center mt-3 ">
            <div class="me-4">
            <a class="underline text-sm text-gray-600" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            </div>

            <button type="submit ml-3" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>
                    </div>
                </div>
            </div>
        </div>



    </form>

@endsection