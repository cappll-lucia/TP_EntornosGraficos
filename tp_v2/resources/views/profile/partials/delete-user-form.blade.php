<section class="mt-4 d-flex justify-content-center">
    <div class="card" style="max-width: 600px; width: 100%;">
        <header class="card-header">
            <h2 class="font-medium text-lg text-gray-900">
                {{ __('Eliminar cuenta') }}
            </h2>
            <p class="mt-1 text-sm text-gray-400">
                {{ __('Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán permanentemente.
                Antes de eliminar su cuenta, descargue cualquier dato o información que desee conservar.') }}
            </p>
        </header>

        <div class="card-body">
            <button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="w-100 btn btn-danger"
            >
                {{ __('Eliminar cuenta') }}
            </button>

            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="font-medium text-lg text-gray-600">
                        {{ __('¿Estás seguro de que quieres eliminar tu cuenta?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán permanentemente. 
                        Ingrese su contraseña para confirmar que desea eliminar permanentemente su cuenta.') }}
                    </p>

                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />

                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 w-3/4 block"
                            placeholder="{{ __('Contraseña') }}"
                        />

                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="flex mt-6 justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')" class="me-3">
                            {{ __('Cancelar') }}
                        </x-secondary-button>

                        <x-danger-button class="ms-3">
                            {{ __('Eliminar cuenta') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
</section>
