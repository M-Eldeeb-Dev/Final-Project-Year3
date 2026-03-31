<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Cart session structure:
     * session('cart') = [
     *   '{product_id}:{size}:{color}' => [
     *     'product_id', 'name', 'price', 'image_url',
     *     'quantity', 'selected_size', 'selected_color', 'subtotal'
     *   ]
     * ]
     */

    public function index()
    {
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum('subtotal');
        $shipping = $subtotal > 100 ? 0 : 9.99;
        $tax = round($subtotal * 0.14, 2);
        $total = round($subtotal + $shipping + $tax, 2);

        return view('cart', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function add(AddToCartRequest $request)
    {
        $product = Product::with('category')->findOrFail($request->product_id);

        if ($product->stock < 1) {
            return response()->json([
                'success' => false,
                'message' => 'This product is out of stock.',
            ], 422);
        }

        $size = $request->selected_size ?? '';
        $color = $request->selected_color ?? '';
        $key = "{$product->id}:{$size}:{$color}";
        $cart = session('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
            $cart[$key]['subtotal'] = round($cart[$key]['quantity'] * $product->active_price, 2);
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->active_price,
                'image' => $product->image_url,
                'category' => optional($product->category)->name ?? '',
                'quantity' => $request->quantity,
                'size' => $size,
                'color' => $color,
                'subtotal' => round($request->quantity * $product->active_price, 2),
            ];
        }

        session(['cart' => $cart]);

        $cartCount = collect($cart)->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => "'{$product->name}' added to cart.",
            'cart_count' => $cartCount,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $cart = session('cart', []);

        if (isset($cart[$request->key])) {
            $cart[$request->key]['quantity'] = $request->quantity;
            $cart[$request->key]['subtotal'] = round(
                $request->quantity * $cart[$request->key]['price'],
                2
            );
            session(['cart' => $cart]);
        }

        $subtotal = collect($cart)->sum('subtotal');
        $shipping = $subtotal > 100 ? 0 : 9.99;
        $tax = round($subtotal * 0.14, 2);

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 2),
            'shipping' => number_format($shipping, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($subtotal + $shipping + $tax, 2),
            'cart_count' => collect($cart)->sum('quantity'),
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate(['key' => ['required', 'string']]);

        $cart = session('cart', []);
        unset($cart[$request->key]);
        session(['cart' => $cart]);

        $subtotal = collect($cart)->sum('subtotal');
        $shipping = $subtotal > 100 ? 0 : 9.99;
        $tax = round($subtotal * 0.14, 2);

        return response()->json([
            'success' => true,
            'cart_count' => collect($cart)->sum('quantity'),
            'subtotal' => number_format($subtotal, 2),
            'shipping' => number_format($shipping, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($subtotal + $shipping + $tax, 2),
            'is_empty' => empty($cart),
        ]);
    }

    public function count()
    {
        return response()->json([
            'count' => collect(session('cart', []))->sum('quantity'),
        ]);
    }
}
