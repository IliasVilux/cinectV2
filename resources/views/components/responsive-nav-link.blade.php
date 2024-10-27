@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block mx-2 my-2 px-4 py-2 rounded-md text-start text-indigo-700 dark:text-indigo-100 bg-indigo-50 dark:bg-black focus:outline-none focus:bg-indigo-100 dark:focus:bg-purple transition duration-150 ease-in-out'
            : 'block mx-2 my-2 px-4 py-2 rounded-md text-start text-purple dark:text-gray-400 hover:text-gray-100 dark:hover:text-gray-100 hover:bg-purple focus:bg-black dark:focus:bg-purple-light transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
