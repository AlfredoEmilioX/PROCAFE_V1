@extends('layouts.app')

@section('title', 'Productos - PROCAFES')

@section('content')
@php
  // Categorías basadas en tu carta
  $categories = [
    ['slug' => 'espresso-calientes', 'name' => 'Espresso & Calientes'],
    ['slug' => 'cafes-frios',        'name' => 'Cafés fríos'],
    ['slug' => 'frappes',            'name' => 'Frappes'],
    ['slug' => 'cold-brew',          'name' => 'Cold Brew'],
    ['slug' => 'piqueos',            'name' => 'Piqueos artesanales'],
    ['slug' => 'sandwiches',         'name' => 'Sandwiches'],
  ];

  // 6 productos DEMO (solo referencia visual, sin BD)
  // Usamos imágenes de placeholder por URL (puedes cambiarlas luego por /images/*.jpg)
  $allProducts = [
    [
      'name'     => 'Espresso Clásico',
      'category' => 'espresso-calientes',
      'price'    => 8.00,
      'image'    => 'https://picsum.photos/seed/espresso/600/400',
    ],
    [
      'name'     => 'Latte Macchiato',
      'category' => 'espresso-calientes',
      'price'    => 12.00,
      'image'    => 'https://picsum.photos/seed/latte/600/400',
    ],
    [
      'name'     => 'Café Frío Pichanaki',
      'category' => 'cafes-frios',
      'price'    => 10.00,
      'image'    => 'https://picsum.photos/seed/icedcoffee/600/400',
    ],
    [
      'name'     => 'Cold Brew con Limón',
      'category' => 'cold-brew',
      'price'    => 11.00,
      'image'    => 'https://picsum.photos/seed/coldbrew/600/400',
    ],
    [
      'name'     => 'Frappe de Café',
      'category' => 'frappes',
      'price'    => 13.00,
      'image'    => 'https://picsum.photos/seed/frappe/600/400',
    ],
    [
      'name'     => 'Sándwich de Pollo a la Plancha',
      'category' => 'sandwiches',
      'price'    => 15.00,
      'image'    => 'https://picsum.photos/seed/sandwich/600/400',
    ],
  ];

  // filtro por ?categoria=slug (opcional)
  $selected = request('categoria');
  $products = array_values(array_filter($allProducts, function ($p) use ($selected) {
      return !$selected || $p['category'] === $selected;
  }));

  // conteos por categoría (para el badge)
  $counts = [];
  foreach ($categories as $c) {
      $counts[$c['slug']] = count(array_filter($allProducts, fn($p) => $p['category'] === $c['slug']));
  }
@endphp

<div class="container py-4">
  <div class="row g-4">
    {{-- Sidebar de categorías --}}
    <aside class="col-lg-3">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-procafes">
          <strong>CATEGORÍAS</strong>
        </div>
        <div class="list-group list-group-flush">

          {{-- Todas --}}
          <a href="{{ route('home') }}"
             class="list-group-item list-group-item-action @if(!$selected) active @endif">
            Todas
            <span class="badge bg-secondary rounded-pill float-end">{{ count($allProducts) }}</span>
          </a>

          {{-- Iterar categorías --}}
          @foreach($categories as $cat)
            <a href="{{ route('home', ['categoria' => $cat['slug']]) }}"
               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
                      @if($selected === $cat['slug']) active @endif">
              <span>{{ $cat['name'] }}</span>
              <span class="badge bg-secondary rounded-pill">{{ $counts[$cat['slug']] ?? 0 }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </aside>

    {{-- Grilla de productos --}}
    <section class="col-lg-9">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h5 mb-0">
          @php
            $title = 'Todos los productos';
            if ($selected) {
              $found = collect($categories)->firstWhere('slug', $selected);
              if ($found) $title = 'Productos: '.$found['name'];
            }
          @endphp
          {{ $title }}
        </h1>
        <span class="text-muted">{{ count($products) }} resultado(s)</span>
      </div>

      @if(empty($products))
        <div class="alert alert-info">No hay productos para esta categoría.</div>
      @else
        <div class="row g-3">
          @foreach($products as $p)
            <div class="col-6 col-md-4">
              <div class="card h-100 border-0 shadow-sm">
                <img src="{{ $p['image'] }}" class="card-img-top" alt="{{ $p['name'] }}"
                     style="height: 180px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title mb-1" style="font-size: 1rem">{{ $p['name'] }}</h5>
                  <p class="text-muted mb-2" style="font-size: .9rem">
                    @php
                      $catName = collect($categories)->firstWhere('slug', $p['category'])['name'] ?? '';
                    @endphp
                    {{ $catName }}
                  </p>
                  <strong class="mb-3">S/ {{ number_format($p['price'], 2) }}</strong>
                  <div class="mt-auto d-grid">
                    <button class="btn btn-procafes-dark" disabled>Añadir al carrito</button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </section>
  </div>
</div>
@endsection
