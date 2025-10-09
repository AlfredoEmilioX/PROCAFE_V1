@extends('layouts.admin')

@section('admin-content')
<h2 class="h5 mb-3">Editar cliente</h2>

<form action="{{ route('admin.users.update', $user) }}" method="POST">
  @csrf @method('PUT')

  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label">Correo electrónico</label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
      @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label">Teléfono</label>
      <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label">Dirección</label>
      <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
    </div>
  </div>

  <div class="d-flex justify-content-between">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Volver</a>
    <button class="btn btn-primary">Actualizar</button>
  </div>
</form>
@endsection
