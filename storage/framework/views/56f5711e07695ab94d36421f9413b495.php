<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  
  <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
  <link rel="shortcut icon" href="<?php echo e(asset('images/logo.png')); ?>">

  <title><?php echo $__env->yieldContent('title', 'PROCAFES'); ?></title>

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

  
  <style>
    .bg-procafes { background-color:#f2dd6c; }
    .btn-procafes-dark { background-color:#3e350e; color:#fff; }
    .btn-procafes-dark:hover { filter:brightness(1.1); }
    .btn-procafes-accent { background-color:#daad29; color:#3e350e; }
    .btn-procafes-accent:hover { filter:brightness(1.05); }
    .link-procafes { color:#3e350e; }
    .link-procafes:hover { color:#2c250a; }
  </style>

  
  <?php if(class_exists(\Livewire\Livewire::class)): ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

  <?php endif; ?>

  
  <script>
    window.Laravel = {
      csrfToken: "<?php echo e(csrf_token()); ?>",
      routes: {
        index: "<?php echo e(url('cart')); ?>",      // GET    /cart
        add:   "<?php echo e(url('cart/add')); ?>",  // POST   /cart/add
        base:  "<?php echo e(url('cart')); ?>",      // PATCH/DELETE /cart/{rowId}
        clear: "<?php echo e(url('cart')); ?>"       // DELETE /cart
      }
    };
  </script>

  <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-light">

  
  <?php if ($__env->exists('partials.header')) echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  
  <main class="<?php echo $__env->yieldContent('main_class', 'container py-4'); ?>">
    <?php if (! empty(trim($__env->yieldContent('content')))): ?>
      <?php echo $__env->yieldContent('content'); ?>   
    <?php else: ?>
      <?php echo e($slot ?? ''); ?>   
    <?php endif; ?>
  </main>

  
  <?php echo $__env->renderWhen(View::exists('partials.cart-offcanvas'), 'partials.cart-offcanvas', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1])); ?>

  
  <?php if(class_exists(\Livewire\Livewire::class)): ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

  <?php endif; ?>

  
  <script>
    window.App = {
      isAuth: <?php echo json_encode(auth()->check(), 15, 512) ?>,
      routes: {
        checkout: "<?php echo e(Route::has('checkout') ? route('checkout') : ''); ?>",
        login: "<?php echo e(route('login')); ?>"
      }
    };
  </script>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  
  <script src="<?php echo e(asset('js/cart.js')); ?>"></script>

  
  <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index:1080;"></div>

  <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\PC\Desktop\021025\PROCAFE_V1\resources\views/layouts/app.blade.php ENDPATH**/ ?>