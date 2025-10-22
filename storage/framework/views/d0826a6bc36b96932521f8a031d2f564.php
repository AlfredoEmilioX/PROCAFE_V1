
<?php $__env->startSection('title','Panel | PROCAFES'); ?>

<?php $__env->startPush('styles'); ?>
<style>
  :root{
    --pcf-primary:#f2dd6c;
    --pcf-dark:#3e350e;
    --pcf-bg:#faf8ef;
  }
  body{ background:var(--pcf-bg); }
  .chip{
    display:flex; align-items:center; gap:.5rem;
    background:#fff; border:1px solid rgba(0,0,0,.08);
    padding:.65rem .8rem; border-radius:.75rem; white-space:nowrap;
  }
  .chip i{ color:var(--pcf-dark); }
  .stat-card{ border:1px solid rgba(0,0,0,.06); }
  .stat-ico{
    width:44px;height:44px;border-radius:.75rem;
    display:grid;place-items:center; background:var(--pcf-primary); color:var(--pcf-dark);
  }
  .btn-procafes{ background:var(--pcf-dark); color:#fff; border:0; }
  .btn-procafes:hover{ filter:brightness(1.08); color:#fff; }
  .link-muted{ color:#6c757d; text-decoration:none;}
  .link-muted:hover{ color:#495057; }
  .scroll-x{ overflow:auto; }
  .shadow-soft{ box-shadow:0 .5rem 1rem rgba(0,0,0,.06)!important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('admin-content'); ?>

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 mb-0">Panel</h1>

    <div class="d-flex gap-2">
      <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('home')); ?>" target="_blank">
        <i class="bi bi-shop-window me-1"></i> Ver tienda
      </a>

      <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-sm btn-procafes">
        <i class="bi bi-plus-lg me-1"></i> Nuevo producto
      </a>

      
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown">
          <i class="bi bi-download me-1"></i> Reportes
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item"
               href="<?php echo e(Route::has('admin.reports.revenue') ? route('admin.reports.revenue') : url('/admin/reports/revenue.csv')); ?>">
              <i class="bi bi-graph-up me-2"></i>Ingresos (últimos 12 meses)
            </a>
          </li>
          <li>
            <a class="dropdown-item"
               href="<?php echo e(Route::has('admin.reports.best') ? route('admin.reports.best') : url('/admin/reports/best-sellers.csv')); ?>">
              <i class="bi bi-trophy me-2"></i>Más vendidos (Top)
            </a>
          </li>
          <li>
            <a class="dropdown-item"
               href="<?php echo e(Route::has('admin.reports.products') ? route('admin.reports.products') : url('/admin/reports/products.csv')); ?>">
              <i class="bi bi-box-seam me-2"></i>Inventario de productos
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item"
               href="<?php echo e(Route::has('admin.reports.orders')
                      ? route('admin.reports.orders', ['from'=>now()->subDays(30)->toDateString(),'to'=>now()->toDateString()])
                      : url('/admin/reports/orders.csv?from='.now()->subDays(30)->toDateString().'&to='.now()->toDateString())); ?>">
              <i class="bi bi-receipt me-2"></i>Órdenes (últimos 30 días)
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  
  <div class="row g-3 mb-3">
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card stat-card shadow-soft">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="stat-ico"><i class="bi bi-coin fs-5"></i></div>
          <div class="flex-grow-1">
            <div class="small text-muted">Ingresos totales</div>
            <div class="fs-4 fw-bold">S/ <?php echo e(number_format($stats['revenue'] ?? 0, 2)); ?></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card stat-card shadow-soft">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="stat-ico"><i class="bi bi-bag-check fs-5"></i></div>
          <div class="flex-grow-1">
            <div class="small text-muted">Órdenes totales</div>
            <div class="fs-4 fw-bold"><?php echo e(number_format($stats['orders'] ?? 0)); ?></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card stat-card shadow-soft">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="stat-ico"><i class="bi bi-box-seam fs-5"></i></div>
          <div class="flex-grow-1">
            <div class="small text-muted">Productos totales</div>
            <div class="fs-4 fw-bold"><?php echo e(number_format($stats['products'] ?? 0)); ?></div>
          </div>
          <a class="link-muted small" href="<?php echo e(route('admin.products.index')); ?>">Crear nuevo</a>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3">
      <div class="card stat-card shadow-soft">
        <div class="card-body d-flex align-items-center gap-3">
          <div class="stat-ico"><i class="bi bi-people fs-5"></i></div>
          <div class="flex-grow-1">
            <div class="small text-muted">Clientes totales</div>
            <div class="fs-4 fw-bold"><?php echo e(number_format($stats['customers'] ?? 0)); ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="card shadow-soft mb-3">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h6 class="mb-0">Categorías</h6>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="link-muted small">Gestionar</a>
      </div>
      <div class="d-flex gap-2 scroll-x">
        <?php $__empty_1 = true; $__currentLoopData = $chips ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="chip"><i class="bi <?php echo e($c['i']); ?>"></i> <?php echo e($c['t']); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <span class="text-muted small">No hay categorías</span>
        <?php endif; ?>
      </div>
    </div>
  </div>

  
  <div class="row g-3">
    <div class="col-12 col-xl-7">
      <div class="card shadow-soft h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0">Reporte de ingresos</h6>
            <span class="badge" style="background:var(--pcf-primary); color:var(--pcf-dark)">Últimos 12 meses</span>
          </div>
          <canvas id="revChart" height="110"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12 col-xl-5">
      <div class="card shadow-soft h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0">Productos más vendidos</h6>
            <span class="small text-muted">Top 5</span>
          </div>
          <ul class="list-group list-group-flush">
            <?php $__empty_1 = true; $__currentLoopData = $best ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <li class="list-group-item d-flex align-items-center">
                <img class="rounded me-3" src="<?php echo e($b['img'] ?? 'https://via.placeholder.com/56'); ?>" width="48" height="48" alt="">
                <div class="flex-grow-1">
                  <div class="fw-semibold"><?php echo e($b['name']); ?></div>
                  <?php if(!empty($b['sku'])): ?><div class="text-muted small"><?php echo e($b['sku']); ?></div><?php endif; ?>
                </div>
                <div class="text-end small">
                  <?php if(!empty($b['price'])): ?><div>Precio: S/ <?php echo e(number_format($b['price'], 2)); ?></div><?php endif; ?>
                  <div>Unid.: <?php echo e((int)($b['orders'] ?? 0)); ?></div>
                  <div class="fw-semibold">Importe: S/ <?php echo e(number_format((float)($b['amount'] ?? 0), 2)); ?></div>
                </div>
              </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <li class="list-group-item text-muted small">Aún no hay ventas</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const PCF_DARK = getComputedStyle(document.documentElement).getPropertyValue('--pcf-dark').trim();
  const PCF_PRIM = getComputedStyle(document.documentElement).getPropertyValue('--pcf-primary').trim();

  const labels = <?php echo json_encode($labels ?? [], 15, 512) ?>;
  const values = <?php echo json_encode($revenue ?? [], 15, 512) ?>;

  const el = document.getElementById('revChart');
  if (el && labels.length && values.length) {
    new Chart(el, {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Ingresos',
          data: values,
          fill: true,
          borderColor: PCF_DARK,
          backgroundColor: PCF_PRIM + '55',
          tension: .35,
          pointRadius: 2,
          pointBackgroundColor: PCF_DARK,
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { grid: { color:'rgba(0,0,0,.05)' } },
          x: { grid: { display:false } }
        },
        plugins: { legend: { display:false } }
      }
    });
  }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC\Desktop\021025\PROCAFE_V1\resources\views/dashboard.blade.php ENDPATH**/ ?>