<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold capitalize">{{ __('Perfil') }}</h2>
    </x-slot>

    <div>
        <div class="max-w-7xl md:mx-auto sm:px-6 lg:px-8 space-y-6 mx-4">
            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow rounded-lg border-b border-neutral-700">
                <div class=" w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow rounded-lg border-b border-neutral-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-neutral-800 shadow rounded-lg border-b border-neutral-700">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
