@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h5 mb-0">Categorías</h2>
  <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i> Nueva categoría
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
        @forelse($categories as $cat)
          <tr>
            <td>{{ $cat->categories_id }}</td>
            <td>{{ $cat->name }}</td>
            <td>{{ $cat->slug }}</td>
            <td>{{ Str::limit($cat->description, 50) }}</td>
            <td class="text-end">
              <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-warning">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta categoría?')">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-4">No hay categorías.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="mt-3">
  {{ $categories->links('pagination::bootstrap-5') }}
</div>
@endsection
