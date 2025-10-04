@extends('layouts.app')

@section('title','Dashboard - PROCAFES')

@section('content')
<div class="container py-4">

  {{-- Saludo --}}
  <div class="alert alert-success" role="alert">
    Hola, <strong>{{ Auth::user()->role_label ?? (Auth::user()->role === 'admin' ? 'Administrador' : 'Cliente') }}</strong> 👋
  </div>

  <h1 class="h4 mb-2">Panel de administración</h1>
  <p class="text-muted">Aquí pronto tendrás el CRUD de categorías, marcas, productos, etc.</p>

</div>
@endsection
