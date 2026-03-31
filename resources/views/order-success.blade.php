@extends('layouts.app')

@section('title', 'Order Confirmed — Deepify')

@section('content')

<div class="min-h-[80vh] flex items-center justify-center px-4 py-16 md:py-24 grid-bg">
    <div class="max-w-2xl w-full bg-[var(--bg-2)] border border-[var(--border)] relative" data-animate>
        <div class="absolute top-0 start-0 w-2 h-2 bg-brand"></div>
        <div class="absolute top-0 end-0 w-2 h-2 bg-brand"></div>
        <div class="absolute bottom-0 start-0 w-2 h-2 bg-brand"></div>
        <div class="absolute bottom-0 end-0 w-2 h-2 bg-brand"></div>

        <div class="p-8 md:p-12 text-center border-b border-[var(--border)]">
            <div class="w-20 h-20 bg-brand/10 border border-brand/30 rounded-full flex items-center justify-center mx-auto mb-8">
                <span class="material-symbols-outlined text-4xl text-brand">check_circle</span>
            </div>
            <h1 class="font-headline text-3xl md:text-5xl font-black capitalize tracking-tight text-[var(--text)] mb-4" data-i18n="order-confirmed">
                Order Confirmed
            </h1>
            <p class="text-[var(--text-muted)] text-[12px] tracking-[0.2em] capitalize mb-8" data-i18n="order-thank-you">
                Thank you for your purchase. Your order has been received and is being processed.
            </p>
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-[var(--bg-3)] border border-[var(--border)]">
                <span class="text-[11px] font-label tracking-[0.3em] text-[var(--text-muted)] capitalize" data-i18n="status">Status</span>
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span class="text-[11px] font-headline font-bold text-amber-400 tracking-widest capitalize">{{ ucfirst($order->status) }}</span>
            </div>
        </div>

        <div class="px-8 py-10 md:px-12 bg-[var(--bg-3)]/30">
            <h2 class="font-headline text-[11px] tracking-[0.4em] text-brand capitalize mb-8">Order Logistics</h2>
            
            <div class="grid grid-cols-2 gap-y-8 gap-x-12">
                <div>
                    <h3 class="font-label text-[11px] tracking-[0.3em] text-[var(--text-muted)] capitalize mb-2">Order Index</h3>
                    <p class="font-headline text-sm text-[var(--text)] tracking-widest">{{ $order->order_number }}</p>
                </div>
                <div>
                    <h3 class="font-label text-[11px] tracking-[0.3em] text-[var(--text-muted)] capitalize mb-2">Timestamp</h3>
                    <p class="font-label text-xs text-[var(--text)]">{{ $order->created_at->format('M d, Y — H:i') }}</p>
                </div>
                <div>
                    <h3 class="font-label text-[11px] tracking-[0.3em] text-[var(--text-muted)] capitalize mb-2">Recipient</h3>
                    <p class="font-label text-xs text-[var(--text)] capitalize">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <h3 class="font-label text-[11px] tracking-[0.3em] text-[var(--text-muted)] capitalize mb-2">Payment Point</h3>
                    <p class="font-label text-xs text-[var(--text)] capitalize">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Credit Card' }}</p>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-[var(--border)] flex flex-col sm:flex-row gap-4 items-center justify-between">
                <div class="text-center sm:text-start">
                    <p class="text-[11px] font-label tracking-[0.3em] text-[var(--text-muted)] mb-1 uppercase">Total Settlement</p>
                    <p class="font-headline text-2xl text-[var(--text)]">${{ number_format($order->total, 2) }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('orders.track') }}?order_number={{ $order->order_number }}"
                       class="text-[11px] font-label tracking-[0.3em] text-brand hover:text-white px-6 py-3 border border-brand hover:bg-brand transition-all capitalize text-center">
                        Track Order
                    </a>
                    <a href="{{ route('home') }}"
                       class="text-[11px] font-label tracking-[0.3em] text-[var(--text-muted)] hover:text-brand px-6 py-3 border border-transparent hover:border-brand transition-all capitalize"
                       data-i18n="back-home">Back Home</a>
                    <a href="{{ route('products.index') }}"
                       class="shimmer-btn bg-brand text-black font-label font-bold text-[11px] tracking-[0.35em] capitalize px-10 py-4 hover:bg-lime-400 transition-all duration-300 text-center"
                       data-i18n="continue-shopping">Continue Shopping</a>
                </div>
            </div>
        </div>
        
        <p class="text-center text-[11px] text-[var(--text-muted)] font-label tracking-widest capitalize py-6 opacity-40">
            Order Authentication: {{ strtoupper(bin2hex(random_bytes(6))) }} &nbsp;·&nbsp; Deepify Network
        </p>
    </div>
</div>

@endsection
