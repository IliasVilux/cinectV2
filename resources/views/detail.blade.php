<x-app-layout>
    <div class="max-w-6xl mx-auto mb-12">
        <!-- Configuración de la grid con altura dinámica -->
        <div class="grid grid-cols-3 grid-rows-[auto_1fr] gap-4">
            <!-- Imagen (ocupa dos filas y tiene el efecto 3D) -->
            <div class="row-span-2 p-8 bg-neutral-800 rounded-xl perspective-container">
                <div class="image-container">
                    <img class="w-auto rounded-xl transition-transform duration-1000 transform group-hover:scale-105 shadow-xl" src="https://image.tmdb.org/t/p/original{{$media->poster_path}}" alt="{{ $media->name }}">
                </div>
            </div>

            <div class="col-span-2 bg-neutral-800 p-8 rounded-xl">
                <h3 class="text-3xl font-bold text-black capitalize dark:text-gray-200">{{ $media->name }}</h3>
            </div>

            <div class="col-span-2 bg-neutral-800 p-8 rounded-xl flex flex-col justify-between">
                <div>
                    <h4 class="text-2xl font-bold text-black capitalize dark:text-gray-200">Descripción</h4>
                    <p class="text-neutral-400 font-medium mt-1">
                        {{ $media->overview }}
                    </p>
                </div>
                <p class="text-neutral-400 font-medium">Fecha: {{ $media->air_date }}</p>
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
            word-wrap: break-word;  /* Permite que las palabras largas se ajusten */
            overflow-wrap: break-word; /* Se asegura de que el texto largo se divida */
            white-space: normal; /* Permite que el texto se divida en múltiples líneas */
        }
    </style>
</x-app-layout>
