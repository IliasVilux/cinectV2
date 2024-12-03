<x-app-layout>
    <style>
        .grid {
            grid-auto-flow: row dense;
            grid-template-rows: masonry;
        }
    </style>

    <form method="GET" action="{{ route('serie.catalog') }}" class="max-w-7xl mx-auto flex md:justify-end mb-6">
        <div class="mx-2 md:mx-0">
            <label for="order_by" class="block mb-1 text-sm font-medium">Order by:</label>
            <select name="order_by" id="order_by" onchange="this.form.submit()" class="border text-sm rounded-md p-2 dark:bg-neutral-950 dark:border-neutral-800 dark:focus:ring-0 dark:focus:border-purple-500 w-48">
                <option value="">Relevance</option>
                <option value="name_asc" {{ request('order_by') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                <option value="name_desc" {{ request('order_by') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                <option value="air_date_asc" {{ request('order_by') == 'air_date_asc' ? 'selected' : '' }}>Air Date (Oldest First)</option>
                <option value="air_date_desc" {{ request('order_by') == 'air_date_desc' ? 'selected' : '' }}>Air Date (Newest First)</option>
            </select>
        </div>
    </form>

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
    </script>
</x-app-layout>