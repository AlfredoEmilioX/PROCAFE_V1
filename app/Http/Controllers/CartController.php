<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /** Límite superior de cantidad por ítem */
    private const MAX_QTY = 999;

    /**
     * Estructura de sesión:
     * cart = [
     *   'items' => [ rowId => ['rowId','id','name','price','qty','image','url','variant'] ],
     *   'count' => (int) suma de qty,
     *   'total' => (float) total general
     * ]
     */

    /** Obtener carrito desde sesión o estructura por defecto */
    private function getCart(): array
    {
        return session()->get('cart', [
            'items' => [],
            'count' => 0,
            'total' => 0.0,
        ]);
    }

    /** Guardar carrito en sesión recalculando count y total */
    private function putCart(array $cart): void
    {
        $items = $cart['items'] ?? [];

        $count = 0;
        $total = 0.0;

        foreach ($items as $it) {
            $qty   = (int) ($it['qty'] ?? 0);
            $price = (float) ($it['price'] ?? 0.0);
            $count += $qty;
            $total += $price * $qty;
        }

        $cart['count'] = $count;
        $cart['total'] = round($total, 2);

        session()->put('cart', $cart);
    }

    /** Generar rowId estable por producto + variación */
    private function makeRowId($id, $variant = null): string
    {
        // $variant puede ser string o array (color, talla, etc.)
        if (is_array($variant)) {
            $variantKey = json_encode($variant, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            $variantKey = (string) ($variant ?? '');
        }
        return 'p_' . substr(sha1($id . '|' . $variantKey), 0, 12);
    }

    /** GET /cart */
    public function index()
    {
        return response()->json($this->getCart());
    }

    /**
     * POST /cart/add
     * Body JSON:
     * id (req), name (req), price (req >=0), qty (>=1), image, url, variant
     */
    public function add(Request $request)
    {
        $data = $request->validate([
            'id'      => ['required'],
            'name'    => ['required', 'string', 'max:255'],
            'price'   => ['required', 'numeric', 'min:0'],
            'qty'     => ['nullable', 'integer', 'min:1'],
            'image'   => ['nullable', 'string'],
            'url'     => ['nullable', 'string'],
            'variant' => ['nullable'], // string|array
        ]);

        $cart = $this->getCart();

        $qty     = (int) ($data['qty'] ?? 1);
        $qty     = max(1, min(self::MAX_QTY, $qty));
        $variant = $data['variant'] ?? null;
        $rowId   = $this->makeRowId($data['id'], $variant);

        if (isset($cart['items'][$rowId])) {
            $cart['items'][$rowId]['qty'] = max(1, min(self::MAX_QTY, (int)$cart['items'][$rowId]['qty'] + $qty));
        } else {
            $cart['items'][$rowId] = [
                'rowId'   => $rowId,
                'id'      => $data['id'],
                'name'    => $data['name'],
                'price'   => (float) $data['price'],
                'qty'     => $qty,
                'image'   => $data['image'] ?? null,
                'url'     => $data['url'] ?? null,
                'variant' => $variant,
            ];
        }

        $this->putCart($cart);

        return response()->json($cart);
    }

    /**
     * PATCH /cart/{rowId}
     * Body JSON: { qty: int >= 1 }
     */
    public function update(Request $request, string $rowId)
    {
        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCart();

        if (!isset($cart['items'][$rowId])) {
            // Si no existe el item, devolver estado actual (no es error grave para UI)
            return response()->json($cart);
        }

        $qty = max(1, min(self::MAX_QTY, (int)$data['qty']));
        $cart['items'][$rowId]['qty'] = $qty;

        $this->putCart($cart);

        return response()->json($cart);
    }

    /** DELETE /cart/{rowId} */
    public function remove(string $rowId)
    {
        $cart = $this->getCart();

        if (isset($cart['items'][$rowId])) {
            unset($cart['items'][$rowId]);
            $this->putCart($cart);
        }

        return response()->json($cart);
    }

    /** DELETE /cart */
    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'items' => [],
            'count' => 0,
            'total' => 0.0,
        ]);
    }
}
