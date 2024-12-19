<x-app-layout>
    <div class="max-w-6xl mx-3 lg:mx-auto mb-12 bg-neutral-950 border border-neutral-800 rounded-xl p-12 relative">
        <!-- Fondo con la imagen del póster y degradado -->
        <div class="absolute inset-0 right-0 top-0 bg-cover bg-no-repeat bg-right rounded-xl"
            style="background-image: url('https://image.tmdb.org/t/p/original{{$media->poster_path}}'); opacity: 0.2;">
            <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-br from-neutral-800 from-20% to-transparent rounded-xl"></div>
        </div>

        <!-- Contenido de la tarjeta -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative z-10">
            <div class="md:col-span-1">
                <div class="perspective-container">
                    <div class="image-container">
                        <img class="w-full rounded-lg shadow-2xl border border-purple-950" src="https://image.tmdb.org/t/p/original{{$media->poster_path}}" alt="{{ $media->name }}">
                    </div>
                </div>

                <div class="mt-3 hidden md:block">
                    <div class="grid grid-cols-4 gap-3 bg-black bg-opacity-75 rounded-md p-3 items-center">
                        <i class="fa-solid fa-share-from-square text-center text-sm"></i>
                        @foreach($shareButtons as $key => $url)
                            <a href="{{ $url }}" class="text-center text-lg px-2 py-1 bg-neutral-800 bg-opacity-40 border-b border-neutral-800 rounded-md hover:text-purple-400 hover:border-purple-600 hover:text-md transition duration-300" target="_blank">
                                @if($key === 'whatsapp')
                                    <span class="fab fa-whatsapp"></span>
                                @elseif($key === 'twitter')
                                    <span class="fab fa-twitter"></span>
                                @elseif($key === 'facebook')
                                    <span class="fab fa-facebook"></span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="md:col-span-3">
                <h3 class="text-3xl text-purple-600 font-bold capitalize">{{ $media->name }}</h3>
                <div class="my-6">
                    <p class="text-neutral-300 font-medium mt-1">
                        {{ $media->overview }}
                    </p>
                </div>
                <div class="text-neutral-300 font-medium sm:flex justify-between mb-6">
                    @if(!empty($media->genre->name))
                    <p>Género: {{ $media->genre->name ?? 'Sin género' }}</p>
                    @endif
                    @if(!empty($media->air_date))
                    <p>Fecha: {{ $media->air_date }}</p>
                    @endif
                </div>
                <div class="text-neutral-300 font-medium flex items-center">
                    <p class="mr-2">Lenguajes:</p>
                    @php
                    $languages = explode(',', $media->languages);
                    $languageToCountryMap = [
                        'EN' => 'US',
                        'KA' => 'GE',
                    ];
                    @endphp

                    @foreach ($languages as $language)
                    @php
                    $language = trim(strtoupper($language));

                    $flagCode = $languageToCountryMap[$language] ?? $language;
                    @endphp
                    <img
                        alt="Bandera {{ $flagCode }}"
                        src="https://purecatamphetamine.github.io/country-flag-icons/3x2/{{ $flagCode }}.svg"
                        class="w-6 h-4 rounded-sm mr-1" />
                    @endforeach
                </div>
            </div>
            <div class="block md:hidden">
                <div class="grid grid-cols-4 gap-3 bg-black bg-opacity-75 rounded-md p-3 items-center">
                    <i class="fa-solid fa-share-from-square text-center text-sm"></i>
                    @foreach($shareButtons as $key => $url)
                        <a href="{{ $url }}" class="text-center text-lg px-2 py-1 bg-neutral-800 bg-opacity-40 border-b border-neutral-800 rounded-md hover:text-purple-400 hover:border-purple-600 hover:text-md transition duration-300" target="_blank">
                            @if($key === 'whatsapp')
                                <span class="fab fa-whatsapp"></span>
                            @elseif($key === 'twitter')
                                <span class="fab fa-twitter"></span>
                            @elseif($key === 'facebook')
                                <span class="fab fa-facebook"></span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex justify-end items-center relative z-20">
            @if (session('success'))
                <p class="text-purple-200">{{ session('success') }}</p>
            @endif
            @if (count($lists) > 0)
            <div x-data="{ showModal: false}">
                <button @click="showModal = true" class="button bg-purple-600 rounded-full size-12 ml-6">
                    <i class="fa-solid fa-bookmark"></i>
                </button>

                <div x-show="showModal" x-cloak class="fixed inset-0 flex justify-center items-center bg-neutral-950 bg-opacity-80">
                    <form id="favoriteForm" method="post" action="{{ route('serie.store.favoriteList', ['id' => $media->id]) }}">
                        @csrf
                        <div class="w-96 p-4 bg-neutral-800 border-b border-neutral-700 rounded-md">
                            <h2 class="text-lg font-medium mb-4">Listas de favoritos</h2>
                            <div class="grid grid-cols-1 gap-2">
                                @foreach ($lists as $list)
                                    <x-text-input 
                                        id="name" 
                                        class="block mt-1 w-full cursor-pointer"
                                        type="text"
                                        name="name"
                                        autocomplete="List name"
                                        readonly
                                        value="{{ $list->name }}"
                                        @click="document.getElementById('favoriteForm').submit();" />

                                    <input type="hidden" name="list_id" value="{{ $list->id }}">
                                @endforeach
                            </div>

                            <button type="button" @click="showModal = false" class="mt-4 px-4 py-2 bg-red-500 rounded-md hover:bg-red-700">
                                Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div x-data="{ showAll: false, seasonsToShow: 3 }" class="max-w-6xl mx-3 lg:mx-auto">
        @foreach($media->seasons as $index => $season)
        <div x-show="showAll || {{ $index }} < seasonsToShow" x-data="{ open: false }" x-effect="if ({{ $index }} > seasonsToShow && !showAll && open) { open = false; }" class="mb-2 bg-neutral-950 border-b border-neutral-800 rounded-md p-3">
            <div class="flex justify-between cursor-pointer" @click="open = !open">
                <h4 class="text-xl text-purple-600 font-bold capitalize">{{ $season->name }}</h4>
                <div class="flex">
                    <p class="text-neutral-600">{{ $season->number_of_episodes }} episodios</p>
                    <svg x-bind:class="open ? 'transform rotate-180' : 'transform rotate-0'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6 ml-6">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    </svg>
                </div>
            </div>

            <div x-show="open" class="mt-3 text-neutral-400">
            <p class="mb-4">{{ $season->overview }}</p>
            <h5 class="text-lg text-neutral-300 mb-1 capitalize">Episodios:</h5>
            <div class="grid grid-cols-4 md:grid-cols-10 gap-2">
                    @foreach($season->episodes as $episode)
                    <div>
                        @if(!empty($episode->poster_path))
                            <img class="aspect-[4/5] w-full h-auto rounded-sm object-cover" src="https://image.tmdb.org/t/p/original{{$episode->poster_path}}" alt="{{ $episode->name }}">
                        @endif
                        <p>{{ $episode->name }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 p-3 flex items-center bg-purple-100 border border-purple-300 text-purple-800 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <p class="text-sm">
                        Por razones de rendimiento, solo se muestran 2 episodios por temporada ya que de otra forma habrían decenas de miles en la base de datos.
                    </p>
                </div>
            </div>
        </div>
        @endforeach

        <div x-show="!showAll" class="text-center mt-4">
            <button @click="showAll = true" class="px-4 py-2 bg-neutral-700 hover:bg-purple-700 border dark:border-neutral-600 dark:hover:border-purple-500 rounded-md transition duration-300">
                Ver más temporadas
            </button>
        </div>
        <div x-show="showAll" class="text-center mt-4">
            <button @click="showAll = false" class="px-4 py-2 bg-neutral-700 hover:bg-purple-700 border dark:border-neutral-600 dark:hover:border-purple-500 rounded-md transition duration-300">
                Mostrar menos
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.image-container');

            if (container) { // Verificar que el contenedor existe
                container.addEventListener('mousemove', (e) => {
                    const {
                        offsetWidth: width,
                        offsetHeight: height
                    } = container;
                    const {
                        offsetX: x,
                        offsetY: y
                    } = e;

                    const rotateX = ((y / height) - 0.5) * -10;
                    const rotateY = ((x / width) - 0.5) * 10;

                    container.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                });

                container.addEventListener('mouseleave', () => {
                    container.style.transform = 'rotateX(0) rotateY(0)';
                });
            }
        });
    </script>

    <style>
        /* CSS adicional para perspectiva 3D */
        .perspective-container {
            perspective: 1000px;
        }

        .image-container {
            transform-style: preserve-3d;
            transition: transform 0.1s ease;
        }

        /* Asegura que el texto largo se ajuste dentro del contenedor */
        .bg-neutral-800 h3 {
            word-wrap: break-word;
            /* Permite que las palabras largas se ajusten */
            overflow-wrap: break-word;
            /* Se asegura de que el texto largo se divida */
            white-space: normal;
            /* Permite que el texto se divida en múltiples líneas */
        }
    </style>
</x-app-layout>