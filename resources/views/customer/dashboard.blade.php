@extends('layouts.app')
@section('title', 'Mi cuenta')

@push('styles')
<style>
  .account-cover {
    background: linear-gradient(135deg, #e9f2ff, #f7f9ff);
    height: 120px;
    border-top-left-radius: .75rem;
    border-top-right-radius: .75rem;
  }
  .avatar-wrap {
    margin-top: -42px;
  }
  .avatar {
    width: 84px; height: 84px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,.08);
  }
  .menu-link.active {
    background: #fff6d6; /* tono procafes */
    font-weight: 600;
  }
  .stat-card {
    border: 1px solid #f0f0f0;
  }
  .stat-ico {
    width: 40px; height: 40px;
    display: grid; place-items: center;
    border-radius: .75rem;
    background: #f8fafc;
  }
</style>
@endpush

@section('content')
<div class="container py-4">
  <div class="row g-3">
    {{-- Sidebar --}}
    <aside class="col-12 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="account-cover"></div>

        <div class="card-body">
          <div class="d-flex align-items-center gap-3 avatar-wrap">
            <img
              class="avatar"
              src="{{ $user->avatar_url ?? 'https://i.pravatar.cc/160?img=5' }}"
              alt="{{ $user->name }}"
            >
            <div>
              <div class="fw-semibold">{{ $user->name }}</div>
              <div class="text-muted small">{{ $user->email }}</div>
            </div>
          </div>

          <hr>

          <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action menu-link active" href="{{ route('customer.dashboard') }}">
              <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>

            @if(Route::has('orders.index'))
            <a class="list-group-item list-group-item-action menu-link" href="{{ route('orders.index') }}">
              <i class="bi bi-bag-check me-2"></i> Mis pedidos
            </a>
            @endif

            @if(Route::has('wishlist.index'))
            <a class="list-group-item list-group-item-action menu-link" href="{{ route('wishlist.index') }}">
              <i class="bi bi-heart me-2"></i> Wishlist
            </a>
            @endif

            @if(Route::has('addresses.index'))
            <a class="list-group-item list-group-item-action menu-link" href="{{ route('addresses.index') }}">
              <i class="bi bi-geo-alt me-2"></i> Direcciones
            </a>
            @endif

            @if(Route::has('profile'))
            <a class="list-group-item list-group-item-action menu-link" href="{{ route('profile') }}">
              <i class="bi bi-person-gear me-2"></i> Perfil
            </a>
            @endif

            <a class="list-group-item list-group-item-action menu-link" href="{{ route('home') }}">
              <i class="bi bi-shop me-2"></i> Ver productos
            </a>

            <form action="{{ route('logout') }}" method="POST" class="list-group-item p-0 border-0">
              @csrf
              <button class="btn w-100 text-start px-3 py-2">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
              </button>
            </form>
          </div>
        </div>
      </div>
    </aside>

    {{-- Main --}}
    <section class="col-12 col-lg-9">
      {{-- Bienvenida --}}
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-1">Hola, {{ $user->name }} 👋</h5>
            <div class="text-muted">Este es un resumen de tu cuenta.</div>
          </div>
          <div class="d-none d-md-block">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
              <i class="bi bi-shop me-1"></i> Ver productos
            </a>
            @if(Route::has('checkout'))
              <a href="{{ route('checkout') }}" class="btn btn-primary">
                <i class="bi bi-credit-card me-1"></i> Ir a pagar
              </a>
            @endif
          </div>
        </div>
      </div>

      {{-- Stats --}}
      <div class="row g-3 mb-3">
        <div class="col-12 col-md-4">
          <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
              <div class="stat-ico"><i class="bi bi-bag fs-5"></i></div>
              <div>
                <div class="text-muted small">Total de pedidos</div>
                <div class="fs-5 fw-semibold">{{ number_format($stats['totalOrders'] ?? 0) }}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
              <div class="stat-ico"><i class="bi bi-hourglass-split fs-5"></i></div>
              <div>
                <div class="text-muted small">Pendientes</div>
                <div class="fs-5 fw-semibold">{{ number_format($stats['pendingOrders'] ?? 0) }}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
              <div class="stat-ico"><i class="bi bi-heart fs-5"></i></div>
              <div>
                <div class="text-muted small">Wishlist</div>
                <div class="fs-5 fw-semibold">{{ number_format($stats['wishlistCount'] ?? 0) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Datos de cuenta --}}
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
          <h6 class="mb-3">Información de la cuenta</h6>
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <div class="border rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="fw-semibold">Contacto</span>
                  @if(Route::has('profile')) <a href="{{ route('profile') }}" class="small">Editar</a> @endif
                </div>
                <div class="small text-muted">Nombre</div>
                <div class="mb-2">{{ $user->name }}</div>
                <div class="small text-muted">Email</div>
                <div>{{ $user->email }}</div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="border rounded p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="fw-semibold">Direcciones</span>
                  @if(Route::has('addresses.index')) <a href="{{ route('addresses.index') }}" class="small">Editar</a> @endif
                </div>
                <div class="text-muted">No has configurado una dirección predeterminada.</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Últimos pedidos --}}
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Últimos pedidos</h6>
            @if(Route::has('orders.index'))
              <a href="{{ route('orders.index') }}" class="small">Ver todos</a>
            @endif
          </div>

          @if($recentOrders->isEmpty())
            <div class="alert alert-secondary mb-0">
              Aún no tienes pedidos. <a href="{{ route('home') }}" class="alert-link">¡Empieza a comprar!</a>
            </div>
          @else
            <div class="table-responsive">
              <table class="table table-sm align-middle">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($recentOrders as $o)
                    <tr>
                      <td>{{ $o->id }}</td>
                      <td>{{ optional($o->created_at)->format('d/m/Y H:i') }}</td>
                      <td><span class="badge text-bg-light">{{ ucfirst($o->status) }}</span></td>
                      <td>S/ {{ number_format($o->total, 2) }}</td>
                      <td class="text-end">
                        @if(Route::has('orders.show'))
                          <a href="{{ route('orders.show', $o) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </section>
  </div>
</div>
@endsection
