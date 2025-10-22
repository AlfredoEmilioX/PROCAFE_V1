<header class="bg-procafes shadow-sm">
  <div class="container d-flex align-items-center justify-content-between py-2">

    
    <div class="d-flex align-items-center gap-3">
      <a href="<?php echo e(route('home')); ?>" class="d-flex align-items-center text-decoration-none">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="PROCAFES" width="40" height="40" class="rounded">
        <span class="fw-bold ms-2 text-dark fs-5">PROCAFES</span>
      </a>

      <nav class="ms-3 d-none d-md-flex align-items-center gap-3">
        <a href="<?php echo e(route('nosotros')); ?>" class="text-dark text-decoration-none fw-medium">Nosotros</a>
        <a href="<?php echo e(route('ubicanos')); ?>" class="text-dark text-decoration-none fw-medium">Ubícanos</a>
      </nav>
    </div>

    
    <form method="GET" action="<?php echo e(route('home')); ?>"
          class="d-none d-md-flex align-items-center flex-grow-1 mx-4" style="max-width:480px;">
      <input type="text" name="q" value="<?php echo e(request('q')); ?>"
             class="form-control form-control-sm" placeholder="Buscar productos…">
      <button type="submit" class="btn btn-warning btn-sm ms-1">
        <i class="bi bi-search"></i>
      </button>
    </form>

    
    <div class="d-flex align-items-center gap-3">

      
      <a href="<?php echo e(route('wishlist.index')); ?>" class="position-relative text-dark text-decoration-none" title="Favoritos">
        <i class="bi bi-heart fs-5"></i>
      </a>

      
      <?php if ($__env->exists('partials.cart-button')) echo $__env->make('partials.cart-button', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      
      <?php if(auth()->guard()->guest()): ?>
        <a href="<?php echo e(route('login')); ?>" class="btn btn-dark btn-sm">Iniciar sesión</a>
        <a href="<?php echo e(route('register')); ?>" class="btn btn-warning btn-sm">Registrarse</a>
      <?php else: ?>
        <div class="dropdown">
          <button class="btn btn-outline-dark btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Hola, <?php echo e(Auth::user()->name ?? 'Usuario'); ?>

          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <?php if((Auth::user()->role ?? null) === 'admin'): ?>
              <li>
                <a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                  <i class="bi bi-speedometer2 me-2"></i> Panel admin
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
            <?php else: ?>
              <li>
                <a class="dropdown-item" href="<?php echo e(route('customer.dashboard')); ?>">
                  <i class="bi bi-person me-2"></i> Mi cuenta
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
            <?php endif; ?>

            
            <li>
              <form action="<?php echo e(route('logout')); ?>" method="POST" class="px-3 py-1">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                  <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
                </button>
              </form>
            </li>
          </ul>
        </div>
      <?php endif; ?>

    </div>
  </div>
</header>
<?php /**PATH C:\Users\PC\Desktop\021025\PROCAFE_V1\resources\views/partials/header.blade.php ENDPATH**/ ?>