<x-app-layout>
<x-home.media-list title="Series" :items="$series" mediaType="serie" />
<x-home.media-list title="Películas" :items="$films" mediaType="película" />
<x-home.media-list title="Animes" :items="$animes" mediaType="anime" />
</x-app-layout>