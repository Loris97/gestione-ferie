<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Gestione Ferie')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('partials.navbar')

    <div class="container">
        @yield('content')
    </div>
    @include('partials.footer')
</body>
</html>
