@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow">
      <div class="card-body">
        <h4 class="mb-4 text-center">Iniciar Sesión</h4>
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password" class="form-control" name="password" required>
          </div>

          <div class="d-flex justify-content-between mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label" for="remember">Recuérdame</label>
            </div>
            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
          </div>

          <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
