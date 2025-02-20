<section class="mt-4 d-flex justify-content-center">
    <div class="card" style="max-width: 600px; width: 100%;">

        <header class="card-header">
            <h2 class="font-medium text-lg text-gray-900">
                {{ __('Información del perfil') }}
            </h2>
            <p class="mt-1 text-sm text-gray-400">
                {{ __("Actualiza tu información") }}
            </p>
        </header>

        <div class="card-body">

            <form id="profile-update-form" method="post" action="{{ route('profile.update') }}" class="space-y-6 mt-6">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="first_name" :value="__('Nombre')" />
                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 w-100 block"
                        :value="old('first_name', $user->first_name)" required autofocus autocomplete="first_name" />
                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                </div>

                <div>
                    <x-input-label for="last_name" :value="__('Apellido')" />
                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 w-100 block"
                        :value="old('last_name', $user->last_name)" required autofocus autocomplete="last_name" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 w-100 block" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    <!-- @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div>
                            <p class="mt-2 text-sm text-gray-800 ">
                                {{ __('Su dirección de correo electrónico no está verificada.') }}
                                <button form="send-verification" class="text-sm text-gray-600 underline">
                                    {{ __('Haga clic aquí para volver a enviar el correo electrónico de verificación.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="font-medium mt-2 text-sm text-green-600">
                                    {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                                </p>
                            @endif 
                        </div> 
                    @endif -->
                </div>

                <!-- Separar el botón de guardar del último textbox -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" title="Guardar">{{ __('Guardar') }}</button>
                </div>

                <!-- Mostrar mensaje de éxito cuando se guarda -->
                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                        class="mt-2 text-md text-green-600">{{ __('Cambios realizados con éxito') }}</p>
                @endif
            </form>
        </div>
    </div>
</section>