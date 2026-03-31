<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\ContactMessage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'  => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_orders'    => Order::count(),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'total_revenue'   => Order::whereIn('status', ['processing','shipped','delivered'])->sum('total'),
            'total_customers' => User::where('role', 'customer')->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'low_stock'       => Product::where('stock', '<=', 5)->where('is_active', true)->count(),
        ];

        $recent_orders = Order::with('items')->latest()->take(8)->get();

        $top_products = \Illuminate\Support\Facades\DB::table('order_items')
            ->select('product_name',
                     \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_sold'),
                     \Illuminate\Support\Facades\DB::raw('SUM(total) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)->get();

        $monthly_revenue = Order::whereIn('status', ['processing','shipped','delivered'])
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products', 'monthly_revenue'));
    }
}
