@extends('layouts.base')
@section('content')
   
<!-- Session Status -->
 
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
    @csrf

<div class="d-flex justify-content-center align-items-center vh-70 bg-primary" style="--bs-bg-opacity: .5">
            <div class="container">
                <div class="text-center mb-2 mt-3">
                        <p>Iniciar sesión</p>
                </div>

        <div class="card mx-auto bg-light mb-5" style="width: 25rem; ">
            <div class="card-body">
        <!-- Email Address -->
        <div class="mb-2 mt-2">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" style="width: 100%;"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3 mt-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" style="width: 100%;"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mb-3 mt-3">
            <div class="form-check">
                <input id="remember_me" class="form-check-input" type="checkbox" name="remember">
                <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center">
            @if (Route::has('password.request'))
                <div class="me-4">
                    <a class="underline text-sm text-gray-600" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">
                {{ __('Log in') }}
            </button>
        </div>

                    </div>
                </div>
            </div>
</div>


</form>


@endsection