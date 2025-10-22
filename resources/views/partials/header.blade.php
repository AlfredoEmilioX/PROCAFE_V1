<header class="bg-procafes shadow-sm">
  <div class="container d-flex align-items-center justify-content-between py-2">

    {{-- Logo + enlaces principales --}}
    <div class="d-flex align-items-center gap-3">
      <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
        <img src="{{ asset('images/logo.png') }}" alt="PROCAFES" width="40" height="40" class="rounded">
        <span class="fw-bold ms-2 text-dark fs-5">PROCAFES</span>
      </a>

      <nav class="ms-3 d-none d-md-flex align-items-center gap-3">
        <a href="{{ route('nosotros') }}" class="text-dark text-decoration-none fw-medium">Nosotros</a>
        <a href="{{ route('ubicanos') }}" class="text-dark text-decoration-none fw-medium">Ubícanos</a>
      </nav>
    </div>

    {{-- Buscador --}}
    <form method="GET" action="{{ route('home') }}"
          class="d-none d-md-flex align-items-center flex-grow-1 mx-4" style="max-width:480px;">
      <input type="text" name="q" value="{{ request('q') }}"
             class="form-control form-control-sm" placeholder="Buscar productos…">
      <button type="submit" class="btn btn-warning btn-sm ms-1">
        <i class="bi bi-search"></i>
      </button>
    </form>

    {{-- Acciones (wishlist, carrito, usuario) --}}
    <div class="d-flex align-items-center gap-3">

      {{-- Wishlist --}}
      <a href="{{ route('wishlist.index') }}" class="position-relative text-dark text-decoration-none" title="Favoritos">
        <i class="bi bi-heart fs-5"></i>
      </a>

      {{-- Carrito --}}
      @includeIf('partials.cart-button')

      {{-- Usuario --}}
      @guest
        <a href="{{ route('login') }}" class="btn btn-dark btn-sm">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="btn btn-warning btn-sm">Registrarse</a>
      @else
        <div class="dropdown">
          <button class="btn btn-outline-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Hola, {{ Auth::user()->name ?? 'Usuario' }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            @if((Auth::user()->role ?? null) === 'admin')
              <li>
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                  <i class="bi bi-speedometer2 me-2"></i> Panel admin
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
            @else
              <li>
                <a class="dropdown-item" href="{{ route('customer.dashboard') }}">
                  <i class="bi bi-person me-2"></i> Mi cuenta
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
            @endif

            {{-- Cerrar sesión (POST + CSRF) --}}
            <li>
              <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                  <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                </button>
              </form>
            </li>
          </ul>
        </div>
      @endguest

    </div>
  </div>
</header>
