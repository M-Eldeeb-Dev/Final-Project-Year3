<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{

    public function checkout()
    {
        $cart     = session('cart', []);
        $subtotal = collect($cart)->sum('subtotal');
        $shipping = $subtotal > config('deepify.free_shipping_min', 100) ? 0 : config('deepify.shipping_cost', 9.99);
        $tax      = round($subtotal * config('deepify.tax_rate', 0.14), 2);
        $total    = round($subtotal + $shipping + $tax, 2);

        return view('checkout', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
    }


    public function store(StoreOrderRequest $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add items before checking out.');
        }

        $subtotal = collect($cart)->sum('subtotal');
        $shipping = $subtotal > config('deepify.free_shipping_min', 100) ? 0 : config('deepify.shipping_cost', 9.99);
        $tax      = round($subtotal * config('deepify.tax_rate', 0.14), 2);
        $total    = round($subtotal + $shipping + $tax, 2);


        $order = Order::create([
            'order_number'     => Order::generateOrderNumber(),
            'customer_name'    => $request->name,
            'customer_email'   => $request->email,
            'customer_phone'   => $request->phone,
            'shipping_address' => $request->address,
            'shipping_city'    => $request->city,
            'shipping_country' => $request->country,
            'shipping_zip'     => $request->zip_code,
            'shipping_cost'    => $shipping,
            'tax'              => $tax,
            'total'            => $total,
            'status'           => 'pending',
            'payment_method'   => $request->payment_method,
            'notes'            => $request->notes,
        ]);


        foreach ($cart as $item) {
            $order->items()->create([
                'product_id'     => $item['product_id'],
                'product_name'   => $item['name'],
                'product_price'  => $item['price'],
                'selected_size'  => $item['size']  ?? null,
                'selected_color' => $item['color'] ?? null,
                'quantity'       => $item['quantity'],
                'total'          => $item['subtotal'],
            ]);


            Product::where('id', $item['product_id'])
                ->where('stock', '>=', $item['quantity'])
                ->decrement('stock', $item['quantity']);
        }


        session()->forget('cart');

        return redirect()->route('order.success', $order->id);
    }


    public function success(Order $order)
    {

        $order->load('items.product');

        return view('order-success', compact('order'));
    }


    public function trackForm()
    {
        return view('orders.track');
    }


    public function track(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'order_number' => ['required', 'string'],
            'email'        => ['required', 'email'],
        ]);

        $order = Order::with('items.product')
            ->where('order_number', strtoupper(trim($request->order_number)))
            ->where('customer_email', strtolower(trim($request->email)))
            ->first();

        if (!$order) {
            return back()->withInput()->with('error', 'No order found matching that order number and email address. Please double-check your details.');
        }

        return view('orders.track', compact('order'));
    }
}
