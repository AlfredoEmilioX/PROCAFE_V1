<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $__env->yieldContent('title','Panel Admin - PROCAFES'); ?></title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { background:#f8f9fa; }
    .topbar { background:#F2DD6C; }
    .sticky-topbar { position:sticky; top:0; z-index:1030; }
    .list-group .active { background:#212529; border-color:#212529; }
  </style>
</head>
<body>

  <!-- BARRA SUPERIOR AMARILLA -->
  <div class="topbar sticky-topbar border-bottom py-2">
    <div class="container d-flex align-items-center justify-content-between gap-3">
      <a href="<?php echo e(route('admin.dashboard')); ?>" class="d-inline-flex align-items-center gap-2 text-decoration-none">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PROCAFES" style="height:32px">
        <strong class="text-dark">PROCAFES</strong>
        <span class="badge text-bg-warning text-dark">Admin</span>
      </a>

      <form class="d-none d-md-flex" role="search" style="max-width:640px; width:100%;">
        <div class="input-group">
          <input class="form-control" type="search" placeholder="Buscar en el panel…">
          <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
        </div>
      </form>

      <div class="d-flex align-items-center gap-3">
        <a class="text-decoration-none text-dark" href="<?php echo e(route('home')); ?>"><i class="bi bi-shop-window me-1"></i>Ver tienda</a>
        <div class="dropdown">
          <button class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Hola, <?php echo e(auth()->user()->name ?? 'Administrador'); ?>

          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li class="px-3 py-2 text-muted small">Rol: <?php echo e(auth()->user()->role ?? '-'); ?></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="<?php echo e(route('logout')); ?>" method="POST" class="px-3 pb-2">
                <?php echo csrf_field(); ?>
                <button class="btn btn-sm btn-danger w-100"><i class="bi bi-box-arrow-right me-1"></i>Salir</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- LAYOUT: SIDEBAR + CONTENIDO -->
  <div class="container my-3">
    <div class="row g-3">
      <!-- SIDEBAR -->
      <aside class="col-12 col-md-3 col-lg-2">
        <div class="list-group shadow-sm rounded-3">
          <a href="<?php echo e(route('admin.dashboard')); ?>"
             class="list-group-item list-group-item-action <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
          </a>
          <a href="<?php echo e(route('admin.products.index')); ?>"
             class="list-group-item list-group-item-action <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
            <i class="bi bi-box-seam me-2"></i> Productos
          </a>
          <a href="<?php echo e(route('admin.categories.index')); ?>"
             class="list-group-item list-group-item-action <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
            <i class="bi bi-tags me-2"></i> Categorías
          </a>
          <a href="<?php echo e(route('admin.brands.index')); ?>"
             class="list-group-item list-group-item-action <?php echo e(request()->routeIs('admin.brands.*') ? 'active' : ''); ?>">
            <i class="bi bi-bookmark-star me-2"></i> Marcas
          </a>
          <a href="<?php echo e(route('admin.users.index')); ?>"
             class="list-group-item list-group-item-action <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
            <i class="bi bi-people me-2"></i> Usuarios
          </a>
        </div>
      </aside>

      <!-- CONTENIDO -->
      <main class="col-12 col-md-9 col-lg-10">
        <?php echo $__env->yieldContent('admin-content'); ?>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
                                                                              <?php /**PATH C:\Users\PC\Desktop\021025\PROCAFE_V1\resources\views/layouts/admin.blade.php ENDPATH**/ ?>