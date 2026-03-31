@extends('layouts.app')

@section('title', 'Shop — Deepify')
@section('meta-desc', 'Browse all Deepify products — hoodies, jackets, sneakers, and accessories.')

@section('content')

    <div class="bg-[var(--bg-2)] border-b border-[var(--border)] px-4 md:px-10 py-3">
        <div class="max-w-screen-xl mx-auto flex items-center gap-2 text-[11px] text-[var(--text-muted)] font-label">
            <a href="{{ route('home') }}" class="hover:text-brand transition-colors" data-i18n="breadcrumb-home">Home</a>
            <span class="material-symbols-outlined text-[14px] rtl-flip">chevron_right</span>
            <span class="text-[var(--text)]" data-i18n="breadcrumb-shop">Shop</span>
        </div>
    </div>

    <div class="bg-[var(--bg-3)] border-b border-[var(--border)] px-4 md:px-10 py-8 md:py-12">
        <div class="max-w-screen-xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <span
                        class="text-[11px] text-brand font-label tracking-[0.5em] capitalize flex items-center gap-2 mb-2">
                        <span class="w-1.5 h-1.5 bg-brand animate-pulse"></span> DEEPIFY STORE
                    </span>
                    <h1 class="font-headline text-3xl md:text-5xl font-black capitalize tracking-tight text-[var(--text)]">
                        ALL COLLECTIONS
                    </h1>
                </div>
                <p class="text-[11px] text-[var(--text-muted)] font-label tracking-widest">
                    <span data-i18n="products-count">Showing "{{ $products->total() }}" Products</span>
                </p>
            </div>
        </div>
    </div>

    <div
        class="sticky top-[90px] z-20 bg-[var(--bg-2)]/95 backdrop-blur-md border-b border-[var(--border)] px-4 md:px-10 py-3">
        <div class="max-w-screen-xl mx-auto flex flex-wrap items-center justify-between gap-3">


            <div class="flex items-center gap-1 overflow-x-auto no-scrollbar">
                <button
                    class="data-filter-cat shrink-0 text-[11px] font-label tracking-[0.2em] capitalize px-3 py-1.5 border border-brand text-brand"
                    data-filter-cat="all" data-i18n="all-categories">All</button>
                @foreach ($categories as $cat)
                    <button
                        class="shrink-0 text-[11px] font-label tracking-[0.2em] capitalize px-3 py-1.5 border border-[var(--border)] text-[var(--text-muted)] hover:border-brand hover:text-brand transition-all"
                        data-filter-cat="{{ $cat->slug }}">{{ $cat->name }}</button>
                @endforeach
            </div>


            <div class="flex items-center gap-3">

                <div class="flex items-center gap-1.5 border border-[var(--border)] px-2.5 py-1.5 bg-[var(--bg-3)]">
                    <span class="material-symbols-outlined text-[16px] text-[var(--text-muted)]">search</span>
                    <input id="product-search" type="text" placeholder="Search..."
                        class="bg-transparent border-none focus:ring-0 text-[11px] text-[var(--text)] w-28 md:w-40 outline-none font-body">
                </div>

                <select id="sort-select"
                    class="bg-[var(--bg-3)] border border-[var(--border)] text-[11px] text-[var(--text)] px-2.5 py-1.5 focus:ring-0 focus:border-brand font-label capitalize tracking-widest outline-none">
                    <option value="featured" data-i18n="featured-sort">Featured</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }} data-i18n="price-low">
                        Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}
                        data-i18n="price-high">Price: High to Low</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }} data-i18n="newest">Newest
                    </option>
                </select>
            </div>
        </div>
    </div>

    <div class="px-4 md:px-10 py-8 md:py-12 max-w-screen-xl mx-auto">

        @if ($products->isEmpty())
            <div class="text-center py-24">
                <span class="material-symbols-outlined text-5xl text-[var(--text-muted)] mb-4 block">inventory_2</span>
                <p class="text-[var(--text-muted)] font-label tracking-widest capitalize text-sm">No products found</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-6 text-brand text-sm hover:underline">Clear
                    filters</a>
            </div>
        @else
            <div id="products-grid"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-px bg-[var(--border)]">
                @foreach ($products as $product)
                    <div class="group bg-[var(--bg-2)] card-glow transition-all duration-500 flex flex-col"
                        data-product-card data-name="{{ strtolower($product->name) }}"
                        data-category="{{ $product->category->slug ?? '' }}" data-price="{{ $product->active_price }}"
                        data-created="{{ $product->created_at->timestamp }}"
                        data-featured="{{ (int) $product->is_featured }}">


                        <a href="{{ route('products.show', $product) }}"
                            class="relative aspect-[3/4] overflow-hidden block clip-corner bg-[var(--bg-3)]">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                class="product-img w-full h-full object-cover" loading="lazy">


                            <div class="absolute top-3 start-3 flex flex-col gap-1">
                                @if ($product->sale_price)
                                    <span
                                        class="bg-red-500 text-white text-[8px] px-2 py-0.5 font-label font-bold capitalize"
                                        data-i18n="on-sale">Sale</span>
                                @endif
                                @if ($product->stock === 0)
                                    <span class="bg-black/70 text-white text-[8px] px-2 py-0.5 font-label capitalize"
                                        data-i18n="out-of-stock">Out of Stock</span>
                                @endif
                            </div>


                            <div
                                class="absolute inset-0 border-2 border-brand/0 group-hover:border-brand/30 transition-all duration-500 pointer-events-none">
                            </div>
                        </a>


                        <button type="button"
                            class="absolute top-3 end-3 w-8 h-8 bg-black/40 backdrop-blur-sm flex items-center justify-center text-white hover:text-brand transition-colors z-10"
                            onclick="event.preventDefault(); toggleWishlist({{ $product->id }}, this)"
                            aria-label="Wishlist">
                            <span
                                class="material-symbols-outlined text-sm {{ in_array($product->id, session('wishlist', [])) ? 'filled-icon text-brand' : '' }}">favorite</span>
                        </button>


                        <div class="p-4 flex flex-col flex-1 relative">
                            <span
                                class="text-[11px] font-label tracking-[0.3em] text-brand capitalize block mb-1">{{ $product->category->name ?? '' }}</span>
                            <a href="{{ route('products.show', $product) }}">
                                <h3
                                    class="font-headline text-sm text-[var(--text)] capitalize tracking-wide leading-snug group-hover:text-brand transition-colors line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                            </a>


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
                                    <span class="font-headline text-sm text-brand">{!! formatPrice($product->sale_price) !!}</span>
                                    <span
                                        class="text-[11px] text-[var(--text-muted)] line-through">{!! formatPrice($product->price) !!}</span>
                                @else
                                    <span class="font-headline text-sm text-[var(--text)]">{!! formatPrice($product->price) !!}</span>
                                @endif
                            </div>


                            @if ($product->stock > 0 && $product->stock <= 5)
                                <p class="text-[11px] text-amber-500 font-label tracking-widest capitalize mb-2">Only
                                    {{ $product->stock }} left</p>
                            @endif

                            @if ($product->stock > 0)
                                <button
                                    class="w-full bg-[var(--bg-3)] border border-[var(--border)] text-[var(--text)] font-label text-[10px] tracking-[0.25em] capitalize py-2.5 hover:bg-brand hover:text-black hover:border-brand transition-all duration-300"
                                    data-add-cart="{{ $product->id }}" data-i18n="add-to-cart">Add to Cart</button>
                            @else
                                <div class="w-full text-center text-[10px] font-label tracking-widest py-2.5 text-[var(--text-muted)] border border-[var(--border)] capitalize"
                                    data-i18n="out-of-stock">Out of Stock</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>


            @if ($products->hasPages())
                <div class="mt-10 md:mt-14 flex justify-center">
                    <div class="flex items-center gap-1 text-[11px] font-label tracking-widest">
                        @if ($products->onFirstPage())
                            <span
                                class="w-9 h-9 flex items-center justify-center border border-[var(--border)] text-[var(--text-muted)] cursor-not-allowed">
                                <span class="material-symbols-outlined text-[16px] rtl-flip">chevron_left</span>
                            </span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}"
                                class="w-9 h-9 flex items-center justify-center border border-[var(--border)] text-[var(--text-muted)] hover:border-brand hover:text-brand transition-all">
                                <span class="material-symbols-outlined text-[16px] rtl-flip">chevron_left</span>
                            </a>
                        @endif

                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            @if ($page == $products->currentPage())
                                <span
                                    class="w-9 h-9 flex items-center justify-center bg-brand text-black font-bold">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="w-9 h-9 flex items-center justify-center border border-[var(--border)] text-[var(--text-muted)] hover:border-brand hover:text-brand transition-all">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}"
                                class="w-9 h-9 flex items-center justify-center border border-[var(--border)] text-[var(--text-muted)] hover:border-brand hover:text-brand transition-all">
                                <span class="material-symbols-outlined text-[16px] rtl-flip">chevron_right</span>
                            </a>
                        @else
                            <span
                                class="w-9 h-9 flex items-center justify-center border border-[var(--border)] text-[var(--text-muted)] cursor-not-allowed">
                                <span class="material-symbols-outlined text-[16px] rtl-flip">chevron_right</span>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    </div>

@endsection
