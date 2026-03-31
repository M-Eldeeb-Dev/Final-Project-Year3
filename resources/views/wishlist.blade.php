@extends('layouts.app')

@section('title', 'Your Wishlist — Deepify')

@section('content')

<div class="bg-[var(--bg-2)] border-b border-[var(--border)] px-4 md:px-10 py-3">
    <div class="max-w-screen-xl mx-auto flex items-center gap-2 text-[11px] text-[var(--text-muted)] font-label">
        <a href="{{ route('home') }}" class="hover:text-brand transition-colors">Home</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-[var(--text)]">Your Wishlist</span>
    </div>
</div>

<div class="bg-[var(--bg-3)] border-b border-[var(--border)] px-4 md:px-10 py-8">
    <div class="max-w-screen-xl mx-auto">
        <h1 class="font-headline text-4xl md:text-6xl font-black capitalize tracking-tight text-[var(--text)]">
            <span>Your Wishlist</span><span class="text-brand">.</span>
        </h1>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 md:px-10 py-8 md:py-14">

    @if($products->isEmpty())
    <div class="text-center py-24 md:py-32">
        <span class="material-symbols-outlined text-6xl text-[var(--text-muted)] block mb-5">favorite_border</span>
        <h2 class="font-headline text-2xl font-black capitalize tracking-tight text-[var(--text)] mb-3">Your wishlist is empty</h2>
        <p class="text-sm text-[var(--text-muted)] mb-8">Save items you love and buy them later.</p>
        <a href="{{ route('products.index') }}"
           class="inline-block shimmer-btn bg-brand text-black font-label font-bold text-[11px] tracking-[0.35em] capitalize px-10 py-4 hover:bg-lime-400 transition-all duration-300">
           Discover Collection</a>
    </div>
    @else
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">
        @foreach($products as $product)
        <div class="group relative bg-[var(--bg-2)] border border-[var(--border)] hover:border-brand/40 transition-all duration-500 overflow-hidden" id="wishlist-item-{{ $product->id }}">
            
            <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-[4/5] bg-[var(--bg-3)] overflow-hidden">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     class="w-full h-full object-cover scale-100 group-hover:scale-105 transition-transform duration-700 select-none">
                     
                <div class="absolute inset-0 border border-white/0 group-hover:border-white/10 transition-colors pointer-events-none"></div>
            </a>
            
            <button type="button" 
                    class="absolute top-3 end-3 w-8 h-8 flex items-center justify-center bg-[var(--bg-1)] border border-[var(--border)] rounded-full hover:border-brand/50 transition-all z-10"
                    onclick="removeWishlist({{ $product->id }})" aria-label="Remove from Wishlist">
                <span class="material-symbols-outlined text-[16px] text-red-500 fill-current">favorite</span>
            </button>

            <div class="p-4 md:p-5 flex flex-col items-center text-center">
                <span class="text-[10px] text-[var(--text-muted)] font-label tracking-widest uppercase mb-2">{{ $product->category->name }}</span>
                <a href="{{ route('products.show', $product->slug) }}">
                    <h3 class="font-headline text-sm md:text-base capitalize tracking-wide text-[var(--text)] group-hover:text-brand transition-colors mb-3 line-clamp-1">
                        {{ $product->name }}
                    </h3>
                </a>
                <div class="font-headline text-sm text-[var(--text)] mb-4">
                    @if($product->sale_price)
                        <span class="text-brand">{!! formatPrice($product->sale_price) !!}</span>
                        <span class="text-[var(--text-muted)] line-through ml-2 text-xs">{!! formatPrice($product->price) !!}</span>
                    @else
                        {!! formatPrice($product->price) !!}
                    @endif
                </div>

                <a href="{{ route('products.show', $product->slug) }}" 
                   class="w-full py-2.5 bg-[var(--bg-3)] hover:bg-brand hover:text-black border border-[var(--border)] text-[10px] font-label font-bold tracking-[0.3em] uppercase text-center transition-all">
                    View Product
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    function removeWishlist(productId) {
        fetch('{{ route('wishlist.toggle') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // Remove the card from the UI
                const item = document.getElementById('wishlist-item-' + productId);
                if(item) item.remove();
                
                // Update badges globally
                const counters = document.querySelectorAll('[data-wishlist-count]');
                counters.forEach(c => {
                    c.textContent = data.count;
                    if(data.count > 0) c.classList.remove('hidden');
                    else c.classList.add('hidden');
                });
                
                // Reload if empty
                if(data.count === 0) {
                    location.reload();
                }
            }
        })
        .catch(err => console.error(err));
    }
</script>
@endsection
