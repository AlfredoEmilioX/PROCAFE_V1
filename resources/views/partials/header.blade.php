<header class="sticky-top">
  <nav class="navbar navbar-expand-lg" style="background-color: #f2dd6c;">
    <div class="container">

      {{-- Logo + Marca --}}
      <a class="navbar-brand d-flex align-items-center fw-bold text-dark" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="48" class="me-2">
        PROCAFES
      </a>

      {{-- Toggler --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
              aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- Contenido --}}
      <div class="collapse navbar-collapse" id="mainNavbar">

        {{-- Buscador al centro (opcional) --}}
        <form class="d-flex mx-auto my-3 my-lg-0" role="search" style="max-width: 520px; width: 100%;">
          <input class="form-control me-2" type="search" placeholder="Buscar productos..." aria-label="Buscar">
          <button class="btn" type="submit" style="background-color:#daad29; color:white;">
            <i class="bi bi-search"></i>
          </button>
        </form>

        {{-- Acciones derecha --}}
        <div class="d-flex align-items-center gap-3">

          {{-- (Opcional) Wishlist: usa '#' si no existe la ruta aún --}}
          @php
            $wishlistUrl = \Illuminate\Support\Facades\Route::has('wishlist.index') ? route('wishlist.index') : '#';
            $wishlistCount = (int) session('wishlist_count', 0);
            $cartCount = (int) session('cart_count', 0);
          @endphp

          <a class="text-decoration-none position-relative d-none d-lg-inline" href="{{ $wishlistUrl }}">
            <i class="bi bi-heart fs-4" style="color:#3e350e;"></i>
            @if($wishlistCount > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $wishlistCount }}
              </span>
            @endif
          </a>

          {{-- Carrito --}}
          <a class="text-decoration-none position-relative" href="{{ route('cart.index') }}">
            <i class="bi bi-cart fs-4" style="color:#3e350e;"></i>
            @if($cartCount > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $cartCount }}
              </span>
            @endif
          </a>

          {{-- SALUDO + Auth --}}
          @auth
            @php
              $firstName = trim(explode(' ', auth()->user()->name)[0] ?? auth()->user()->name);
            @endphp

            {{-- Saludo visible desde md+ --}}
            <span class="d-none d-md-inline text-dark fw-semibold">
              Hola, {{ $firstName }}!
            </span>

            {{-- Menú de usuario --}}
            <div class="dropdown">
              <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                {{-- Para pantallas pequeñas, repite el saludo dentro del menú --}}
                <li class="d-md-none px-3 py-2 text-muted">Hola, {{ $firstName }}!</li>
                <li><a class="dropdown-item" href="{{ route('profile') }}">Mi perfil</a></li>
                @if(auth()->user()->role === 'admin')
                  <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                @else
                  <li><a class="dropdown-item" href="{{ route('customer.products') }}">Mis productos</a></li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button class="dropdown-item" type="submit">Cerrar sesión</button>
                  </form>
                </li>
              </ul>
            </div>
          @endauth

          @guest
            <a class="btn btn-sm" href="{{ route('login') }}"
               style="background-color:#3e350e; color:white;">Iniciar sesión</a>
            @if (Route::has('register'))
              <a class="btn btn-sm" href="{{ route('register') }}"
                 style="background-color:#daad29; color:#3e350e;">Registrarse</a>
            @endif
          @endguest

        </div>
      </div>
    </div>
  </nav>
</header>
