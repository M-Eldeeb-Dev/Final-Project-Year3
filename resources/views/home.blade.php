@extends('layouts.app')

@section('title', 'Deepify — Wear the Future')
@section('meta-desc', 'Deepify — Futuristic streetwear and fashion for the next generation. Shop hoodies, jackets,
    sneakers and accessories.')

@section('content')

    {{-- ════════════════════════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════════════════════════ --}}
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden grid-bg">

        {{-- Background gradient decoration --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/3 start-1/4 w-96 h-96 bg-brand/5 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-1/4 end-1/4 w-72 h-72 bg-lime-500/10 rounded-full blur-[100px]"></div>
            {{-- Architectural corner markers --}}
            <div class="absolute top-8 start-8 w-16 h-16 border-t-2 border-s-2 border-brand/30 hidden lg:block"></div>
            <div class="absolute top-8 end-8 w-16 h-16 border-t-2 border-e-2 border-brand/30 hidden lg:block"></div>
            <div class="absolute bottom-8 start-8 w-16 h-16 border-b-2 border-s-2 border-brand/30 hidden lg:block"></div>
            <div class="absolute bottom-8 end-8 w-16 h-16 border-b-2 border-e-2 border-brand/30 hidden lg:block"></div>
        </div>

        <div class="relative z-10 text-center px-6 max-w-5xl mx-auto" data-animate>

            {{-- Headline --}}
            <h1
                class="font-headline text-5xl sm:text-7xl md:text-8xl lg:text-9xl font-black tracking-tight text-[var(--text)] leading-none capitalize mb-6">
                <span class="block" data-i18n="hero-title">Wear the<br>Future.</span>
            </h1>

            {{-- Sub --}}
            <p class="text-sm md:text-base text-[var(--text-muted)] tracking-[0.3em] mb-12 max-w-xl mx-auto capitalize"
                data-i18n="hero-sub">
                Engineered for the next dimension of style.
            </p>

            {{-- CTAs --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('products.index') }}"
                    class="shimmer-btn pulse-glow bg-brand text-black font-label font-bold text-[11px] tracking-[0.35em] capitalize px-10 py-4 hover:bg-lime-400 transition-all duration-300 active:scale-95"
                    data-i18n="shop-now">Shop Now</a>
                <a href="{{ route('products.index') }}"
                    class="border border-[var(--border)] bg-white/5 text-[var(--text)] font-label text-[11px] tracking-[0.35em] capitalize px-10 py-4 hover:border-brand hover:text-brand transition-all duration-300"
                    data-i18n="explore">Explore Collections</a>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 start-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-40">
            <div class="w-px h-12 bg-gradient-to-b from-brand to-transparent"></div>
            <span class="font-label text-[10px] tracking-[0.5em] text-brand capitalize">SCROLL</span>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════
     BRAND STRIP
════════════════════════════════════════════════════════════════ --}}
    <div class="border-y border-[var(--border)] dark:border-white/5 bg-[var(--bg-3)] py-3">
        <div class="marquee-wrap">
            <div class="marquee-track text-[11px] font-label tracking-[0.4em] text-[var(--text-muted)] capitalize">
                @for ($i = 0; $i < 8; $i++)
                    <span class="px-6" data-i18n="free-shipping">FREE SHIPPING</span>
                    <span class="text-brand px-3">·</span>
                    <span class="px-6" data-i18n="returns">FREE RETURNS</span>
                    <span class="text-brand px-3">·</span>
                    <span class="px-6" data-i18n="secure">SECURE CHECKOUT</span>
                    <span class="text-brand px-3">·</span>
                    <span class="px-6" data-i18n="worldwide">WORLDWIDE DELIVERY</span>
                    <span class="text-brand px-3">·</span>
                @endfor
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════
     CATEGORIES SECTION
════════════════════════════════════════════════════════════════ --}}
    <section class="px-4 md:px-10 py-16 md:py-24 max-w-screen-xl mx-auto">
        <div class="flex items-end justify-between mb-10" data-animate>
            <div>
                <span class="text-[11px] text-brand font-label tracking-[0.5em] capitalize flex items-center gap-2 mb-2">
                    <span class="w-1.5 h-1.5 bg-brand"></span> Synchronized Units
                </span>
                <h2 class="font-headline text-3xl md:text-4xl font-black tracking-tight text-[var(--text)] capitalize"
                    data-i18n="categories">Collections</h2>
            </div>
            <a href="{{ route('products.index') }}"
                class="text-[11px] font-label tracking-widest text-brand capitalize hover:underline md:block">
                View All →
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-12 gap-px bg-[var(--border)]">
            @foreach ($categories->take(4) as $idx => $cat)
                @php
                    $colSpan = $idx === 0 ? 'md:col-span-6' : 'md:col-span-2';
                    $aspect = $idx === 0 ? 'aspect-[4/3]' : 'aspect-square';
                @endphp
                {{-- Category Card --}}
                <a href="{{ route('products.index') }}?category={{ $cat->slug }}"
                    class="group relative {{ $colSpan }} {{ $aspect }} overflow-hidden bg-[var(--bg-2)] card-glow transition-all duration-500 block">
                    <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}"
                        class="product-img w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 start-0 p-5 md:p-7">
                        <span class="text-[11px] font-label tracking-[0.5em] text-brand capitalize block mb-1">
                            {{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                        <h3 class="font-headline text-white text-lg md:text-2xl capitalize tracking-widest leading-none">
                            {{ $cat->name }}
                        </h3>
                        <div class="mt-2 h-px w-0 group-hover:w-12 bg-brand transition-all duration-500"></div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════
     FEATURED PRODUCTS
════════════════════════════════════════════════════════════════ --}}
    <section class="px-4 md:px-10 py-12 md:py-20 bg-[var(--bg-3)] border-y border-[var(--border)]">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex items-end justify-between mb-10" data-animate>
                <div>
                    <span
                        class="text-[11px] text-brand font-label tracking-[0.5em] capitalize flex items-center gap-2 mb-3">
                        <span class="w-2 h-2 bg-brand animate-pulse"></span> 02 — Featured Units
                    </span>
                    <h2 class="font-headline text-3xl md:text-4xl font-black tracking-tight text-[var(--text)] capitalize"
                        data-i18n="featured">Featured Products</h2>
                </div>
                <a href="{{ route('products.index') }}?sort=featured"
                    class="text-[10px] font-label tracking-widest text-brand capitalize hover:underline hidden md:block">View
                    All →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-px bg-[var(--border)]">
                @forelse($featured as $product)
                    <div class="group bg-[var(--bg-2)] card-glow transition-all duration-500 flex flex-col" data-animate>
                        {{-- Image --}}
                        <a href="{{ route('products.show', $product) }}"
                            class="relative aspect-[3/4] overflow-hidden block clip-corner">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="product-img w-full h-full object-cover">
                            {{-- Badges --}}
                            <div class="absolute top-3 start-3 flex flex-col gap-1">
                                @if ($product->is_featured)
                                    <span
                                        class="bg-brand text-black text-[10px] px-2 py-0.5 font-label font-bold capitalize tracking-widest"
                                        data-i18n="featured-sort">Featured</span>
                                @endif
                                @if ($product->sale_price)
                                    <span
                                        class="bg-red-500 text-white text-[10px] px-2 py-0.5 font-label font-bold capitalize"
                                        data-i18n="on-sale">Sale</span>
                                @endif
                            </div>
                        </a>

                        {{-- Wishlist --}}
                        <button
                            class="absolute top-3 end-3 w-8 h-8 bg-black/40 backdrop-blur-sm flex items-center justify-center text-white/70 hover:text-brand transition-colors z-10"
                            onclick="event.preventDefault(); toggleWishlist({{ $product->id }}, this)" aria-label="Add to wishlist">
                            <span class="material-symbols-outlined text-sm {{ in_array($product->id, session('wishlist', [])) ? 'filled-icon text-brand' : '' }}">favorite</span>
                        </button>

                        {{-- Info --}}
                        <div class="p-4 md:p-5 flex flex-col flex-1 relative">
                            <span
                                class="text-[11px] font-label tracking-[0.3em] text-brand capitalize mb-1">{{ $product->category->name ?? '' }}</span>
                            <a href="{{ route('products.show', $product) }}">
                                <h3
                                    class="font-headline text-sm md:text-base text-[var(--text)] capitalize tracking-wide leading-snug group-hover:text-brand transition-colors line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                            </a>

                            {{-- Rating --}}
                            <div class="flex items-center gap-0.5 text-brand mt-1 mb-2">
                                <span class="material-symbols-outlined text-[12px] filled text-amber-400"
                                    style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-[12px] filled text-amber-400"
                                    style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-[12px] filled text-amber-400"
                                    style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-[12px] filled text-amber-400"
                                    style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="material-symbols-outlined text-[12px] filled text-amber-400"
                                    style="font-variation-settings: 'FILL' 1;">star_half</span>
                                <span class="text-[11px] text-[var(--text-muted)] font-label ml-1">(4.5)</span>
                            </div>

                            <div class="flex items-center gap-2 mt-auto mb-3">
                                @if ($product->sale_price)
                                    <span class="font-headline text-base text-brand">{!! formatPrice($product->sale_price) !!}</span>
                                    <span
                                        class="text-xs text-[var(--text-muted)] line-through">{!! formatPrice($product->price) !!}</span>
                                @else
                                    <span class="font-headline text-base text-[var(--text)]">{!! formatPrice($product->price) !!}</span>
                                @endif
                            </div>

                            @if ($product->stock > 0)
                                <button
                                    class="w-full bg-[var(--bg-3)] border border-[var(--border)] text-[var(--text)] font-label text-[11px] tracking-[0.3em] capitalize py-2.5 hover:bg-brand hover:text-black hover:border-brand transition-all duration-300"
                                    data-add-cart="{{ $product->id }}" data-i18n="add-to-cart">Add to Cart</button>
                            @else
                                <div class="w-full text-center text-[11px] font-label tracking-widest py-2.5 text-[var(--text-muted)] border border-[var(--border)] capitalize"
                                    data-i18n="out-of-stock">Out of Stock</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-12 text-[var(--text-muted)]">No featured products found.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════
     BRAND PHILOSOPHY BLOCK
════════════════════════════════════════════════════════════════ --}}
    <section
        class="px-4 md:px-10 py-20 md:py-32 max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-20 items-center">
        <div data-animate>
            <span class="text-[11px] text-brand font-label tracking-[0.5em] capitalize flex items-center gap-2 mb-6">
                <span class="w-8 h-px bg-brand"></span> THE DEEPIFY PHILOSOPHY
            </span>
            <h2
                class="font-headline text-3xl md:text-5xl font-black capitalize tracking-tight leading-tight mb-6 text-[var(--text)]">
                PRECISION<br><span class="text-brand">THROUGH</span><br>DESIGN
            </h2>
            <p class="text-sm text-[var(--text-muted)] leading-relaxed mb-8 max-w-md">
                Deepify is not just a brand — it's a trajectory. We build garments for those who exist at the intersection
                of technology, culture, and style. Every thread is intentional.
            </p>
            <a href="{{ route('about') }}"
                class="inline-flex items-center gap-2 border border-brand text-brand font-label text-[11px] tracking-widest capitalize px-7 py-3 hover:bg-brand hover:text-black transition-all duration-300">
                <span>Our Story</span>
                <span class="material-symbols-outlined text-sm rtl-flip">arrow_forward</span>
            </a>
        </div>
        <div class="relative" data-animate>
            <div class="aspect-square overflow-hidden relative">
                <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=800&q=80" alt="Deepify brand"
                    class="product-img w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-br from-brand/10 to-transparent mix-blend-overlay"></div>
            </div>
            {{-- Corner decoration --}}
            <div class="absolute -top-4 -end-4 w-20 h-20 border-t-2 border-e-2 border-brand/40 hidden md:block"></div>
            <div class="absolute -bottom-4 -start-4 w-20 h-20 border-b-2 border-s-2 border-brand/40 hidden md:block"></div>
        </div>
    </section>

@endsection
