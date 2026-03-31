@extends('layouts.admin')
@section('page-title', 'Orders')

@section('content')
<div class="mb-8 flex flex-nowrap overflow-x-auto no-scrollbar border-b border-gray-100 gap-2">
    @php
        $tabs = ['all' => 'All Orders', 'pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
        $current = request('status', 'all');
    @endphp
    @foreach($tabs as $key => $label)
        @php
            $isActive = ($key === 'all' && empty(request('status'))) || $current === $key;
            $count = $key === 'all' ? array_sum($statusCounts->toArray()) : ($statusCounts[$key] ?? 0);
        @endphp
        <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => $key === 'all' ? null : $key])) }}"
           class="px-5 py-3 text-xs font-bold uppercase tracking-widest transition-all whitespace-nowrap {{ $isActive ? 'border-b-2 border-gold text-gold bg-gold/5' : 'text-gray-400 hover:text-gray-700' }}">
            {{ $label }} 
            <span class="ml-2 px-1.5 py-0.5 rounded text-[10px] {{ $isActive ? 'bg-gold text-black' : 'bg-gray-100 text-gray-500' }}">{{ $count }}</span>
        </a>
    @endforeach
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- FILTER BAR --}}
    <div class="p-5 border-b border-gray-100 bg-white">
        <form method="GET" class="flex flex-col lg:flex-row lg:items-center gap-6">
            <input type="hidden" name="status" value="{{ request('status') }}">
            
            {{-- Search Field --}}
            <div class="flex-1 relative group">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-gold transition-colors">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by number, customer or email..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:bg-white focus:border-gold focus:ring-4 focus:ring-gold/5 outline-none transition-all">
            </div>

            <div class="flex flex-wrap items-center gap-4">
                {{-- Date Range --}}
                <div class="flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-1 gap-3">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">From</span>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-transparent border-none text-sm p-1 focus:ring-0 outline-none text-gray-700">
                    </div>
                    <div class="w-px h-6 bg-gray-200"></div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">To</span>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-transparent border-none text-sm p-1 focus:ring-0 outline-none text-gray-700">
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2 ms-auto">
                    <button type="submit" class="bg-[#0A0A0A] text-white px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-black hover:shadow-lg transition-all active:scale-95">
                        Apply Filters
                    </button>
                    @if(request()->anyFilled(['search', 'date_from', 'date_to']))
                        <a href="{{ route('admin.orders.index', ['status' => request('status')]) }}" class="text-gray-400 hover:text-red-500 text-xs font-bold uppercase tracking-widest px-3 py-2.5 transition-colors">
                            Clear
                        </a>
                    @endif
                </div>
            </div>
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
                        <td class="px-4 py-3 font-semibold">{!! formatPrice($order->total) !!}</td>
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
