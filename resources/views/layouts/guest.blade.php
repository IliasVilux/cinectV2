<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-100 dark:bg-neutral-950 text-neutral-950 dark:text-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 mx-4">
            <div>
                <a href="/">
                    <x-application-logo class="size-20 fill-current text-purple-600" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-neutral-800 shadow-md overflow-hidden rounded-lg border-b border-neutral-700">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
