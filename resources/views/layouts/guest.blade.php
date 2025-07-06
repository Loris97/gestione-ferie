<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Gestione Ferie - login</title>

        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <!-- Scripts -->
        @vite(['resources/js/app.js'])
    </head>
    <body class="min-vh-100 d-flex flex-column">
        <div class="flex-grow-1">
            <div>
                {{ $slot }}
            </div>
        </div>
        @include('partials.footer')
    </body>
</html>
