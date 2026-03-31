@extends('layouts.admin')
@section('page-title', 'Orders')

@section('content')
<div class="mb-6 flex space-x-2">
    @php
        $tabs = ['all' => 'All', 'pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
        $current = request('status', 'all');
    @endphp
    @foreach($tabs as $key => $label)
        @php
            $isActive = ($key === 'all' && empty(request('status'))) || $current === $key;
            $count = $key === 'all' ? array_sum($statusCounts->toArray()) : ($statusCounts[$key] ?? 0);
        @endphp
        <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => $key === 'all' ? null : $key])) }}"
           class="px-4 py-2 text-sm font-medium rounded-t-lg border-b-2 {{ $isActive ? 'border-gold text-gold bg-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
            {{ $label }} <span class="ml-1 px-2 py-0.5 rounded-full text-xs {{ $isActive ? 'bg-gold text-white' : 'bg-gray-100 text-gray-600' }}">{{ $count }}</span>
        </a>
    @endforeach
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg">
        <form method="GET" class="flex flex-wrap gap-4">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Order
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">From:</span>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="border-gray-300 rounded focus:border-[#C9A84C] text-sm px-3 py-1.5 border">
            </div>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">To:</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="border-gray-300 rounded focus:border-[#C9A84C] text-sm px-3 py-1.5 border">
            </div>
            <button type="submit" class="bg-gray-800 text-white px-4 py-1.5 rounded text-sm hover:bg-black transition-colors">Apply Filters</button>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700 text-sm px-2 py-1.5">Clear</a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 bg-gray-50 uppercase border-b">
                <tr>
                    <th class="px-4 py-3">Order
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Items</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">#{{ $order->order_number }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $order->customer_name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $order->customer_email }}</div>
                        </td>
                        <td class="px-4 py-3 text-center">{{ $order->items_count ?? $order->items->sum('quantity') }}</td>
                        <td class="px-4 py-3 font-semibold">${{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="text-xs px-2 py-1 rounded border-gray-300 focus:ring-gold bg-gray-50 font-semibold cursor-pointer border" :disabled="loading">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }} class="bg-white text-yellow-600">PENDING</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }} class="bg-white text-blue-600">PROCESSING</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }} class="bg-white text-purple-600">SHIPPED</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }} class="bg-white text-green-600">DELIVERED</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }} class="bg-white text-red-600">CANCELLED</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $order->created_at->format('M d, Y h:ia') }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900 text-xs font-semibold uppercase tracking-wider bg-blue-50 px-3 py-1.5 rounded transition">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
