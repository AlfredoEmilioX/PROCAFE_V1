@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h5 mb-0">Productos</h2>
  <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg me-1"></i> Nuevo producto
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
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Marca</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Estado</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($products as $p)
          <tr>
            <td>
              @if($p->image && Storage::disk('public')->exists($p->image))
                <img src="{{ Storage::url($p->image) }}" alt="" width="50" class="rounded">
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->category->name ?? '—' }}</td>
            <td>{{ $p->brand->name ?? '—' }}</td>
            <td>S/ {{ number_format($p->price,2) }}</td>
            <td>{{ $p->stock }}</td>
            <td>
              <span class="badge text-bg-{{ $p->status == 'active' ? 'success' : 'secondary' }}">
                {{ ucfirst($p->status) }}
              </span>
            </td>
            <td class="text-end">
              <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-sm btn-warning">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('admin.products.destroy',$p) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center text-muted py-4">No hay productos registrados.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="mt-3">{{ $products->links('pagination::bootstrap-5') }}</div>
@endsection
