<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- CSRF para forms/AJAX --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Bootstrap CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <title>@yield('title', 'PROCAFES')</title>

  {{-- Estilos base --}}
  <style>
    .bg-procafes { background-color: #f2dd6c; }
    .btn-procafes-dark { background-color:#3e350e; color:#fff; }
    .btn-procafes-dark:hover { filter: brightness(1.1); }
    .btn-procafes-accent { background-color:#daad29; color:#3e350e; }
    .btn-procafes-accent:hover { filter: brightness(1.05); }
    .link-procafes { color:#3e350e; }
    .link-procafes:hover { color:#2c250a; }
  </style>

  {{-- Livewire (styles) --}}
  @if (class_exists(\Livewire\Livewire::class))
    @livewireStyles
  @endif

  {{-- Rutas del carrito para JS --}}
  <script>
    window.Laravel = {
      csrfToken: "{{ csrf_token() }}",
      routes: {
        index: "{{ url('cart') }}",      // GET    /cart
        add:   "{{ url('cart/add') }}",  // POST   /cart/add
        base:  "{{ url('cart') }}",      // PATCH/DELETE /cart/{rowId}
        clear: "{{ url('cart') }}"       // DELETE /cart
      }
    };
  </script>

  {{-- Vite: tu app (no importes cart.js aquí) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Slot para CSS extra de vistas --}}
  @stack('styles')
</head>
<body class="bg-light">

  {{-- Header (omitible desde vistas con @section('hide-header')) --}}
  @hasSection('hide-header')
    {{-- header oculto --}}
  @else
    @includeWhen(View::exists('partials.header'), 'partials.header')
  @endif

  {{-- Contenido principal --}}
  <main class="@yield('main_class', 'container py-4')">
    @yield('content')
  </main>

  {{-- Offcanvas del carrito (panel) --}}
  @includeWhen(View::exists('partials.cart-offcanvas'), 'partials.cart-offcanvas')

  {{-- Livewire (scripts) --}}
  @if (class_exists(\Livewire\Livewire::class))
    @livewireScripts
  @endif

  {{-- Exponer estado de sesión y rutas útiles al JS del carrito --}}
  <script>
    window.App = {
      isAuth: @json(auth()->check()),
      routes: {
        checkout: "{{ Route::has('checkout') ? route('checkout') : '' }}",
        login: "{{ route('login') }}"
      }
    };
  </script>

  {{-- Bootstrap JS (global, para window.bootstrap en scripts de /public) --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Carrito (script clásico en /public) --}}
  <script src="{{ asset('js/cart.js') }}"></script>

  {{-- Contenedor de toasts (si los usas) --}}
  <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index:1080;"></div>

  {{-- JS extra desde vistas --}}
  @stack('scripts')
</body>
</html>
