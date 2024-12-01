<div class="max-w-7xl mx-auto mb-12">
    <div class="flex justify-between items-center mx-4 mb-2">
        <h2 class="text-3xl font-bold text-black capitalize dark:text-gray-200">{{ $title }}</h2>
        <a href="/{{ strtolower($title) }}" class="text-md font-bold hover:underline text-gray-200">Mostrar todos</a>
    </div>

    <div class="block md:hidden relative">
        <!-- Carousel -->
        <div class="relative">
            <!-- Botón Izquierdo -->
            <button id="leftBtn" class="absolute top-1/2 left-3 z-20 transform -translate-y-1/2 text-white bg-purple-800 rounded-full w-10 h-10 flex items-center justify-center">
                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                        <path fill-rule="evenodd" d="M14 8a.75.75 0 0 1-.75.75H4.56l1.22 1.22a.75.75 0 1 1-1.06 1.06l-2.5-2.5a.75.75 0 0 1 0-1.06l2.5-2.5a.75.75 0 0 1 1.06 1.06L4.56 7.25h8.69A.75.75 0 0 1 14 8Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </button>

            <div id="carousel" class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth relative no-scrollbar">
                @foreach ($items as $item)
                <a href="/{{ strtolower($mediaType) }}/{{ $item->id }}" class="p-2 text-neutral-400 min-w-80 max-w-xs snap-center snap-always">
                    <img class="aspect-[4/6] w-full rounded-lg" src="https://image.tmdb.org/t/p/original{{ $item->poster_path }}" alt="{{ $item->name }}">
                    <p class="font-medium mt-1 truncate">{{ $item->name }}</p>
                </a>
                @endforeach
            </div>

            <!-- Botón Derecho -->
            <button id="rightBtn" class="absolute top-1/2 right-3 z-20 transform -translate-y-1/2 text-white bg-purple-800 rounded-full w-10 h-10 flex items-center justify-center">
                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                        <path fill-rule="evenodd" d="M2 8c0 .414.336.75.75.75h8.69l-1.22 1.22a.75.75 0 1 0 1.06 1.06l2.5-2.5a.75.75 0 0 0 0-1.06l-2.5-2.5a.75.75 0 1 0-1.06 1.06l1.22 1.22H2.75A.75.75 0 0 0 2 8Z" clip-rule="evenodd" />
                    </svg>
                </span>
            </button>
        </div>

        <!-- Puntos de Navegación -->
        <div id="dots" class="flex justify-center mt-4 space-x-4">
            @foreach ($items as $index => $item)
            <button class="dot w-4 h-1 rounded-full bg-neutral-600" data-index="{{ $index }}"></button>
            @endforeach
        </div>
    </div>

    <div class="hidden md:grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
        @foreach ($items as $item)
        <a href="/{{ strtolower($mediaType) }}/{{ $item->id }}">
            <div class="p-2 rounded-xl border border-transparent transition-colors duration-200 hover:bg-neutral-950 hover:border-neutral-800 text-neutral-400 hover:text-neutral-300">
                <div class="relative aspect-[4/6] w-full overflow-hidden rounded-lg">
                    <img class="w-full h-full object-cover transition-transform duration-1000 transform hover:scale-[1.02]"
                        src="https://image.tmdb.org/t/p/original{{ $item->poster_path }}"
                        alt="{{ $item->name }}">
                </div>
                <p class="font-medium mt-1 truncate">{{ $item->name }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .dot-active {
        background-color: #9333ea;
    }
</style>

<script>
    const carousel = document.getElementById('carousel');
    const dots = document.querySelectorAll('.dot');
    const leftBtn = document.getElementById('leftBtn');
    const rightBtn = document.getElementById('rightBtn');

    let currentIndex = 0;

    function updateDots(index) {
        dots.forEach(dot => dot.classList.remove('dot-active'));
        dots[index].classList.add('dot-active');
    }

    function scrollToIndex(index) {
        const itemWidth = carousel.scrollWidth / dots.length;
        carousel.scrollTo({
            left: index * itemWidth,
        });
        currentIndex = index;
        updateDots(index);
    }

    // Scroll listeners
    carousel.addEventListener('scroll', () => {
        const itemWidth = carousel.scrollWidth / dots.length;
        currentIndex = Math.round(carousel.scrollLeft / itemWidth);
        updateDots(currentIndex);
    });

    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => scrollToIndex(index));
    });

    // Button navigation
    leftBtn.addEventListener('click', () => {
        if (currentIndex > 0) scrollToIndex(currentIndex - 1);
    });

    rightBtn.addEventListener('click', () => {
        if (currentIndex < dots.length - 1) scrollToIndex(currentIndex + 1);
    });

    // Initialize
    updateDots(0);
</script>