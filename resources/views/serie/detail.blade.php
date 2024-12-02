<x-app-layout>
    <div class="max-w-6xl mx-3 lg:mx-auto mb-12 bg-neutral-950 border border-neutral-800 rounded-xl p-12 relative">
        <!-- Fondo con la imagen del póster y degradado -->
        <div class="absolute inset-0 right-0 top-0 bg-cover bg-no-repeat bg-right rounded-xl"
            style="background-image: url('https://image.tmdb.org/t/p/original{{$media->poster_path}}'); opacity: 0.2;">
            <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-br from-neutral-800 from-20% to-transparent rounded-xl"></div>
        </div>

        <!-- Contenido de la tarjeta -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative z-10">
            <div class="md:col-span-1 flex justify-center">
                <div class="perspective-container">
                    <div class="image-container">
                        <img class="w-full rounded-lg shadow-2xl" src="https://image.tmdb.org/t/p/original{{$media->poster_path}}" alt="{{ $media->name }}">
                    </div>
                </div>
            </div>

            <div class="md:col-span-3">
                <h3 class="text-3xl text-gray-200 font-bold capitalize">{{ $media->name }}</h3>
                <div class="my-6">
                    <p class="text-neutral-300 font-medium mt-1">
                        {{ $media->overview }}
                    </p>
                </div>
                <div class="text-neutral-300 font-medium flex justify-between">
                    <p>Género: {{ $media->genre->name ?? 'Sin género' }}</p>
                    <p>Fecha: {{ $media->air_date }}</p>
                </div>
            </div>
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