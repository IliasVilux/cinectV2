<x-app-layout>
    <div class="max-w-6xl mx-3 lg:mx-auto mb-12 bg-neutral-950 border border-neutral-800 rounded-xl p-12 relative">
        <!-- Fondo con la imagen del póster y degradado -->
        <div class="absolute inset-0 right-0 top-0 bg-cover bg-no-repeat bg-right rounded-xl"
            style="background-image: url('{{$media->poster_path}}'); opacity: 0.2;">
            <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-br from-neutral-800 from-20% to-transparent rounded-xl"></div>
        </div>

        <!-- Contenido de la tarjeta -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative z-10">
            <div class="md:col-span-1">
                <div class="perspective-container">
                    <div class="image-container">
                        <img class="w-full rounded-lg shadow-2xl border border-purple-950" src="{{$media->poster_path}}" alt="{{ $media->name }}">
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="my-3 grid grid-cols-4 gap-3 bg-black bg-opacity-75 rounded-md p-3 items-center">
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
                    <x-star-rating :mediaId="$media->id" mediaType="anime" />
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
                    @if(!empty($media->release_date))
                    <p>Fecha: {{ $media->release_date }}</p>
                    @endif
                </div>
            </div>

            <div class="block md:hidden">
                <div class="mb-6 grid grid-cols-4 gap-3 bg-black bg-opacity-75 rounded-md p-3 items-center">
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
                <x-star-rating :mediaId="$media->id" mediaType="anime" />
            </div>
        </div>
        <div class="flex md:justify-end items-center relative z-20">
            @if (session('success'))
                <p class="text-purple-200 mt-6 md:mt-0">{{ session('success') }}</p>
            @endif
            @if (count($lists) > 0)
            <div x-data="{ showModal: false}">
                <button @click="showModal = true" class="button bg-purple-600 rounded-full size-12 ml-6">
                    <i class="fa-solid fa-bookmark"></i>
                </button>

                <div x-show="showModal" x-cloak class="fixed inset-0 flex justify-center items-center bg-neutral-950 bg-opacity-80">
                    <form id="favoriteForm" method="post" action="{{ route('anime.store.favoriteList', ['id' => $media->id]) }}">
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

                            <button type="button" @click="showModal = false" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">
                                Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
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