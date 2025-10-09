<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Panel Admin - PROCAFES')</title>

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #212529;
      color: #fff;
      display: flex;
      flex-direction: column;
      transition: all 0.3s ease;
    }
    .sidebar .brand {
      font-size: 1.2rem;
      font-weight: bold;
      text-align: center;
      padding: 1rem;
      background-color: #343a40;
      border-bottom: 1px solid #495057;
    }
    .sidebar .user-info {
      text-align: center;
      padding: 1.2rem 0;
      border-bottom: 1px solid #495057;
    }
    .sidebar .user-info img {
      width: 65px;
      height: 65px;
      border-radius: 50%;
      margin-bottom: 10px;
    }
    .sidebar .user-info h6 {
      color: #fff;
      margin-bottom: 0;
    }
    .sidebar .nav-link {
      color: #adb5bd;
      padding: 10px 20px;
      font-size: 15px;
    }
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: #495057;
      color: #fff;
    }
    .sidebar .nav-link i {
      margin-right: 8px;
    }
    .content-wrapper {
      margin-left: 250px;
      padding: 2rem;
      min-height: 100vh;
      background-color: #f8f9fa;
    }
    .logout-btn {
      margin-top: auto;
      color: #ff7675 !important;
      border-top: 1px solid #495057;
    }
    .logout-btn:hover {
      background-color: #dc3545;
      color: #fff !important;
    }
  </style>
</head>
@stack('scripts')

<body>
  {{-- Sidebar --}}
  <aside class="sidebar">
    <div class="brand">PROCAFES ADMIN</div>

    <div class="user-info">
      <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Usuario">
      <h6>{{ auth()->user()->name ?? 'Administrador' }}</h6>
      <small class="text-muted">{{ auth()->user()->role ?? '' }}</small>
    </div>

    <nav class="nav flex-column mt-3">
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
         href="{{ route('dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>

      <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
         href="{{ route('admin.users.index') }}">
        <i class="bi bi-people"></i> Clientes
      </a>

      <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}"
         href="{{ route('admin.products.index') }}">
        <i class="bi bi-box-seam"></i> Productos
      </a>

      <a class="nav-link {{ request()->is('admin/brands*') ? 'active' : '' }}"
         href="{{ route('admin.brands.index') }}">
        <i class="bi bi-bag"></i> Marcas
      </a>

      <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}"
         href="{{ route('admin.categories.index') }}">
        <i class="bi bi-tags"></i> Categorías
      </a>
    </nav>

    <form action="{{ route('logout') }}" method="POST" class="mt-auto">
      @csrf
      <button type="submit" class="nav-link logout-btn w-100 text-start border-0 bg-transparent">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
      </button>
    </form>
  </aside>

  {{-- Contenido principal --}}
  <main class="content-wrapper">
    <div class="container-fluid">
      @yield('admin-content')
    </div>
  </main>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
