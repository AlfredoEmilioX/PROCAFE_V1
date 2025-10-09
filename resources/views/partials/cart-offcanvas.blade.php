<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="cartOffcanvasLabel">Tu carrito</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
  </div>

  <div class="offcanvas-body d-flex flex-column">
    <div id="cartItems" class="list-group list-group-flush mb-3" style="max-height:55vh;overflow:auto;"></div>

    <div class="mt-auto border-top pt-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="fw-semibold">Total</span>
        <span id="cartTotal" class="fw-bold">S/ 0.00</span>
      </div>

      <div class="d-flex gap-2">
        <button id="btnClearCart" class="btn btn-outline-secondary w-50">Vaciar</button>

        @auth
          @if (Route::has('checkout'))
            <a href="{{ route('checkout') }}" class="btn btn-primary w-50">Ir a pagar</a>
          @else
            <a href="#" class="btn btn-primary w-50 disabled" aria-disabled="true" title="Checkout no configurado">Ir a pagar</a>
          @endif
        @else
          <a href="{{ route('login') }}" class="btn btn-primary w-50">Inicia sesión para pagar</a>
        @endauth
      </div>
    </div>
  </div>
</div>
