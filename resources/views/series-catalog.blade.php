<x-app-layout>
    <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-6 gap-3 space-y-3 max-w-7xl mx-2 xl:mx-auto">
        @foreach($series as $serie)
            <x-serie-card :$serie />
        @endforeach
    </div>
</x-app-layout>