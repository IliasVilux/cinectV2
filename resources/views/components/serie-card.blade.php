<div class="break-inside-avoid rounded-[0.25rem] overflow-hidden relative group">
    @if ($serie->poster_path)
    <img class="w-full h-auto transition-transform duration-1000 transform group-hover:scale-105" src="https://image.tmdb.org/t/p/original{{$serie->poster_path}}" alt="{{ $serie->name }}">
    @else
        <div class="w-full h-80 bg-red-500"></div>
    @endif

    <div class="absolute h-1/2 bottom-0 left-0 right-0 bg-gradient-to-t from-[#000000] to-transparent text-white text-center p-5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
        <p class="w-full text-white text-center">
            {{ $serie->name }}
        </p>
    </div>
</div>