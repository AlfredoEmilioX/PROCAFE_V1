<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- CSRF para formularios/AJAX --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'PROCAFES')</title>

  {{-- Favicon / Logo --}}
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

  {{-- Bootstrap + Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- Vite (si lo usas) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('styles')
</head>
<body class="bg-light">

  {{-- Header público --}}
  @includeIf('partials.header')

  {{-- Contenido principal --}}
  <main class="@yield('main_class', 'container py-4')">
    @yield('content')
    {{ $slot ?? '' }}
  </main>

  {{-- Footer opcional --}}
  @hasSection('footer')
    @yield('footer')
  @endif

  {{-- Bootstrap JS (necesario para dropdowns) --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  @stack('scripts')

</body>
</html>
