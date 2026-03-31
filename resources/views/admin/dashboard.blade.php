@extends('layouts.admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- STATS ROW 1 -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 gold-border">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Products</p>
                <h3 class="text-24px font-bold text-gray-800 mt-1">{{ $stats['total_products'] }}</h3>
            </div>
            <div class="p-2 bg-blue-50 text-blue-500 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 gold-border">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Active Products</p>
                <h3 class="text-24px font-bold text-gray-800 mt-1">{{ $stats['active_products'] }}</h3>
            </div>
            <div class="p-2 bg-green-50 text-green-500 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 gold-border">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Orders</p>
                <h3 class="text-24px font-bold text-gray-800 mt-1">{{ $stats['total_orders'] }}</h3>
            </div>
            <div class="p-2 bg-purple-50 text-purple-500 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 gold-border">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Revenue</p>
                <h3 class="text-24px font-bold text-gray-800 mt-1">{!! formatPrice($stats['total_revenue']) !!}</h3>
            </div>
            <div class="p-2 bg-yellow-50 text-yellow-500 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-400">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Pending Orders</p>
                <h3 class="text-24px font-bold text-gray-800 mt-1">{{ $stats['pending_orders'] }}</h3>
            </div>
            <div class="p-2 bg-yellow-50 text-yellow-500 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 gold-border">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Customers</p>
                <h3 class="text-24px font-bold text-gray-800 mt-1">{{ $stats['total_customers'] }}</h3>
            </div>
            <div class="p-2 bg-indigo-50 text-indigo-500 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-400">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Unread Msgs</p>
                <h3 class="text-24px font-bold text-gray-800 mt-1">{{ $stats['unread_messages'] }}</h3>
            </div>
            <div class="p-2 bg-blue-50 text-blue-500 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-red-500">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Low Stock</p>
                <h3 class="text-24px font-bold text-gray-800 mt-1">{{ $stats['low_stock'] }}</h3>
            </div>
            <div class="p-2 bg-red-50 text-red-500 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- ROW 2 -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
    <!-- RECENT ORDERS -->
    <div class="lg:col-span-3 bg-white rounded-lg shadow-sm h-full">
        <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-lg">
            <h3 class="font-semibold text-gray-700">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-gold hover:text-[#b09038]">View All &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 bg-gray-50 uppercase border-b">
                    <tr>
                        <th class="px-4 py-3">Order
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recent_orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">#{{ $order->order_number }}</td>
                            <td class="px-4 py-3">{{ $order->customer_email }}</td>
                            <td class="px-4 py-3 font-semibold">{!! formatPrice($order->total) !!}</td>
                            <td class="px-4 py-3">
                                @php
                                    $bg = 'bg-gray-100 text-gray-800';
                                    if($order->status == 'pending') $bg = 'bg-yellow-100 text-yellow-800';
                                    if($order->status == 'processing') $bg = 'bg-blue-100 text-blue-800';
                                    if($order->status == 'shipped') $bg = 'bg-purple-100 text-purple-800';
                                    if($order->status == 'delivered') $bg = 'bg-green-100 text-green-800';
                                    if($order->status == 'cancelled') $bg = 'bg-red-100 text-red-800';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold uppercase {{ $bg }}">
                                    {{ $order->status }}
                               </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-gold hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- TOP SELLING PRODUCTS -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm h-full flex flex-col">
        <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg">
            <h3 class="font-semibold text-gray-700">Top Selling Products</h3>
        </div>
        <div class="p-4 flex-1">
            <ul class="space-y-4">
                @forelse($top_products as $index => $prod)
                    <li class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $index === 0 ? 'bg-gold text-white' : 'bg-gray-100 text-gray-600' }}">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <p class="text-sm font-medium text-gray-800 truncate w-40" title="{{ $prod->product_name }}">{{ $prod->product_name }}</p>
                                <p class="text-xs text-gray-500">{{ $prod->total_sold }} units sold</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">{!! formatPrice($prod->total_revenue) !!}</p>
                        </div>
                    </li>
                @empty
                    <li class="text-center text-gray-500 py-4">No sales data yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- ROW 3 -->
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg text-gray-700 font-semibold">
        Monthly Revenue ({{ date('Y') }})
    </div>
    <div class="p-6 overflow-x-auto no-scrollbar">
        <div class="flex items-end space-x-2 h-64 min-w-[600px]">
            @php
                $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                $maxRev = count($monthly_revenue) > 0 ? max($monthly_revenue->pluck('revenue')->toArray()) : 1;
                if ($maxRev == 0) $maxRev = 1;
                $revMap = $monthly_revenue->keyBy('month');
            @endphp

            @foreach(range(1, 12) as $m)
                @php
                    $rev = isset($revMap[$m]) ? $revMap[$m]->revenue : 0;
                    $ht = ($rev / $maxRev) * 100;
                    $isCurrent = $m == date('n');
                @endphp
                <div class="flex-1 flex flex-col items-center group relative">
                    <div class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap z-10">
                        ${{ number_format($rev, 2) }}
                    </div>
                    <div class="w-full bg-gray-100 rounded-t-sm flex items-end justify-center" style="height: 100%;">
                        <div class="w-full {{ $isCurrent ? 'bg-gold' : 'bg-gray-800' }} rounded-t-sm transition-all hover:opacity-80" style="height: {{ $ht }}%;"></div>
                    </div>
                    <span class="text-xs text-gray-500 mt-2 {{ $isCurrent ? 'font-bold text-gold' : '' }}">{{ $months[$m-1] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
