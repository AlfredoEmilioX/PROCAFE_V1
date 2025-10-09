@extends('layouts.admin')

@push('styles')
<style>
  .info-box{display:flex;align-items:center;gap:.75rem;background:#fff;border:0;border-radius:.75rem;padding:1rem;box-shadow:0 2px 8px rgba(0,0,0,.04)}
  .info-box .icon{font-size:1.8rem;opacity:.7}
  .info-box .value{font-weight:700;font-size:1.6rem;margin:0}
  .info-box.teal   {border-left:6px solid #20c997}
  .info-box.green  {border-left:6px solid #28a745}
  .info-box.yellow {border-left:6px solid #ffc107}
  .info-box.red    {border-left:6px solid #dc3545}
  .card-ghost{background:#fff;border-radius:.75rem;box-shadow:0 2px 12px rgba(0,0,0,.06)}
</style>
@endpush

@section('admin-content')
<div class="row g-3">
  <div class="col-12">
    <h1 class="h4 mb-1">Dashboard</h1>
    <p class="text-muted">Resumen general del sistema</p>
  </div>

  {{-- Tarjetas tipo "info box" --}}
  <div class="col-md-3">
    <div class="info-box teal">
      <i class="bi bi-box-seam icon"></i>
      <div>
        <div class="text-muted">Productos</div>
        <p class="value mb-0">{{ $cards['products'] }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="info-box green">
      <i class="bi bi-tags icon"></i>
      <div>
        <div class="text-muted">Categorías</div>
        <p class="value mb-0">{{ $cards['categories'] }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="info-box yellow">
      <i class="bi bi-receipt icon"></i>
      <div>
        <div class="text-muted">Pedidos</div>
        <p class="value mb-0">{{ $cards['orders'] }}</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="info-box red">
      <i class="bi bi-people icon"></i>
      <div>
        <div class="text-muted">Clientes</div>
        <p class="value mb-0">{{ $cards['customers'] }}</p>
      </div>
    </div>
  </div>

  {{-- Gráficos --}}
  <div class="col-lg-8">
    <div class="card-ghost p-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Ventas (últimos 6 meses)</h5>
        <span class="badge text-bg-secondary">S/</span>
      </div>
      <canvas id="salesChart" height="120"></canvas>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card-ghost p-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Pedidos por estado</h5>
      </div>
      <canvas id="statusChart" height="260"></canvas>
      @php
        $mapping = ['pending'=>'Pendiente', 'paid'=>'Pagado', 'shipped'=>'Enviado', 'cancelled'=>'Cancelado'];
        $labelsStatus = collect($statusCounts)->keys()->map(fn($k)=>$mapping[$k] ?? $k)->values();
      @endphp
      <div class="mt-2 small text-muted">
        @foreach($labelsStatus as $i => $lab)
          <span class="me-2">{{ $lab }}: {{ collect($statusCounts)->values()[$i] ?? 0 }}</span>
        @endforeach
      </div>
    </div>
  </div>

  {{-- (Opcional) Tabla de últimos pedidos --}}
  <div class="col-12">
    <div class="card-ghost p-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">Últimos pedidos</h5>
      </div>
      @php $orders = \App\Models\Order::with('user')->latest()->take(8)->get(); @endphp
      @if($orders->isEmpty())
        <p class="text-muted mb-0">Aún no hay pedidos.</p>
      @else
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th><th>Cliente</th><th>Total</th><th>Estado</th><th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $o)
                <tr>
                  <td>{{ $o->id }}</td>
                  <td>{{ optional($o->user)->name ?? '—' }}</td>
                  <td>S/ {{ number_format($o->total_price,2) }}</td>
                  <td class="text-capitalize"><span class="badge text-bg-secondary">{{ $o->status }}</span></td>
                  <td>{{ optional($o->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const labels = @json($labels);
    const sales  = @json($sales);

    const statusData = @json($statusCounts);
    const statusLabels = Object.keys(statusData).map(k => ({pending:'Pendiente',paid:'Pagado',shipped:'Enviado',cancelled:'Cancelado'}[k] ?? k));
    const statusValues = Object.values(statusData);

    // Línea (ventas)
    new Chart(document.getElementById('salesChart'), {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Ventas (S/)',
          data: sales,
          fill: true,
          tension: .35,
          borderWidth: 2,
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
      }
    });

    // Donut (pedidos por estado)
    new Chart(document.getElementById('statusChart'), {
      type: 'doughnut',
      data: {
        labels: statusLabels,
        datasets: [{ data: statusValues }]
      },
      options: {
        plugins: { legend: { position: 'bottom' } },
        cutout: '60%'
      }
    });
  </script>
@endpush
