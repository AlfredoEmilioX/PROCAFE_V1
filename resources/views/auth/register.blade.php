@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow">
      <div class="card-body">
        <h4 class="mb-4 text-center">Registro</h4>
        <form method="POST" action="{{ route('register') }}">
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password" class="form-control" name="password" required>
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
          </div>

          <button type="submit" class="btn btn-success w-100">Registrarse</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
