<section>
    <header>
        <h2 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">
            {{ __('Información del perfil') }}
        </h2>

        <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
            {{ __("Actualiza la información del perfil de tu cuenta y la dirección de correo electrónico.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-2 items-center">
            <div>
                <div>
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Correo')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-neutral-800 dark:text-neutral-200">
                            {{ __('Tu dirección de correo electrónico no está verificada.') }}

                            <button form="send-verification" class="underline text-sm text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 dark:focus:ring-offset-neutral-800">
                                {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                        </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div x-data="{ showModal: false }">
                <input type="hidden" id="selected-profile-image-id" name="profile_image_id" value="{{ old('profile_image_id', $user->profileImage->id) }}">
                <div class="flex justify-center md:justify-start md:ml-12">
                <div class="relative inline-block cursor-pointer hover:text-purple-300" @click="showModal = true">
                    <img class="aspect-square size-36 rounded-full opacity-75 transition-opacity duration-300"
                        id="profile-image"
                        src="{{ Auth::user()->profileImage->url }}"
                        alt="Imagen de perfil">
                    <span class="absolute inset-0 flex justify-center items-center">
                        <i class="fas fa-edit text-xl"></i>
                    </span>
                </div>
                </div>

                <div x-show="showModal" x-cloak class="fixed inset-0 flex justify-center items-center bg-neutral-950 bg-opacity-80">

                    <div class="w-96 p-4 bg-neutral-900 border-b border-neutral-800 rounded-md">
                        <h2 class="text-lg font-medium mb-4">Imagenes de perfil</h2>
                        <div class="grid grid-cols-4 gap-4">
                            @foreach ($profileImages as $profileImage)
                            <img
                                src="{{ $profileImage->url }}"
                                alt="Imagen de perfil"
                                class="size-full rounded-full cursor-pointer hover:opacity-80 transition-opacity duration-300"
                                @click="
                                document.getElementById('profile-image').src = '{{ $profileImage->url }}'; 
                                document.getElementById('selected-profile-image-id').value = '{{ $profileImage->id }}'; 
                                showModal = false
                            " />
                            @endforeach
                        </div>

                        <button type="button" @click="showModal = false" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('Cambios guardados.') }}</p>
            @endif
        </div>
    </form>
</section>