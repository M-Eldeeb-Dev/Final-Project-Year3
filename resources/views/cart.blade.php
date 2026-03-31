@extends('layouts.app')

@section('title', 'Your Cart — Deepify')

@section('content')

<div class="bg-[var(--bg-2)] border-b border-[var(--border)] px-4 md:px-10 py-3">
    <div class="max-w-screen-xl mx-auto flex items-center gap-2 text-[11px] text-[var(--text-muted)] font-label">
        <a href="{{ route('home') }}" class="hover:text-brand transition-colors" data-i18n="breadcrumb-home">Home</a>
        <span class="material-symbols-outlined text-[14px] rtl-flip">chevron_right</span>
        <span class="text-[var(--text)]" data-i18n="your-cart">Your Cart</span>
    </div>
</div>

<div class="bg-[var(--bg-3)] border-b border-[var(--border)] px-4 md:px-10 py-8">
    <div class="max-w-screen-xl mx-auto">
        <div class="flex items-center gap-3 mb-1">
            <span class="text-[11px] text-brand font-label tracking-[0.5em] capitalize">Secure Checkout</span>
        </div>
        <h1 class="font-headline text-4xl md:text-6xl font-black capitalize tracking-tight text-[var(--text)]">
            <span data-i18n="your-cart">Your Cart</span><span class="text-brand">.</span>
        </h1>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 md:px-10 py-8 md:py-14">

    <div id="cart-empty" class="{{ count($cart) > 0 ? 'hidden' : '' }} text-center py-24 md:py-32">
        <span class="material-symbols-outlined text-6xl text-[var(--text-muted)] block mb-5">shopping_bag</span>
        <h2 class="font-headline text-2xl font-black capitalize tracking-tight text-[var(--text)] mb-3" data-i18n="empty-cart">Your cart is empty</h2>
        <p class="text-sm text-[var(--text-muted)] mb-8" data-i18n="empty-cart-sub">Discover our products and start shopping</p>
        <a href="{{ route('products.index') }}"
           class="inline-block shimmer-btn bg-brand text-black font-label font-bold text-[11px] tracking-[0.35em] capitalize px-10 py-4 hover:bg-lime-400 transition-all duration-300"
           data-i18n="shop-now">Shop Now</a>
    </div>

    <div id="cart-content" class="{{ count($cart) === 0 ? 'hidden' : '' }} flex flex-col lg:flex-row gap-10 lg:gap-16">

        <div class="flex-1">
            {{-- Table header --}}
            <div class="hidden md:grid grid-cols-12 gap-4 pb-4 border-b border-[var(--border)] text-[11px] font-label tracking-[0.3em] text-[var(--text-muted)] capitalize">
                <div class="col-span-5" data-i18n="cart-item">Item</div>
                <div class="col-span-2 text-center" data-i18n="cart-price">Price</div>
                <div class="col-span-2 text-center" data-i18n="cart-qty">Qty</div>
                <div class="col-span-2 text-end" data-i18n="cart-subtotal">Subtotal</div>
                <div class="col-span-1"></div>
            </div>

            {{-- Cart rows --}}
            @foreach($cart as $key => $item)
            <div class="group py-5 md:py-7 border-b border-[var(--border)] grid grid-cols-2 md:grid-cols-12 gap-4 items-center hover:bg-[var(--bg-2)]/50 transition-all duration-300 -mx-4 px-4"
                 data-cart-row>
                {{-- Image + name (mobile: col-span-2, desktop: col-span-5) --}}
                <div class="col-span-2 md:col-span-5 flex gap-4 items-start">
                    <div class="w-20 h-24 md:w-24 md:h-28 bg-[var(--bg-3)] border border-[var(--border)] relative overflow-hidden shrink-0">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                             class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition-all duration-500">
                        <div class="absolute inset-0 border border-brand/0 group-hover:border-brand/25 transition-all pointer-events-none"></div>
                    </div>
                    <div class="flex flex-col justify-center min-w-0">
                        <span class="text-[11px] font-label tracking-[0.3em] text-brand capitalize mb-1">{{ $item['category'] ?? '' }}</span>
                        <h3 class="font-headline text-sm capitalize tracking-wide text-[var(--text)] group-hover:text-brand transition-colors line-clamp-2 mb-1">
                            {{ $item['name'] }}
                        </h3>
                        @if(!empty($item['size']))
                        <span class="text-[11px] text-[var(--text-muted)] font-label tracking-widest capitalize">Size: {{ $item['size'] }}</span>
                        @endif
                        @if(!empty($item['color']))
                        <span class="text-[11px] text-[var(--text-muted)] font-label tracking-widest capitalize">Color: {{ $item['color'] }}</span>
                        @endif
                        {{-- Mobile price --}}
                        <span class="md:hidden font-headline text-base text-[var(--text)] mt-1">{!! formatPrice($item['price']) !!}</span>
                    </div>
                </div>

                {{-- Price (desktop only) --}}
                <div class="hidden md:flex col-span-2 justify-center font-headline text-sm text-[var(--text)]">
                    {!! formatPrice($item['price']) !!}
                </div>

                {{-- Qty stepper --}}
                <div class="md:col-span-2 flex justify-start md:justify-center">
                    <div class="flex items-center">
                        <button class="qty-btn" data-qty-btn="dec" data-key="{{ $key }}" aria-label="Decrease">
                            <span class="material-symbols-outlined text-[14px]">remove</span>
                        </button>
                        <div class="qty-display" data-qty-display>{{ $item['quantity'] }}</div>
                        <button class="qty-btn" data-qty-btn="inc" data-key="{{ $key }}" aria-label="Increase">
                            <span class="material-symbols-outlined text-[14px]">add</span>
                        </button>
                    </div>
                </div>

                {{-- Row subtotal --}}
                <div class="hidden md:flex col-span-2 justify-end font-headline text-sm text-[var(--text)]"
                     data-subtotal data-price="{{ $item['price'] }}">
                    {!! formatPrice($item['price'] * $item['quantity']) !!}
                </div>

                {{-- Remove button --}}
                <div class="flex justify-end md:col-span-1">
                    <button class="text-[var(--text-muted)] hover:text-red-400 transition-colors p-1"
                            data-remove-key="{{ $key }}" aria-label="Remove item">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            </div>
            @endforeach

            {{-- Cart actions --}}
            <div class="mt-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-2 text-[11px] font-label tracking-widest capitalize text-[var(--text-muted)] hover:text-brand transition-colors"
                   data-i18n="continue-shopping">
                    <span class="material-symbols-outlined text-sm rtl-flip">arrow_back</span>
                    Continue Shopping
                </a>
                <button onclick="location.reload()"
                        class="inline-flex items-center gap-2 text-[11px] font-label tracking-widest capitalize text-[var(--text-muted)] hover:text-brand transition-colors">
                    <span class="material-symbols-outlined text-sm">sync</span>
                    Refresh Cart
                </button>
            </div>
        </div>

        <div class="lg:w-80 xl:w-96 shrink-0">
            <div class="sticky top-[90px] bg-[var(--bg-2)] border border-[var(--border)] relative overflow-hidden">
                {{-- Scanning line --}}
                <div class="scanning-line absolute top-0 start-0 end-0"></div>

                <div class="p-6 border-b border-[var(--border)]">
                    <div class="flex items-center justify-between">
                        <h2 class="font-headline text-sm tracking-[0.3em] capitalize text-[var(--text)]" data-i18n="order-summary">Order Summary</h2>
                        <span class="text-[10px] text-brand/40 font-label tracking-widest">SECURE_v3</span>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Subtotal --}}
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-[var(--text-muted)] font-label text-[11px] tracking-widest capitalize" data-i18n="subtotal">Subtotal</span>
                        <span class="font-headline text-[var(--text)]" id="cart-subtotal">{!! formatPrice($subtotal) !!}</span>
                    </div>

                    {{-- Shipping --}}
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-[var(--text-muted)] font-label text-[11px] tracking-widest capitalize" data-i18n="shipping">Shipping</span>
                        @if($shipping == 0)
                        <span class="font-label text-[11px] tracking-widest text-green-500 capitalize" id="cart-shipping" data-i18n="free">FREE</span>
                        @else
                        <span class="font-headline text-[var(--text)]" id="cart-shipping">{!! formatPrice($shipping) !!}</span>
                        @endif
                    </div>

                    {{-- Tax --}}
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-[var(--text-muted)] font-label text-[11px] tracking-widest capitalize" data-i18n="tax">Tax (14%)</span>
                        <span class="font-headline text-[var(--text)]" id="cart-tax">{!! formatPrice($tax) !!}</span>
                    </div>

                    {{-- Free shipping progress --}}
                    @if($subtotal < 100)
                    <div class="pt-2">
                        <div class="flex justify-between text-[10px] font-label tracking-widest capitalize text-[var(--text-muted)] mb-1">
                            <span>Add {!! formatPrice(100 - $subtotal) !!} more for free shipping</span>
                        </div>
                        <div class="h-1 bg-[var(--bg-3)] w-full">
                            <div class="h-full bg-brand transition-all duration-500" style="width: {{ min(100, ($subtotal / 100) * 100) }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Total --}}
                <div class="px-6 py-5 border-t border-[var(--border)]">
                    <div class="flex justify-between items-end mb-5">
                        <span class="font-label text-[11px] tracking-[0.4em] text-[var(--text-muted)] capitalize" data-i18n="total">Total</span>
                        <span class="font-headline text-3xl text-brand" id="cart-total">{!! formatPrice($total) !!}</span>
                    </div>

                    <a href="{{ route('checkout') }}"
                       class="block w-full text-center shimmer-btn bg-brand text-black font-label font-bold text-[11px] tracking-[0.4em] capitalize py-4 hover:bg-lime-400 transition-all duration-300 active:scale-[0.98] mb-3"
                       data-i18n="proceed">Proceed to Checkout</a>

                    <a href="{{ route('orders.track') }}"
                       class="block w-full text-center bg-transparent border border-[var(--border)] text-[var(--text)] font-label font-bold text-[11px] tracking-[0.4em] capitalize py-3 hover:border-brand hover:text-brand transition-all duration-300 active:scale-[0.98]">
                        Track Existing Order
                    </a>

                    {{-- Trust badges --}}
                    <div class="mt-5 flex justify-center gap-5 opacity-30 hover:opacity-60 transition-opacity">
                        <span class="material-symbols-outlined text-xl">verified_user</span>
                        <span class="material-symbols-outlined text-xl">lock</span>
                        <span class="material-symbols-outlined text-xl">payments</span>
                    </div>

                    {{-- Security note --}}
                    <div class="mt-4 flex items-start gap-2 text-[10px] text-[var(--text-muted)] font-label tracking-widest capitalize leading-relaxed">
                        <span class="material-symbols-outlined text-brand text-sm mt-0.5">terminal</span>
                        Transactions secured via 256-bit encryption. Data never stored on our servers.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
