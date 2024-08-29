<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'shopp') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-dark antialiased">
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center bg-light py-6">
        <div class="mb-4">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-secondary" />
            </a>
        </div>
        <div class="container p-5 d-flex justify-content-center">
            <div class="w-50 mw-sm mt-4 p-4 bg-white shadow-sm rounded">
                {{ $slot }}
            </div>
        </div>
    </div>
    </body>
</html>
