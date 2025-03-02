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
                    <div class="input-group">
                        <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 w-full block" autocomplete="current-password" />
                        <button type="button" id="toggleCurrentPassword" class="btn btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <!-- Nueva contraseña -->
                <div>
                    <x-input-label for="update_password_password" :value="__('Nueva contraseña')" />
                    <div class="input-group">
                        <x-text-input id="update_password_password" name="password" type="password" class="mt-1 w-full block" autocomplete="new-password" />
                        <button type="button" id="toggleNewPassword" class="btn btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <!-- Confirmar contraseña -->
                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirmar contraseña')" />
                    <div class="input-group">
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 w-full block" autocomplete="new-password" />
                        <button type="button" id="toggleConfirmPassword" class="btn btn-outline-secondary">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
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

    <style>
        /* Ocultar el ojo predeterminado en Edge */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const currentPasswordInput = document.getElementById("update_password_current_password");
            const newPasswordInput = document.getElementById("update_password_password");
            const confirmPasswordInput = document.getElementById("update_password_password_confirmation");

            const toggleCurrentPasswordButton = document.getElementById("toggleCurrentPassword");
            const toggleNewPasswordButton = document.getElementById("toggleNewPassword");
            const toggleConfirmPasswordButton = document.getElementById("toggleConfirmPassword");

            // Función para alternar la visibilidad de la contraseña
            function togglePassword(inputField, button) {
                if (inputField.type === "password") {
                    inputField.type = "text";
                    button.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    inputField.type = "password";
                    button.innerHTML = '<i class="fas fa-eye"></i>';
                }
            }

            // Eventos para mostrar/ocultar contraseñas
            toggleCurrentPasswordButton.addEventListener("click", function () {
                togglePassword(currentPasswordInput, this);
            });
            toggleNewPasswordButton.addEventListener("click", function () {
                togglePassword(newPasswordInput, this);
            });
            toggleConfirmPasswordButton.addEventListener("click", function () {
                togglePassword(confirmPasswordInput, this);
            });
        });
    </script>
</section>
