@extends('layouts.app')

@section('title', 'Track Your Order — Deepify')
@section('meta-desc', 'Track the status of your Deepify order in real-time. Enter your order number and email to view your delivery progress.')

@section('content')
<div class="min-h-[80vh] px-4 py-16 md:py-24 max-w-screen-lg mx-auto">


    <div class="text-center mb-14" data-animate>
        <span class="text-[11px] text-brand font-label tracking-[0.5em] uppercase flex items-center justify-center gap-2 mb-4">
            <span class="w-1.5 h-1.5 bg-brand"></span> Order Intelligence <span class="w-1.5 h-1.5 bg-brand"></span>
        </span>
        <h1 class="font-headline text-4xl md:text-6xl font-black capitalize tracking-tight text-[var(--text)] mb-4">Track Your Order</h1>
        <p class="text-[var(--text-muted)] text-sm max-w-md mx-auto">Enter your order number and the email used at checkout to see real-time delivery status.</p>
    </div>


    <div class="bg-[var(--bg-2)] border border-[var(--border)] p-8 md:p-10 mb-10 relative" data-animate>
        <div class="absolute top-0 start-0 w-2 h-2 bg-brand"></div>
        <div class="absolute top-0 end-0 w-2 h-2 bg-brand"></div>
        <div class="absolute bottom-0 start-0 w-2 h-2 bg-brand"></div>
        <div class="absolute bottom-0 end-0 w-2 h-2 bg-brand"></div>

        @if(session('error'))
            <div class="flex items-center gap-3 bg-red-500/10 border border-red-500/30 text-red-400 text-sm px-5 py-3 mb-6 font-label">
                <span class="material-symbols-outlined text-base shrink-0">error</span>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('orders.track.search') }}" class="flex flex-col md:flex-row gap-4">
            @csrf
            <div class="flex-1">
                <label class="block text-[11px] font-label tracking-[0.3em] text-[var(--text-muted)] uppercase mb-2">Order Number</label>
                <input type="text" name="order_number" value="{{ old('order_number') }}" placeholder="e.g. DP-2026-00001"
                       class="w-full bg-[var(--bg-3)] border border-[var(--border)] text-[var(--text)] px-4 py-3 text-sm font-label focus:outline-none focus:border-brand transition-colors placeholder:text-[var(--text-muted)]"
                       required>
                @error('order_number')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex-1">
                <label class="block text-[11px] font-label tracking-[0.3em] text-[var(--text-muted)] uppercase mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com"
                       class="w-full bg-[var(--bg-3)] border border-[var(--border)] text-[var(--text)] px-4 py-3 text-sm font-label focus:outline-none focus:border-brand transition-colors placeholder:text-[var(--text-muted)]"
                       required>
                @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-end">
                <button type="submit"
                        class="shimmer-btn bg-brand text-black font-label font-bold text-[11px] tracking-[0.35em] uppercase px-10 py-3 hover:bg-lime-400 transition-all duration-300 w-full md:w-auto whitespace-nowrap">
                    Track Order
                </button>
            </div>
        </form>
    </div>


    @isset($order)
    <div data-animate>

        <div class="bg-[var(--bg-2)] border border-[var(--border)] p-6 md:p-8 mb-6 flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <p class="text-[11px] font-label tracking-[0.3em] text-brand uppercase mb-1">Order Number</p>
                <h2 class="font-headline text-2xl md:text-3xl font-black text-[var(--text)]">{{ $order->order_number }}</h2>
                <p class="text-[var(--text-muted)] text-xs font-label mt-1">Placed on {{ $order->created_at->format('F j, Y \a\t H:i') }}</p>
            </div>
            <div class="text-start md:text-end">
                <p class="text-[11px] font-label tracking-[0.3em] text-[var(--text-muted)] uppercase mb-1">Order Total</p>
                <p class="font-headline text-2xl text-[var(--text)]">${{ number_format($order->total, 2) }}</p>
                <p class="text-[var(--text-muted)] text-xs font-label mt-1">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Credit Card' }}</p>
            </div>
        </div>


        @php
            $allStatuses = [
                'pending'    => ['label' => 'Order Placed',   'icon' => 'receipt_long',      'desc' => 'We have received your order and are preparing it.'],
                'processing' => ['label' => 'Processing',     'icon' => 'inventory_2',       'desc' => 'Your order is being packed and prepared for shipment.'],
                'shipped'    => ['label' => 'Shipped',        'icon' => 'local_shipping',    'desc' => 'Your order is on its way to the delivery address.'],
                'delivered'  => ['label' => 'Delivered',      'icon' => 'check_circle',      'desc' => 'Your order has been delivered. Enjoy!'],
                'cancelled'  => ['label' => 'Cancelled',      'icon' => 'cancel',            'desc' => 'This order has been cancelled.'],
            ];

            $statusFlow   = ['pending', 'processing', 'shipped', 'delivered'];
            $currentStatus = $order->status;
            $isCancelled   = $currentStatus === 'cancelled';
            $currentStep   = $isCancelled ? -1 : array_search($currentStatus, $statusFlow);
        @endphp

        <div class="bg-[var(--bg-2)] border border-[var(--border)] p-6 md:p-10 mb-6">
            <h3 class="font-label text-[11px] tracking-[0.4em] text-brand uppercase mb-10">Delivery Status</h3>

            @if($isCancelled)
                <div class="flex items-center gap-4 bg-red-500/10 border border-red-500/20 px-6 py-5">
                    <span class="material-symbols-outlined text-3xl text-red-400">cancel</span>
                    <div>
                        <p class="font-headline text-lg font-bold text-red-400">Order Cancelled</p>
                        <p class="text-sm text-[var(--text-muted)] font-label mt-1">{{ $allStatuses['cancelled']['desc'] }}</p>
                    </div>
                </div>
            @else

                <div class="relative">

                    <div class="absolute top-6 start-0 end-0 h-px bg-[var(--border)] hidden md:block" style="left: 10%; right: 10%;"></div>
                    <div class="absolute top-6 start-0 h-px bg-brand transition-all duration-700 hidden md:block"
                         style="left: 10%; width: {{ $currentStep >= 0 ? ($currentStep / (count($statusFlow) - 1)) * 80 : 0 }}%;"></div>


                    <div class="flex flex-col md:flex-row justify-between gap-8 md:gap-0">
                        @foreach($statusFlow as $i => $status)
                            @php
                                $info      = $allStatuses[$status];
                                $isDone    = $i <= $currentStep;
                                $isCurrent = $i === $currentStep;
                            @endphp
                            <div class="flex md:flex-col items-center md:items-center gap-4 md:gap-3 flex-1 text-start md:text-center relative">

                                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 border-2 transition-all duration-500 z-10
                                    {{ $isDone
                                        ? 'bg-brand border-brand text-black'
                                        : 'bg-[var(--bg-3)] border-[var(--border)] text-[var(--text-muted)]'
                                    }}
                                    {{ $isCurrent ? 'ring-4 ring-brand/20 scale-110' : '' }}">
                                    <span class="material-symbols-outlined text-xl {{ $isDone ? 'filled' : '' }}">{{ $info['icon'] }}</span>
                                </div>

                                <div>
                                    <p class="font-headline font-bold text-sm {{ $isDone ? 'text-[var(--text)]' : 'text-[var(--text-muted)]' }} {{ $isCurrent ? 'text-brand' : '' }}">
                                        {{ $info['label'] }}
                                    </p>
                                    <p class="text-[11px] font-label text-[var(--text-muted)] mt-1 max-w-[150px] mx-auto leading-relaxed hidden md:block">
                                        {{ $info['desc'] }}
                                    </p>
                                    @if($isCurrent)
                                        <span class="inline-block mt-2 px-2 py-0.5 bg-brand/10 border border-brand/30 text-brand text-[10px] font-label tracking-widest uppercase">
                                            Current
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="mt-10 bg-[var(--bg-3)] border border-brand/20 px-6 py-5 flex items-start gap-4">
                    <span class="material-symbols-outlined text-2xl text-brand shrink-0 mt-0.5">info</span>
                    <div>
                        <p class="font-headline font-bold text-sm text-[var(--text)] capitalize mb-1">{{ $allStatuses[$currentStatus]['label'] }}</p>
                        <p class="text-sm text-[var(--text-muted)] font-label leading-relaxed">{{ $allStatuses[$currentStatus]['desc'] }}</p>
                    </div>
                </div>
            @endif
        </div>


        <div class="grid md:grid-cols-2 gap-6 mb-6">

            <div class="bg-[var(--bg-2)] border border-[var(--border)] p-6">
                <h3 class="font-label text-[11px] tracking-[0.4em] text-brand uppercase mb-5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">home</span> Shipping Address
                </h3>
                <div class="text-sm text-[var(--text-muted)] font-label leading-loose">
                    <p class="text-[var(--text)] font-semibold mb-1">{{ $order->customer_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_zip }}</p>
                    <p>{{ $order->shipping_country }}</p>
                </div>
            </div>


            <div class="bg-[var(--bg-2)] border border-[var(--border)] p-6">
                <h3 class="font-label text-[11px] tracking-[0.4em] text-brand uppercase mb-5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">receipt</span> Order Summary
                </h3>
                <div class="space-y-2 text-sm font-label text-[var(--text-muted)]">
                    @foreach($order->items as $item)
                        <div class="flex justify-between py-1 border-b border-[var(--border)]">
                            <span class="text-[var(--text)]">{{ $item->product_name }} <span class="text-[var(--text-muted)] text-xs">×{{ $item->quantity }}</span></span>
                            <span>${{ number_format($item->total, 2) }}</span>
                        </div>
                    @endforeach
                    <div class="flex justify-between py-1">
                        <span>Shipping</span>
                        <span>{{ $order->shipping_cost == 0 ? 'Free' : '$'.number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Tax</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-t border-[var(--border)] font-bold text-[var(--text)] text-base">
                        <span>Total</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="bg-[var(--bg-2)] border border-[var(--border)] p-6">
            <h3 class="font-label text-[11px] tracking-[0.4em] text-brand uppercase mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">inventory_2</span> Order Items
            </h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center gap-5 py-4 border-b border-[var(--border)] last:border-0">
                    <div class="w-16 h-20 bg-[var(--bg-3)] border border-[var(--border)] overflow-hidden shrink-0">
                        @if($item->product && $item->product->image_url)
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-[var(--text-muted)]">
                                <span class="material-symbols-outlined text-2xl">image</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-headline font-bold text-sm text-[var(--text)] truncate">{{ $item->product_name }}</p>
                        <div class="flex items-center gap-3 mt-1 text-[var(--text-muted)] text-xs font-label">
                            @if($item->selected_size)<span>Size: {{ $item->selected_size }}</span>@endif
                            @if($item->selected_color)<span>Color: {{ $item->selected_color }}</span>@endif
                            <span>Qty: {{ $item->quantity }}</span>
                        </div>
                    </div>
                    <div class="text-end shrink-0">
                        <p class="font-headline text-sm text-[var(--text)]">${{ number_format($item->total, 2) }}</p>
                        <p class="text-xs text-[var(--text-muted)] font-label mt-1">${{ number_format($item->product_price, 2) }} each</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
    @endisset


    <div class="text-center mt-14" data-animate>
        <p class="text-sm text-[var(--text-muted)] font-label mb-4">Need help with your order?</p>
        <a href="{{ route('contact') }}"
           class="inline-flex items-center gap-2 text-[11px] font-label tracking-[0.3em] text-brand border border-brand px-8 py-3 hover:bg-brand hover:text-black transition-all duration-300 uppercase">
            <span class="material-symbols-outlined text-sm">mail</span> Contact Support
        </a>
    </div>
</div>
@endsection
