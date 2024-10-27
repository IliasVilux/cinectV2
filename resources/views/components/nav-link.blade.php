@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-purple font-medium leading-5 text-white dark:text-gray-100 focus:outline-none focus:border-purple-light transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-purple hover:border-purple-light dark:hover:text-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-purple dark:focus:text-gray-300 focus:border-purple-light dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
