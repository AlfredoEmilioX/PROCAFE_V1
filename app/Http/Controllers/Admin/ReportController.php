<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class ReportController extends Controller
{
    // ===== Ingresos últimos 12 meses =====
    public function revenueCsv(): StreamedResponse
    {
        $orderTotalField = Schema::hasColumn('orders','total_price') ? 'total_price'
            : (Schema::hasColumn('orders','total') ? 'total' : null);

        $months = collect(range(0, 11))
            ->map(fn($i) => Carbon::now()->startOfMonth()->subMonths(11 - $i));

        $paid = ['paid','shipped','completed','success'];

        $rows = [['Mes','Ingresos (S/)']];
        foreach ($months as $start) {
            $end = (clone $start)->addMonth();
            $sum = $orderTotalField
                ? (float) Order::whereBetween('created_at', [$start, $end])
                    ->whereIn('status', $paid)
                    ->sum($orderTotalField)
                : 0.0;
            $rows[] = [$start->isoFormat('YYYY-MM'), number_format($sum, 2, '.', '')];
        }

        return $this->downloadCsv('revenue_last_12m.csv', $rows);
    }

    // ===== Best sellers (Top 100) =====
    public function bestSellersCsv(): StreamedResponse
    {
        $productPk  = Schema::hasColumn('products','product_id') ? 'product_id' : 'id';
        $oiProductFk= Schema::hasColumn('order_items','product_id') ? 'product_id'
                    : (Schema::hasColumn('order_items','products_id') ? 'products_id' : null);
        $unitPrice  = Schema::hasColumn('order_items','unit_price') ? 'unit_price'
                    : (Schema::hasColumn('order_items','price') ? 'price' : null);

        $rows = [['ProductoID','Producto','Unidades','Importe (S/)']];

        if ($oiProductFk && $unitPrice) {
            $items = DB::table('order_items as oi')
                ->join('products as p', "p.$productPk", '=', "oi.$oiProductFk")
                ->select([
                    "p.$productPk as product_id",
                    'p.name',
                    DB::raw('SUM(oi.quantity) as qty_sold'),
                    DB::raw("SUM(oi.quantity * oi.$unitPrice) as amount"),
                ])
                ->groupBy("p.$productPk", 'p.name')
                ->orderByDesc('qty_sold')
                ->limit(100)
                ->get();

            foreach ($items as $row) {
                $rows[] = [$row->product_id, $row->name, (int)$row->qty_sold, number_format((float)$row->amount, 2, '.', '')];
            }
        }

        return $this->downloadCsv('best_sellers.csv', $rows);
    }

    // ===== Inventario de productos =====
    public function productsCsv(): StreamedResponse
    {
        $pk   = Schema::hasColumn('products','product_id') ? 'product_id' : 'id';
        $cols = ['name','slug','price','stock','brand_id','category_id','created_at'];
        $exists = collect($cols)->filter(fn($c) => Schema::hasColumn('products',$c))->values()->all();

        $rows = [['ProductoID', ...array_map('ucfirst', $exists)]];

        Product::query()
            ->select(array_merge([$pk], $exists))
            ->orderBy($pk)
            ->chunk(500, function($chunk) use (&$rows, $pk, $exists) {
                foreach ($chunk as $p) {
                    $line = [$p->{$pk}];
                    foreach ($exists as $c) $line[] = (string) $p->{$c};
                    $rows[] = $line;
                }
            });

        return $this->downloadCsv('productos_inventario.csv', $rows);
    }

    // ===== Órdenes por rango (YYYY-MM-DD a YYYY-MM-DD) =====
    public function ordersCsv(Request $request): StreamedResponse
    {
        $from = $request->query('from', Carbon::now()->subDays(30)->toDateString());
        $to   = $request->query('to',   Carbon::now()->toDateString());

        $total = Schema::hasColumn('orders','total_price') ? 'total_price'
               : (Schema::hasColumn('orders','total') ? 'total' : null);

        $rows = [['OrderID','Status','Total','Fecha']];

        Order::query()
            ->when($from && $to, fn($q) => $q->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']))
            ->orderByDesc('created_at')
            ->chunk(500, function($chunk) use (&$rows, $total) {
                foreach ($chunk as $o) {
                    $rows[] = [
                        $o->id ?? $o->order_id,
                        $o->status,
                        $total ? number_format((float)$o->{$total}, 2, '.', '') : '0.00',
                        $o->created_at?->toDateTimeString(),
                    ];
                }
            });

        return $this->downloadCsv("orders_{$from}_{$to}.csv", $rows);
    }

    // ========= util =========
    protected function downloadCsv(string $filename, array $rows): StreamedResponse
    {
        return response()->streamDownload(function() use ($rows) {
            $out = fopen('php://output', 'w');
            foreach ($rows as $r) fputcsv($out, $r);
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
