<header class="bg-procafes shadow-sm">
  <div class="container d-flex align-items-center justify-content-between py-2">

    {{-- Logo y nombre --}}
    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
        <img src="{{ asset('images/logo.png') }}" alt="PROCAFES" width="55" height="55" class="rounded">
        <span class="fw-bold ms-2 text-dark fs-5">PROCAFES</span>
      </a>

      {{-- Enlaces nuevos --}}
      <nav class="ms-4 d-none d-md-flex align-items-center gap-3">
        <a href="{{ url('/nosotros') }}" class="text-dark text-decoration-none fw-medium">Nosotros</a>
        <a href="{{ url('/ubicanos') }}" class="text-dark text-decoration-none fw-medium">Ubícanos</a>
      </nav>
    </div>

    {{-- Buscador --}}
    <form method="GET" action="{{ route('home') }}" class="d-none d-md-flex align-items-center flex-grow-1 mx-4" style="max-width:480px;">
      <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Buscar productos...">
      <button type="submit" class="btn btn-procafes-accent btn-sm ms-1">
        <i class="bi bi-search"></i>
      </button>
    </form>

    {{-- Iconos / usuario --}}
    <div class="d-flex align-items-center gap-3">

      {{-- Wishlist --}}
      <a href="{{ route('wishlist.index') }}" class="position-relative text-dark text-decoration-none">
        <i class="bi bi-heart fs-5"></i>
      </a>

      {{-- Carrito (único, correcto) --}}
      @includeIf('partials.cart-button')

      {{-- Autenticación --}}
      @guest
        <a href="{{ route('login') }}" class="btn btn-dark btn-sm">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Registrarse</a>
      @else
        <span class="small text-dark me-2">Hola, {{ Auth::user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-outline-dark btn-sm">Salir</button>
        </form>
      @endguest

    </div>
  </div>
</header>
