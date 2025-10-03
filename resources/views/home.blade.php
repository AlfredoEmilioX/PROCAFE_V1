<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100">
    @include('partials.header')

    <main class="container py-4 flex-grow-1">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <small>&copy; {{ date('Y') }} - Mi Tienda</small>
    </footer>
</body>
</html>
