<div class="max-w-7xl mx-auto mb-12">
    <div class="flex justify-between items-center mx-4 mb-2">
        <h2 class="text-3xl font-bold text-black capitalize dark:text-gray-200">{{ $title }}</h2>
        <a href="/{{ strtolower($title) }}" class="text-md font-bold hover:underline text-gray-200">Mostrar todos</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
        @foreach ($items as $item)
        <div class="p-3 rounded-lg transition-colors duration-200 hover:bg-neutral-800">
            <div class="relative aspect-[4/5] w-full overflow-hidden rounded-lg">
                <img class="w-full h-full object-cover transition-transform duration-1000 transform hover:scale-[1.02]"
                    src="https://image.tmdb.org/t/p/original{{ $item->poster_path }}"
                    alt="{{ $item->name }}">
            </div>
            <p class="text-neutral-400 font-medium mt-1 truncate">{{ $item->name }}</p>
        </div>
        @endforeach
    </div>
</div>