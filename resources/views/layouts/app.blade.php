<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/js/app.js'])
</head>
<body>
    @include('partials.header')

    <main class="container py-4">
        @yield('content')
    </main>
</body>
</html>
