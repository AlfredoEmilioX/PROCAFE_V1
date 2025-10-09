@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h5 mb-0">Marcas</h2>
  <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i> Nueva marca
  </a>
</div>

@if(session('ok'))
  <div class="alert alert-success">{{ session('ok') }}</div>
@endif

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Slug</th>
            <th>Descripción</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($brands as $brand)
          <tr>
            <td>{{ $brand->brands_id }}</td>
            <td>{{ $brand->name }}</td>
            <td>{{ $brand->slug }}</td>
            <td>{{ Str::limit($brand->description, 50) }}</td>
            <td class="text-end">
              <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-warning">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta marca?')">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-4">No hay marcas registradas.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="mt-3">
  {{ $brands->links('pagination::bootstrap-5') }}
</div>
@endsection
