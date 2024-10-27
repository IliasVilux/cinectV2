@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-purple-600 font-medium leading-5 text-gray-700 dark:text-gray-100 focus:outline-none focus:border-purple-300 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-purple-600 hover:border-purple-300 dark:hover:text-gray-300 dark:hover:border-purple-600 focus:outline-none focus:text-purple-600 dark:focus:text-gray-300 focus:border-purple-300 dark:focus:border-purple-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
