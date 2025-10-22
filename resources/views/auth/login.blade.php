@extends('layouts.app')

@section('title', 'Iniciar sesión | PROCAFES')

@section('content')
<div class="container py-5" style="max-width: 480px;">
  <div class="card shadow-sm border-0">
    <div class="card-body p-4">
      <h4 class="mb-3 text-center fw-bold">Iniciar sesión</h4>

      @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label fw-semibold">Correo electrónico</label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
          @error('email')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Contraseña</label>
          <input type="password" name="password" class="form-control" required>
          @error('password')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Recordarme</label>
          </div>
          <a href="#" class="small text-muted">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="btn btn-procafes w-100">Ingresar</button>
      </form>

      <hr class="my-4">

      <div class="text-center small">
        ¿No tienes una cuenta?
        <a href="{{ route('register') }}">Registrarse</a>
      </div>

      <div class="text-center mt-3">
        <a href="{{ route('auth.google.redirect') }}" class="btn btn-outline-danger w-100">
          <i class="bi bi-google me-1"></i> Iniciar sesión con Google
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
