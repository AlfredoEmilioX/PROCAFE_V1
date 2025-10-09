<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Últimos 6 meses (incluye el actual)
        $months = collect(range(0, 5))->map(fn ($i) => Carbon::now()->subMonths(5 - $i)->startOfMonth());

        $labels = $months->map(fn ($m) => $m->format('M Y'))->values(); // ["May 2025", ...]
        $sales  = $months->map(function ($start) {
            $end = (clone $start)->addMonth();
            // Sumamos ventas confirmadas (paid|shipped)
            return (float) Order::whereBetween('created_at', [$start, $end])
                ->whereIn('status', ['paid', 'shipped'])
                ->sum('total_price');
        })->values();

        // Pedidos por estado (para el donut)
        $statusCounts = Order::select('status', DB::raw('COUNT(*) as c'))
            ->groupBy('status')
            ->pluck('c', 'status'); // ['pending'=>10, 'paid'=>5, ...]

        // Tarjetas (info boxes)
        $cards = [
            'products'   => Product::count(),
            'categories' => Category::count(),
            'orders'     => Order::count(),
            'customers'  => User::where('role', 'customer')->count(),
        ];

        return view('dashboard', [
            'labels'       => $labels,
            'sales'        => $sales,
            'statusCounts' => $statusCounts,
            'cards'        => $cards,
        ]);
    }
}
