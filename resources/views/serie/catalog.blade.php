<x-app-layout>
    <style>
        .grid {
            grid-auto-flow: row dense;
            grid-template-rows: masonry;
        }
    </style>

    <div class="max-w-7xl mx-2 xl:mx-auto md:flex justify-between mb-6">
        <form id="search-form" method="GET" action="{{ route('serie.catalog') }}">
            @csrf
            <input type="text"
                name="search" id="search"
                placeholder="Buscar..."
                value="{{ request('search') }}"
                class="border text-sm rounded-lg block w-full md:w-72 h-auto p-2 dark:bg-neutral-950 dark:border-neutral-800 dark:placeholder-gray-400 dark:focus:ring-0 dark:focus:border-purple-500">
        </form>

        <form method="GET" action="{{ route('serie.catalog') }}">
            @csrf
            <select name="order_by" id="order_by" onchange="this.form.submit()"
                class="border text-sm rounded-md p-2 dark:bg-neutral-950 dark:border-neutral-800 dark:focus:ring-0 dark:focus:border-purple-500 w-full md:w-48">
                <option value="">Relevancia</option>
                <option value="name_asc" {{ request('order_by') == 'name_asc' ? 'selected' : '' }}>Nombre (A-Z)</option>
                <option value="name_desc" {{ request('order_by') == 'name_desc' ? 'selected' : '' }}>Nombre (Z-A)</option>
                <option value="air_date_asc" {{ request('order_by') == 'air_date_asc' ? 'selected' : '' }}>Fecha de emisión (Más antigua primero)</option>
                <option value="air_date_desc" {{ request('order_by') == 'air_date_desc' ? 'selected' : '' }}>Fecha de emisión (Más reciente primero)</option>
            </select>
        </form>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2 auto-rows-auto max-w-7xl mx-2 xl:mx-auto">
        @foreach($series as $serie)
        <x-serie-card :$serie />
        @endforeach
    </div>

    <script>
        document.getElementById('order_by').addEventListener('change', function() {
            if (this.value === '') {
                window.location.href = '/series';
            }
        });

        document.getElementById('search-form').addEventListener('submit', function(event) {
            const searchInput = document.getElementById('search');
            if (searchInput.value.trim() === '') {
                // Prevenir que se envíe el formulario si el campo de búsqueda está vacío
                event.preventDefault();
                window.location.href = '/series'; // Redirigir a la página principal de series sin parámetros
            }
        });
    </script>
</x-app-layout>