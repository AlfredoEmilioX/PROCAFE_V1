<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = session('cart', []); // [id => ['name','price','quantity','image'...]]
        $items = collect($cart)->map(function ($i) {
            $qty = (int)($i['quantity'] ?? 1);
            $price = (float)($i['price'] ?? 0);
            return [
                'name' => $i['name'] ?? 'Producto',
                'price' => $price,
                'quantity' => $qty,
                'subtotal' => $qty * $price,
                'image' => $i['image'] ?? null,
                'brand' => $i['brand'] ?? null,
                'category' => $i['category'] ?? null,
            ];
        });

        $total = (float) $items->sum('subtotal');

        return view('checkout.index', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,cash',
        ]);

        $cart = session('cart', []);
        abort_if(empty($cart), 400, 'El carrito está vacío');

        $total = collect($cart)->sum(fn ($i) => (float)($i['price'] ?? 0) * (int)($i['quantity'] ?? 1));
        $total = round($total, 2);

        // Guardamos info mínima de “orden” en sesión para la demo
        $paymentData = [
            'order_id' => 'ORD-'.now()->format('YmdHis'),
            'amount'   => $total,
            'currency' => 'PEN',
            'items'    => $cart,
            'method'   => $request->payment_method, // card | cash
        ];
        session(['payment_demo' => $paymentData]);

        // Simulación de flujo:
        if ($request->payment_method === 'card') {
            // Simula redirección a pasarela (PayU)
            return redirect()->route('payments.redirect'); // vista de “estás saliendo a PayU”
        }

        // PagoEfectivo (cupón/código de pago)
        $coupon = 'PE-'.strtoupper(str()->random(8));
        $expiresAt = now()->addDays(2)->format('d/m/Y H:i');
        session(['payment_demo.cash' => ['coupon' => $coupon, 'expires_at' => $expiresAt]]);

        // Redirige a “respuesta” mostrando el código generado
        return redirect()->route('payments.response', ['status' => 'PENDING']);
    }
}
