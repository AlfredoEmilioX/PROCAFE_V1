<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle JS (incluye Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg" style="background-color: #f2dd6c;">
  <div class="container-fluid">

    <!-- Logo + Empresa -->
    <a class="navbar-brand d-flex align-items-center fw-bold text-dark" href="#">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="60">  
         PROCAFES
    </a>

    <!-- Toggler para móviles -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenido -->
    <div class="collapse navbar-collapse" id="mainNavbar">

      <!-- Buscador al centro -->
      <form class="d-flex mx-auto" role="search" style="max-width: 500px; width: 100%;">
        <input class="form-control me-2" type="search" placeholder="Buscar productos..." aria-label="Buscar">
        <button class="btn" type="submit" style="background-color:#daad29; color:white;">
          <i class="bi bi-search"></i>
        </button>
      </form>

      <!-- Íconos y auth -->
      <ul class="navbar-nav ms-auto d-flex align-items-center">

        <!-- Lista de deseos -->
        <li class="nav-item me-3">
          <a class="nav-link" href="#">
            <i class="bi bi-heart" style="font-size: 1.5rem; color:#3e350e;"></i>
          </a>
        </li>

        <!-- Carrito -->
        <li class="nav-item me-3">
          <a class="nav-link position-relative" href="{{ route('cart.index') }}">
            <i class="bi bi-cart" style="font-size: 1.5rem; color:#3e350e;"></i>
            @if(session('cart_count', 0) > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ session('cart_count') }}
              </span>
            @endif
          </a>
        </li>

        <!-- Autenticación -->
        @guest
          <li class="nav-item me-2">
            <a class="btn btn-sm" href="{{ route('login') }}" 
               style="background-color:#3e350e; color:white;">Iniciar sesión</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-sm" href="{{ route('register') }}" 
               style="background-color:#daad29; color:#3e350e;">Registrarse</a>
          </li>
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <form action="{{ route('logout') }}" method="POST">@csrf
                  <button class="dropdown-item" type="submit">Cerrar sesión</button>
                </form>
              </li>
            </ul>
          </li>
        @endguest

      </ul>
    </div>
  </div>
</nav>
