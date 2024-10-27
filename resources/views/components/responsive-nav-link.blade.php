@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block mx-2 my-2 px-4 py-2 rounded-md text-start text-indigo-700 dark:text-indigo-100 bg-indigo-50 dark:bg-purple-700 focus:outline-none focus:bg-indigo-100 dark:focus:bg-purple-600 transition duration-150 ease-in-out'
            : 'block mx-2 my-2 px-4 py-2 rounded-md text-start text-purple-600 dark:text-gray-400 hover:text-gray-100 dark:hover:text-gray-100 hover:bg-purple-600 focus:bg-zinc-900 dark:focus:bg-purple-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
