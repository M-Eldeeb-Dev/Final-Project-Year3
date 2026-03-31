@extends('layouts.app')

@section('title', $product->name . ' — Deepify')
@section('meta-desc', substr($product->description, 0, 155))

@section('content')

<div class="bg-[var(--bg-2)] border-b border-[var(--border)] px-4 md:px-10 py-3">
    <div class="max-w-screen-xl mx-auto flex items-center gap-2 text-[11px] text-[var(--text-muted)] font-label flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-brand transition-colors" data-i18n="breadcrumb-home">Home</a>
        <span class="material-symbols-outlined text-[14px] rtl-flip">chevron_right</span>
        <a href="{{ route('products.index') }}" class="hover:text-brand transition-colors" data-i18n="breadcrumb-shop">Shop</a>
        <span class="material-symbols-outlined text-[14px] rtl-flip">chevron_right</span>
        @if($product->category)
        <a href="{{ route('products.index') }}?category={{ $product->category->slug }}" class="hover:text-brand transition-colors">{{ $product->category->name }}</a>
        <span class="material-symbols-outlined text-[14px] rtl-flip">chevron_right</span>
        @endif
        <span class="text-[var(--text)] font-medium">{{ $product->name }}</span>
    </div>
</div>

<section class="max-w-screen-xl mx-auto px-4 md:px-10 py-8 md:py-14">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-16">


        <div class="md:col-span-7 relative">
            <div class="relative bg-[var(--bg-3)] aspect-[4/5] overflow-hidden">
                <img id="main-product-img"
                     src="{{ $product->image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-contain transition-opacity duration-300">
                <div class="absolute inset-0 border border-brand/0 hover:border-brand/20 transition-all duration-700 pointer-events-none"></div>
            </div>

            <div class="flex gap-2 mt-3 overflow-x-auto no-scrollbar">
                <button class="w-16 h-20 bg-[var(--bg-3)] border-2 border-brand overflow-hidden shrink-0 transition-all hover:border-brand"
                        data-thumb="{{ $product->image_url }}">
                    <img src="{{ $product->image_url }}" alt="thumb" class="w-full h-full object-cover">
                </button>

            </div>
        </div>


        <div class="md:col-span-5 flex flex-col justify-center">
            <div class="mb-4">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-[11px] text-brand font-label tracking-[0.5em] capitalize">{{ $product->category->name ?? '' }}</span>
                    @if($product->views_count > 0)
                    <span class="flex items-center gap-1 text-[10px] text-[var(--text-muted)] font-label tracking-wider ms-auto">
                        <span class="material-symbols-outlined text-[12px]">visibility</span>
                        {{ number_format($product->views_count) }} views
                    </span>
                    @endif
                </div>
                <h1 class="font-headline text-3xl md:text-5xl font-black capitalize tracking-tight text-[var(--text)] leading-[1.1] mb-4">
                    {{ $product->name }}
                </h1>

                <div class="flex items-center gap-3 mb-6 pb-6 border-b border-[var(--border)]">
                    @if($product->sale_price)
                    <span class="font-headline text-2xl text-brand">{!! formatPrice($product->sale_price) !!}</span>
                    <span class="text-sm text-[var(--text-muted)] line-through">{!! formatPrice($product->price) !!}</span>
                    <span class="text-[10px] font-label tracking-widest bg-brand/10 text-brand border border-brand/30 px-2 py-0.5">
                        SAVE {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                    </span>
                    @else
                    <span class="font-headline text-2xl text-[var(--text)]">{!! formatPrice($product->price) !!}</span>
                    @endif
                </div>
            </div>

            <div class="space-y-8 mb-10">

                <div class="group">
                    <div class="flex justify-between items-center mb-4">
                        <label class="font-label text-[11px] tracking-[0.3em] text-[var(--text-muted)] capitalize" data-i18n="size">Select Dimension</label>
                        <a href="#" class="text-[10px] text-brand hover:underline capitalize" data-i18n="size-guide">Size Guide</a>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['XS','S','M','L','XL','XXL'] as $size)
                        <button class="w-12 h-12 border border-[var(--border)] flex items-center justify-center font-label text-[10px] hover:border-brand transition-all peer-checked:bg-brand peer-checked:text-black">
                            {{ $size }}
                        </button>
                        @endforeach
                    </div>
                </div>


                <div class="flex gap-3">
                    <div class="flex items-center border border-[var(--border)] bg-[var(--bg-3)]">
                        <button class="w-12 h-14 flex items-center justify-center hover:text-brand transition-colors px-1" onclick="this.nextElementSibling.stepDown()">
                            <span class="material-symbols-outlined text-sm">remove</span>
                        </button>
                        <input type="number" value="1" min="1" max="10" class="w-12 h-14 bg-transparent border-none text-center font-headline text-sm focus:ring-0">
                        <button class="w-12 h-14 flex items-center justify-center hover:text-brand transition-colors px-1" onclick="this.previousElementSibling.stepUp()">
                            <span class="material-symbols-outlined text-sm">add</span>
                        </button>
                    </div>
                    <button class="flex-1 shimmer-btn bg-brand text-black font-label font-bold text-[11px] tracking-[0.35em] capitalize py-4 hover:bg-lime-400 transition-all duration-300 active:scale-[0.98]"
                            data-add-cart="{{ $product->id }}"
                            data-i18n="add-to-cart">Add to Cart</button>
                    <button type="button" class="w-14 h-14 border border-[var(--border)] flex items-center justify-center text-[var(--text-muted)] hover:text-red-500 hover:border-red-500 transition-all group" onclick="toggleWishlist({{ $product->id }}, this)">
                        <span class="material-symbols-outlined text-xl {{ in_array($product->id, session('wishlist', [])) ? 'fill-current text-brand' : 'group-hover:fill-red-500' }}">favorite</span>
                    </button>
                </div>
            </div>


            <div class="border-t border-[var(--border)]">
                <div class="border-b border-[var(--border)]">
                    <button class="flex w-full items-center justify-between py-4 text-[11px] font-label tracking-widest capitalize text-[var(--text)] hover:text-brand transition-colors"
                            data-accordion-trigger="description">
                        <span>Description</span>
                        <span class="material-symbols-outlined text-sm" data-accordion-icon>add</span>
                    </button>
                    <div id="accordion-description" class="hidden pb-6 text-sm text-[var(--text-muted)] leading-relaxed capitalize">
                        {{ $product->description }}
                    </div>
                </div>
                <div class="border-b border-[var(--border)]">
                    <button class="flex w-full items-center justify-between py-4 text-[11px] font-label tracking-widest capitalize text-[var(--text)] hover:text-brand transition-colors"
                            data-accordion-trigger="ship">
                        <span>Shipping & Returns</span>
                        <span class="material-symbols-outlined text-sm" data-accordion-icon>add</span>
                    </button>
                    <div id="accordion-ship" class="hidden pb-4 text-sm text-[var(--text-muted)] leading-relaxed">
                        <p>Orders over $100 qualify for free shipping. Standard delivery 3–7 business days. Returns accepted within 30 days of purchase.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($related->count())
<section class="bg-[var(--bg-3)] border-t border-[var(--border)] px-4 md:px-10 py-12 md:py-16">
    <div class="max-w-screen-xl mx-auto">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-[11px] text-brand font-label tracking-[0.5em] capitalize flex items-center gap-2 mb-2">
                    <span class="w-1.5 h-1.5 bg-brand"></span> Synchronized Units
                </span>
                <h2 class="font-headline text-2xl md:text-3xl font-black capitalize tracking-tight text-[var(--text)]" data-i18n="related">You Might Also Like</h2>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-px bg-[var(--border)] shadow-sm">
            @foreach($related as $rel)
            <div class="group bg-[var(--bg-2)] card-glow transition-all duration-500 flex flex-col relative overflow-hidden" data-animate>
                <a href="{{ route('products.show', $rel) }}" class="relative aspect-[3/4] overflow-hidden block">
                    <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="product-img w-full h-full object-cover" loading="lazy">
                </a>
                <button class="absolute top-3 end-3 w-8 h-8 bg-black/40 backdrop-blur-sm flex items-center justify-center text-white/70 hover:text-brand transition-colors z-10"
                        data-wishlist-btn="{{ $rel->id }}" aria-label="Add to wishlist">
                    <span class="material-symbols-outlined text-sm">favorite</span>
                </button>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-headline text-xs text-[var(--text)] capitalize tracking-wide mb-2 group-hover:text-brand transition-colors line-clamp-1">{{ $rel->name }}</h3>
                    <div class="flex items-center gap-0.5 mb-2">
                        @for($i=0;$i<5;$i++)
                        <span class="material-symbols-outlined text-[10px] filled text-amber-400">star</span>
                        @endfor
                    </div>
                    <p class="font-headline text-sm text-[var(--text-muted)] mt-auto">{!! formatPrice($rel->active_price) !!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
