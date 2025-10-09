@extends('layouts.app')
@section('title', 'Mi lista de deseos')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp

<div class="container py-4">
  <h3 class="mb-4">💖 Mi lista de deseos</h3>

  {{-- Mensajes flash --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
  @endif

  {{-- Lista vacía --}}
  @if($wishlists->isEmpty())
    <div class="alert alert-secondary text-center">
      No tienes productos en tu lista de deseos aún.
    </div>
  @else
    <div class="row g-3">
      @foreach($wishlists as $item)
        @php $product = $item->product; @endphp
        @if($product)
          <div class="col-6 col-md-3">
            <div class="card h-100 shadow-sm border-0">

              {{-- Imagen del producto --}}
              <div class="ratio ratio-1x1 bg-light">
                @php
                  $img = ($product->image && Storage::disk('public')->exists($product->image))
                          ? Storage::url($product->image)
                          : 'https://via.placeholder.com/300x300?text=Producto';
                @endphp
                <img src="{{ $img }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover">
              </div>

              {{-- Datos del producto --}}
              <div class="card-body text-center">
                <h6 class="card-title mb-1">{{ $product->name }}</h6>
                <p class="text-muted mb-0">S/ {{ number_format($product->price, 2) }}</p>
              </div>

              {{-- Botones de acción --}}
              <div class="card-footer bg-white border-0 d-flex justify-content-center gap-2">

                {{-- Quitar de favoritos --}}
                <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline-danger btn-sm" title="Quitar de la lista">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>

                {{-- Agregar al carrito (sin login, vía JS) --}}
                <button
                  type="button"
                  class="btn btn-warning w-100 btn-add-to-cart"
                  data-id="{{ $p->id }}"
                  data-name="{{ $p->name }}"
                  data-price="{{ $p->price }}"
                  data-image="{{ $p->image_url ?? Storage::url($p->image ?? '') }}"
                  data-url="{{ route('product.show', $p) }}"
                >
                  <i class="bi bi-cart-plus me-1"></i> Agregar al carrito
                </button>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </div>
  @endif
</div>
@endsection
