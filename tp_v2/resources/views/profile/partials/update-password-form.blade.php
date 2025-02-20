<section class="mt-4 d-flex justify-content-center">
    <div class="card" style="max-width: 600px; width: 100%;">
        <header class="card-header">
            <h2 class="font-medium text-lg text-gray-900">
                {{ __('Actualizar contraseña') }}
            </h2>
            <p class="mt-1 text-sm text-gray-400">
                {{ __('Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura.') }}
            </p>
        </header>

        <div class="card-body">
            <form method="post" action="{{ route('password.update') }}" class="space-y-6 mt-6">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="update_password_current_password" :value="__('Contraseña actual')" />
                    <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 w-full block" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password" :value="__('Nueva contraseña')" />
                    <x-text-input id="update_password_password" name="password" type="password" class="mt-1 w-full block" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirmar contraseña')" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 w-full block" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" title="Guardar">{{ __('Guardar') }}</button>
                </div>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="mt-2 text-sm text-green-600">
                        {{ __('Guardado.') }}
                    </p>
                @endif
            </form>
        </div>
    </div>
</section>
