<x-app-layout>
    <div class="max-w-6xl mx-3 lg:mx-auto">
        <div x-data="{ showModal: false }">
            <button @click="showModal = true" class="bg-purple-600 border border-purple-500 py-2 px-4 rounded-md mb-12">
                <i class="fa-solid fa-plus"></i>
                Añadir nueva lista
            </button>

            <div x-show="showModal" x-cloak class="fixed inset-0 flex justify-center items-center bg-neutral-950 bg-opacity-80">
                <div class="w-96 p-4 bg-neutral-800 border-b border-neutral-700 rounded-md">
                    <form action="{{ route('favoriteLists.store') }}" method="POST">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Nombre de la lista')" />
                            <x-text-input id="name" class="block mt-1 w-full"
                                type="text"
                                name="name"
                                required autocomplete="List name" />
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="showModal = false" class="mt-4 ml-2 px-4 py-2">
                                Cerrar
                            </button>
                            <button type="submit" class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                Crear lista
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-2">
            @foreach($lists as $list)
            <div class="bg-neutral-950 rounded-lg px-12 py-6 border-b border-neutral-800">
                <h3 class="text-3xl text-purple-600 font-bold capitalize mb-4">{{ $list->name }}</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-7 gap-4 col-span-4">
                    @foreach ($list->allContents as $content)
                    @if ($content instanceof App\Models\Film)
                    <a href="{{ route('film.detail', $content->id) }}">
                        <img class="aspect-[4/6] w-full rounded-lg" src="https://image.tmdb.org/t/p/original{{ $content->poster_path }}" alt="{{ $content->name }}">
                    </a>
                    @elseif ($content instanceof App\Models\Serie)
                    <a href="{{ route('serie.detail', $content->id) }}">
                        <img class="aspect-[4/6] w-full rounded-lg" src="https://image.tmdb.org/t/p/original{{ $content->poster_path }}" alt="{{ $content->name }}">
                    </a>
                    @elseif ($content instanceof App\Models\Anime)
                    <a href="{{ route('anime.detail', $content->id) }}">
                        <img class="aspect-[4/6] w-full rounded-lg" src="{{ $content->poster_path }}" alt="{{ $content->name }}">
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>