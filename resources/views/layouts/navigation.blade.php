<nav x-data="{ open: false }" class="bg-white dark:bg-neutral-950 border-b border-gray-100 dark:border-purple-600 mb-12">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-purple-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('serie.catalog')" :active="request()->routeIs('serie.catalog')">
                        {{ __('Series') }}
                    </x-nav-link>
                    <x-nav-link :href="route('film.catalog')" :active="request()->routeIs('film.catalog')">
                        {{ __('Películas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('anime.catalog')" :active="request()->routeIs('anime.catalog')">
                        {{ __('Animes') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-zinc-900 hover:text-purple-600 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <p>{{ Auth::user()->name }}</p>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <a
                    href="{{ route('login') }}"
                    class="mx-3 my-2 text-gray-500 dark:text-gray-400 hover:text-black/70 dark:hover:text-gray-300 transition duration-150 ease-in-out">
                    Log in
                </a>
                <a
                    href="{{ route('register') }}"
                    class="ml-3 my-2 text-gray-500 dark:text-gray-400 hover:text-black/70 dark:hover:text-gray-300 transition duration-150 ease-in-out">
                    Register
                </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-purple-600 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-purple-950 focus:outline-none focus:bg-gray-100 dark:focus:bg-purple-950 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="mx-1 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('serie.catalog')" :active="request()->routeIs('serie.catalog')">
                {{ __('Series') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('film.catalog')" :active="request()->routeIs('film.catalog')">
                {{ __('Películas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('anime.catalog')" :active="request()->routeIs('anime.catalog')">
                {{ __('Animes') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="bg-black mx-3 mb-4 mt-10 rounded-md">
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}" class="flex justify-between">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
                @csrf

            </form>
        </div>
    </div>
</nav>