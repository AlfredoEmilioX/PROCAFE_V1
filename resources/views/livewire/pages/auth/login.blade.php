<div class="row g-4 align-items-stretch">
  {{-- Imagen izquierda (solo ≥ lg) --}}
  <div class="col-lg-7 d-none d-lg-block">
    <div class="ratio ratio-4x3 rounded-4 overflow-hidden bg-light">
      <img
        src="{{ asset('images/cafe_register.jpg') }}"
        alt="Autenticación PROCAFES"
        class="w-100 h-100 object-fit-cover"
      >
    </div>
  </div>

  {{-- Form derecha --}}
  <div class="col-12 col-lg-5">
    <div class="card shadow-sm h-100 rounded-4 border-0">
      <div class="card-body p-4 p-lg-5">
        <h2 class="h4 mb-1">Bienvenido(a) a PROCAFES</h2>
        <p class="text-muted mb-4">Inicia sesión en tu cuenta</p>

        @if (session('status'))
          <div class="alert alert-success" role="alert">{{ session('status') }}</div>
        @endif

        {{-- Muestra error general de credenciales si falla --}}
        @error('state.email')
          <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror

        <form wire:submit="login" novalidate>
          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input id="email" type="email"
                   wire:model.defer="state.email" required autocomplete="email" autofocus
                   class="form-control @error('state.email') is-invalid @enderror"
                   placeholder="tucorreo@dominio.com">
            @error('state.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password"
                   wire:model.defer="state.password" required autocomplete="current-password"
                   class="form-control @error('state.password') is-invalid @enderror"
                   placeholder="••••••••">
            @error('state.password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember" wire:model="state.remember">
              <label class="form-check-label" for="remember">Recordarme</label>
            </div>
            @if (Route::has('password.request'))
              <a class="link-procafes text-decoration-none" href="{{ route('password.request') }}">
                ¿Olvidaste tu contraseña?
              </a>
            @endif
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-procafes-dark btn-lg" wire:loading.attr="disabled">
              Ingresar
            </button>
          </div>
        </form>

        <div class="text-center my-3"><span class="text-muted">o</span></div>

        <a href="{{ route('auth.google.redirect') }}"
           class="btn btn-light border w-100 d-flex align-items-center justify-content-center gap-2 mb-2">
          <i class="bi bi-google"></i> Continuar con Google
        </a>

        <p class="text-center mt-3 mb-0">
          ¿No tienes cuenta?
          <a href="{{ route('register') }}" class="link-procafes text-decoration-none">Crear cuenta</a>
        </p>
      </div>
    </div>
  </div>
</div>
