@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="mb-3 text-center">Recuperar Contraseña</h4>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    </div>

                    <button type="submit" class="btn btn-warning w-100">Enviar enlace de recuperación</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
