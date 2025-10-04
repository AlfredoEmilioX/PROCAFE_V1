<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function view(Request $request){
        $items = Cart::with('product')
            ->where('user_id', $request->user()->User_id)
            ->get();
        $total = $items->sum('sub_total');
        return view('cart.view', compact('items','total'));
    }

    public function add(Request $request, Product $product){
        $qty = max(1, (int)$request->input('qty',1));
        $price = $product->price;
        $sub = $qty * $price;

        $row = Cart::firstOrNew([
            'user_id' => $request->user()->User_id,
            'products_id' => $product->products_id,
        ]);

        $row->quantity = ($row->exists ? $row->quantity : 0) + $qty;
        $row->price = $price;
        $row->sub_total = $row->quantity * $price;
        $row->save();

        return back()->with('status','Producto agregado al carrito.');
    }

    public function remove(Request $request, Product $product){
        Cart::where('user_id', $request->user()->User_id)
            ->where('products_id', $product->products_id)
            ->delete();

        return back()->with('status','Producto quitado del carrito.');
    }
}
