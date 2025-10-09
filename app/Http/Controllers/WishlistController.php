<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Mostrar la lista de deseos del usuario
    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    // Agregar producto
    public function store($productId)
    {
        $userId = Auth::id();

        // Evita duplicados
        $exists = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'Este producto ya está en tu lista de deseos.');
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return redirect()->back()->with('success', 'Producto agregado a tu lista de deseos.');
    }

    // Eliminar producto de la lista
    public function destroy($productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return redirect()->back()->with('success', 'Producto eliminado de tu lista de deseos.');
    }
}
