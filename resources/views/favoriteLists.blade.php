<x-app-layout>
    <div class="max-w-6xl mx-3 lg:mx-auto">
        <div x-data="{ showModal: false }">
            <button @click="showModal = true" class="bg-purple-600 border border-purple-500 py-2 px-4 rounded-md mb-12">
                <i class="fa-solid fa-plus"></i>
                Añadir nueva lista
            </button>

            <div x-show="showModal" x-cloak class="fixed inset-0 flex justify-center items-center bg-neutral-950 bg-opacity-80">
                <div class="w-96 p-4 bg-neutral-900 border-b border-neutral-800 rounded-md">
                    <form action="{{ route('favoriteLists.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-white">Nombre de la lista</label>
                            <input type="text" id="name" name="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                        </div>

                        <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">
                            Crear lista
                        </button>
                    </form>

                    <button type="button" @click="showModal = false" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">
                        Cerrar
                    </button>
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