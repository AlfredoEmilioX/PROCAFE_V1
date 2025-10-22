<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ====== RANGO ÚLTIMOS 12 MESES ======
        $months = collect(range(0, 11))
            ->map(fn ($i) => Carbon::now()->startOfMonth()->subMonths(11 - $i));

        $labels = $months->map(fn ($m) => $m->isoFormat('MMM'))->values()->all();

        // Campo total en orders (total_price o total)
        $orderTotalField = Schema::hasColumn('orders', 'total_price')
            ? 'total_price'
            : (Schema::hasColumn('orders', 'total') ? 'total' : null);

        // Ingresos por mes (solo estados pagados)
        $paidStatuses = ['paid', 'shipped', 'completed', 'success'];
        $revenue = $months->map(function ($start) use ($orderTotalField, $paidStatuses) {
            $end = (clone $start)->addMonth();
            if (!$orderTotalField) return 0.0;

            return (float) Order::whereBetween('created_at', [$start, $end])
                ->whereIn('status', $paidStatuses)
                ->sum($orderTotalField);
        })->values()->all();

        // ====== CARDS RESUMEN ======
        $stats = [
            'revenue'   => array_sum($revenue),
            'orders'    => (int) Order::count(),
            'products'  => (int) Product::count(),
            'customers' => (int) User::whereIn('role', ['customer', 'user'])->count(),
        ];

        // ====== CATEGORÍAS (chips) ======
        $chips = Category::query()
            ->select('name')
            ->orderBy('name')
            ->limit(12)
            ->pluck('name')
            ->map(fn ($n) => ['i' => 'bi-dot', 't' => $n])
            ->values()
            ->all();

        // ====== BEST-SELLERS ======
        // Detección robusta de columnas (PK de products y precio en order_items)
        $productPk = Schema::hasColumn('products', 'product_id') ? 'product_id' : 'id';

        // FK en order_items apuntando a products
        $oiProductFk = Schema::hasColumn('order_items', 'product_id')
            ? 'product_id'
            : (Schema::hasColumn('order_items', 'products_id') ? 'products_id' : null);

        // precio unidad en order_items
        $unitPrice = Schema::hasColumn('order_items','unit_price')
            ? 'unit_price'
            : (Schema::hasColumn('order_items','price') ? 'price' : null);

        $best = [];
        if ($oiProductFk && $unitPrice) {
            $best = DB::table('order_items as oi')
                ->join('products as p', "p.$productPk", '=', "oi.$oiProductFk")
                ->select([
                    "p.$productPk as pk",
                    'p.name',
                    DB::raw('SUM(oi.quantity) as qty_sold'),
                    DB::raw("SUM(oi.quantity * oi.$unitPrice) as amount"),
                ])
                ->groupBy("p.$productPk", 'p.name')
                ->orderByDesc('qty_sold')
                ->limit(5)
                ->get()
                ->map(function ($row) {
                    return [
                        'name'   => $row->name,
                        'sku'    => '',                 // agrega si tienes columna sku en products
                        'price'  => '',                 // opcional
                        'orders' => (int) $row->qty_sold,
                        'stock'  => null,               // opcional: leer desde products si quieres
                        'amount' => (float) $row->amount,
                        'img'    => 'https://via.placeholder.com/56',
                    ];
                })->toArray();
        }

        return view('dashboard', compact('labels','revenue','stats','chips','best'));
    }
}
