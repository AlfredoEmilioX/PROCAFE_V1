<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <title><?php echo $__env->yieldContent('title','PROCAFES'); ?></title>

  <style>
    .bg-procafes { background-color: #f2dd6c; }
    .btn-procafes-dark { background-color:#3e350e; color:#fff; }
    .btn-procafes-dark:hover { filter: brightness(1.1); }
    .btn-procafes-accent { background-color:#daad29; color:#3e350e; }
    .btn-procafes-accent:hover { filter: brightness(1.05); }
    .link-procafes { color:#3e350e; }
    .link-procafes:hover { color:#2c250a; }
  </style>
</head>
<body class="bg-light">

  
  <?php echo $__env->make('partials.header-auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  
  <main class="container py-5">
    <?php echo e($slot); ?>

  </main>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\PC\Desktop\021025\PROCAFE_V1\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>