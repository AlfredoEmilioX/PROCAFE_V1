<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // TODO: cambia por tus queries reales si ya tienes modelos/tablas
        $totalOrders   = method_exists(\App\Models\Order::class, 'count')
            ? \App\Models\Order::where('user_id', $user->id)->count()
            : 0;

        $pendingOrders = method_exists(\App\Models\Order::class, 'count')
            ? \App\Models\Order::where('user_id', $user->id)->whereIn('status', ['pending','processing'])->count()
            : 0;

        $wishlistCount = method_exists(\App\Models\Wishlist::class, 'count')
            ? \App\Models\Wishlist::where('user_id', $user->id)->count()
            : 0;

        $recentOrders = class_exists(\App\Models\Order::class)
            ? \App\Models\Order::where('user_id', $user->id)->latest()->take(5)->get()
            : collect(); // vacío sin romper

        $stats = [
            'totalOrders'   => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'wishlistCount' => $wishlistCount,
        ];

        return view('customer.dashboard', compact('user', 'stats', 'recentOrders'));
    }
}
