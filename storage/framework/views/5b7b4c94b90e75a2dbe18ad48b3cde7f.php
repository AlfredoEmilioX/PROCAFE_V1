<?php
  // Total basado en la sesión (tu JS actualizará #cartTotal dinámicamente)
  $cartItems = session('cart', []);
  $serverTotal = collect($cartItems)->sum(function($i){
      return (float)($i['price'] ?? 0) * (int)($i['quantity'] ?? 1);
  });
?>

<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="cartOffcanvasLabel">Tu carrito</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
  </div>

  <div class="offcanvas-body d-flex flex-column p-0">
    
    <div id="cartItems"
         class="list-group list-group-flush mb-0 flex-grow-1"
         style="min-height:120px; max-height:60vh; overflow:auto;"></div>

    
    <style>
      .offcanvas-footer{
        position: sticky;
        bottom: 0;
        background: #fff;
        border-top: 1px solid rgba(0,0,0,.1);
        box-shadow: 0 -2px 8px rgba(0,0,0,.04);
        z-index: 3;
      }
    </style>

    <div class="offcanvas-footer p-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="fw-semibold">Total</span>
        <span id="cartTotal" class="fw-bold">S/ <?php echo e(number_format($serverTotal, 2)); ?></span>
      </div>

      <div class="d-grid gap-2">
        
        <button id="btnClearCart" class="btn btn-outline-secondary w-100"
                <?php if($serverTotal <= 0): echo 'disabled'; endif; ?>>Vaciar</button>

        
        <?php if(auth()->guard()->check()): ?>
          <?php if(Route::has('checkout')): ?>
            <a href="<?php echo e(route('checkout')); ?>"
               class="btn btn-dark w-100" <?php if($serverTotal <= 0): echo 'disabled'; endif; ?>>
               Ir a pagar
            </a>
          <?php else: ?>
            <a href="<?php echo e(url('/checkout')); ?>"
               class="btn btn-dark w-100" <?php if($serverTotal <= 0): echo 'disabled'; endif; ?>>
               Ir a pagar
            </a>
          <?php endif; ?>
        <?php else: ?>
          
          <?php if(Route::has('checkout')): ?>
            <a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary w-100" <?php if($serverTotal <= 0): echo 'disabled'; endif; ?>>
              Iniciar sesión para pagar
            </a>
          <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary w-100">
              Iniciar sesión
            </a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php /**PATH C:\Users\PC\Desktop\021025\PROCAFE_V1\resources\views/partials/cart-offcanvas.blade.php ENDPATH**/ ?>