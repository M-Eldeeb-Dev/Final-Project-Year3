<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->withCount('items')
            ->when(request('status'),  fn($q) => $q->where('status', request('status')))
            ->when(request('search'),  fn($q) =>
                $q->where('order_number', 'like', '%'.request('search').'%')
                  ->orWhere('customer_email', 'like', '%'.request('search').'%'))
            ->when(request('date_from'), fn($q) => $q->whereDate('created_at', '>=', request('date_from')))
            ->when(request('date_to'),   fn($q) => $q->whereDate('created_at', '<=', request('date_to')))
            ->latest()->paginate(20)->withQueryString();

        $statusCounts = Order::selectRaw('status, COUNT(*) as count')
                          ->groupBy('status')->pluck('count', 'status');

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:pending,processing,shipped,delivered,cancelled'],
        ]);

        $old = $order->status;
        $order->update(['status' => $request->status]);

        return back()->with('success', "Order status changed from {$old} to {$request->status}.");
    }
}
