@extends('layouts.admin')
@section('page-title')
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-gray-600">&larr; Back</a>
        <span>Order Details</span>
    </div>
@endsection

@section('content')
<div class="flex flex-col lg:flex-row gap-6">
    <!-- LEFT -->
    <div class="lg:w-[65%] space-y-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border-t-4 border-gold">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Order
                    <p class="text-gray-500 text-sm mt-1">{{ $order->created_at->format('M d, Y h:i a') }}</p>
                </div>
                <div>
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center space-x-2">
                        @csrf @method('PATCH')
                        <span class="text-sm text-gray-500">Status:</span>
                        <select name="status" class="px-3 py-1.5 border border-gray-300 rounded focus:ring-gold text-sm font-semibold">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="bg-gray-800 text-white px-4 py-1.5 rounded text-sm hover:bg-black transition hover:shadow-md">Update</button>
                    </form>
                </div>
            </div>

            <h3 class="font-bold text-lg text-gray-700 mb-4 border-b pb-2">Order Items</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left mb-6">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-2">Item</th>
                            <th class="px-4 py-2">Details</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Qty</th>
                            <th class="px-4 py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center overflow-hidden border">
                                    @if($item->product && $item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs text-gray-400">Img</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-800">{{ $item->product_name }}</div>
                                <div class="text-xs text-gray-500 space-x-2 mt-1">
                                    @if($item->selected_size) <span>Size: <strong class="text-gray-700">{{ $item->selected_size }}</strong></span> @endif
                                    @if($item->selected_color) <span>Color: <strong class="text-gray-700">{{ $item->selected_color }}</strong></span> @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">${{ number_format($item->product_price, 2) }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-700">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-right font-bold text-gray-800">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end">
                <div class="w-64 space-y-3">
                    <div class="flex justify-between text-gray-600 border-b pb-2">
                        <span>Items Subtotal:</span>
                        <span>${{ number_format($order->items->sum('subtotal'), 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold text-gray-900 pt-2">
                        <span>Total:</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div class="lg:w-[35%] space-y-6">
        <div class="bg-white rounded-lg shadow-sm p-6 border-l-2 border-gray-300">
            <h3 class="font-bold text-gray-700 mb-4 flex items-center"><svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Customer Info</h3>
            <div class="text-sm space-y-2 text-gray-600 mb-6">
                <p><span class="text-gray-400 mr-2">Name:</span> <strong class="text-gray-800">{{ $order->customer_name ?? 'N/A' }}</strong></p>
                <p><span class="text-gray-400 mr-2">Email:</span> <a href="mailto:{{ $order->customer_email }}" class="text-gold hover:underline">{{ $order->customer_email }}</a></p>
                <p><span class="text-gray-400 mr-2">Phone:</span> <strong class="text-gray-800">{{ $order->customer_phone ?? 'N/A' }}</strong></p>
                @if($order->user_id)
                    <p class="pt-2"><a href="{{ route('admin.users.show', $order->user_id) }}" class="text-xs text-blue-500 hover:underline">View User Profile &rarr;</a></p>
                @endif
            </div>

            <h3 class="font-bold text-gray-700 mb-4 flex items-center"><svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg> Shipping Address</h3>
            <div class="text-sm text-gray-600 p-4 bg-gray-50 rounded border border-gray-100 leading-relaxed">
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_zip }}<br>
                {{ $order->shipping_country }}
            </div>

            @if($order->notes)
            <h3 class="font-bold text-gray-700 mb-2 mt-6">Order Notes</h3>
            <div class="text-sm text-gray-600 p-4 bg-yellow-50 rounded border border-yellow-100 italic">
                "{{ $order->notes }}"
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
