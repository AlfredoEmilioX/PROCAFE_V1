
<?php $__env->startSection('title', 'Checkout | PROCAFES'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
  <h4 class="mb-3">Finalizar compra</h4>

  <?php if(session('info')): ?>
    <div class="alert alert-info"><?php echo e(session('info')); ?></div>
  <?php endif; ?>

  <div class="row g-3">
    
    <div class="col-12 col-lg-7">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <form action="<?php echo e(route('checkout.process')); ?>" method="POST" class="vstack gap-3">
            <?php echo csrf_field(); ?>

            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label">Nombre y apellidos</label>
                <input name="name" class="form-control"
                       value="<?php echo e(old('name', $user->name ?? '')); ?>" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input name="phone" class="form-control"
                       value="<?php echo e(old('phone')); ?>" required>
              </div>
            </div>

            <div>
              <label class="form-label">Dirección de entrega</label>
              <input name="address" class="form-control"
                     value="<?php echo e(old('address')); ?>" required>
            </div>

            <div>
              <label class="form-label d-block">Método de pago</label>
              <div class="d-flex gap-3 flex-wrap">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment" id="p1"
                         value="card" <?php echo e(old('payment','card') === 'card' ? 'checked' : ''); ?>>
                  <label class="form-check-label" for="p1">
                    <i class="bi bi-credit-card me-1"></i> Tarjeta
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment" id="p2"
                         value="cash" <?php echo e(old('payment') === 'cash' ? 'checked' : ''); ?>>
                  <label class="form-check-label" for="p2">
                    <i class="bi bi-cash me-1"></i> Efectivo
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment" id="p3"
                         value="transfer" <?php echo e(old('payment') === 'transfer' ? 'checked' : ''); ?>>
                  <label class="form-check-label" for="p3">
                    <i class="bi bi-bank me-1"></i> Transferencia
                  </label>
                </div>
              </div>
            </div>

            <button class="btn btn-procafes-dark btn-lg w-100">
              Confirmar compra
            </button>
          </form>
        </div>
      </div>
    </div>

    
    <div class="col-12 col-lg-5">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h6 class="mb-3">Resumen</h6>

          <ul class="list-group list-group-flush mb-3">
            <?php $__currentLoopData = $cart['items'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="list-group-item d-flex align-items-center">
                <img src="<?php echo e($it['image'] ?? 'https://via.placeholder.com/48'); ?>"
                     width="48" height="48" class="rounded me-2" alt="Producto">
                <div class="flex-grow-1">
                  <div class="fw-semibold"><?php echo e($it['name']); ?></div>
                  <div class="small text-muted">x<?php echo e($it['qty']); ?></div>
                </div>
                <div class="fw-semibold">
                  S/ <?php echo e(number_format($it['price'] * $it['qty'], 2)); ?>

                </div>
              </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>

          <div class="d-flex justify-content-between">
            <span>Subtotal</span>
            <span>S/ <?php echo e(number_format($cart['total'] ?? 0, 2)); ?></span>
          </div>
          <div class="d-flex justify-content-between small text-muted">
            <span>Envío</span>
            <span>Calculado al confirmar</span>
          </div>
          <hr>
          <div class="d-flex justify-content-between fw-bold">
            <span>Total</span>
            <span>S/ <?php echo e(number_format($cart['total'] ?? 0, 2)); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC\Desktop\021025\PROCAFE_V1\resources\views/checkout/index.blade.php ENDPATH**/ ?>