@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('title', 'Checkout — Deepify')

@section('styles')
<style>
.dp-input { appearance: none; }
.dp-input:focus { outline: none; }
select.dp-input { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%239CA3AF' viewBox='0 0 20 20'%3E%3Cpath d='M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.7rem center; background-size: 1rem; padding-right: 2.5rem; }
[dir="rtl"] select.dp-input { background-position: left 0.7rem center; padding-right: 1rem; padding-left: 2.5rem; }
</style>
@endsection

@section('content')

<div class="bg-[var(--bg-2)] border-b border-[var(--border)] px-4 md:px-10 py-3">
    <div class="max-w-screen-xl mx-auto flex items-center gap-2 text-[11px] text-[var(--text-muted)] font-label">
        <a href="{{ route('home') }}" class="hover:text-brand transition-colors" data-i18n="breadcrumb-home">Home</a>
        <span class="material-symbols-outlined text-[14px] rtl-flip">chevron_right</span>
        <a href="{{ route('cart.index') }}" class="hover:text-brand transition-colors" data-i18n="your-cart">Cart</a>
        <span class="material-symbols-outlined text-[14px] rtl-flip">chevron_right</span>
        <span class="text-[var(--text)]" data-i18n="checkout">Checkout</span>
    </div>
</div>

<div class="bg-[var(--bg-3)] border-b border-[var(--border)] px-4 md:px-10 py-8">
    <div class="max-w-screen-xl mx-auto">
        <div class="border-s-4 border-brand ps-6">
            <h1 class="font-headline text-3xl md:text-5xl font-black capitalize tracking-tight text-[var(--text)]" data-i18n="checkout">Checkout</h1>
            <p class="text-[10px] text-[var(--text-muted)] font-label tracking-[0.3em] mt-1 capitalize">
                Transaction ID: DP-{{ strtoupper(Str::random(8)) }} &nbsp;|&nbsp; Status: Pending Auth
            </p>
        </div>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 md:px-10 py-8 md:py-14">
    <form action="{{ route('order.store') }}" method="POST" id="checkout-form">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-20">

            <div class="lg:col-span-7 space-y-12">

                <section>
                    <div class="flex items-center justify-between border-b border-[var(--border)] pb-3 mb-6">
                        <div class="flex items-center gap-4">
                            <span class="font-headline text-xs text-brand/50">01</span>
                            <h2 class="font-headline text-sm font-bold tracking-[0.3em] capitalize text-[var(--text)]">Contact</h2>
                        </div>
                        <span class="text-[9px] text-[var(--text-muted)] font-label tracking-widest capitalize">REQUIRED</span>
                    </div>
                    <div class="space-y-5">
                        <div class="group">
                            <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors" data-i18n="email">Email Address</label>
                            <input type="email" name="email" required
                                   class="dp-input @error('email') border-red-500 @enderror"
                                   placeholder="EMAIL@DOMAIN.COM"
                                   value="{{ old('email') }}">
                            @error('email')<p class="text-red-400 text-[10px] mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="group">
                            <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors" data-i18n="phone">Phone Number</label>
                            <input type="tel" name="phone"
                                   class="dp-input @error('phone') border-red-500 @enderror"
                                   placeholder="+1 000 000 0000"
                                   value="{{ old('phone') }}">
                            @error('phone')<p class="text-red-400 text-[10px] mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                <section>
                    <div class="flex items-center justify-between border-b border-[var(--border)] pb-3 mb-6">
                        <div class="flex items-center gap-4">
                            <span class="font-headline text-xs text-brand/50">02</span>
                            <h2 class="font-headline text-sm font-bold tracking-[0.3em] capitalize text-[var(--text)]">Shipping</h2>
                        </div>
                        <span class="text-[9px] text-brand/60 font-label tracking-widest capitalize">PRIORITY: STANDARD</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="group">
                            <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors" data-i18n="full-name">Full Name</label>
                            <input type="text" name="name" required
                                   class="dp-input @error('name') border-red-500 @enderror"
                                   placeholder="FULL NAME"
                                   value="{{ old('name') }}">
                            @error('name')<p class="text-red-400 text-[10px] mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="group md:col-span-2">
                            <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors" data-i18n="address">Street Address</label>
                            <input type="text" name="address" required
                                   class="dp-input @error('address') border-red-500 @enderror"
                                   placeholder="STREET ADDRESS"
                                   value="{{ old('address') }}">
                            @error('address')<p class="text-red-400 text-[10px] mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="group">
                            <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors" data-i18n="city">City</label>
                            <input type="text" name="city" required
                                   class="dp-input @error('city') border-red-500 @enderror"
                                   placeholder="CITY"
                                   value="{{ old('city') }}">
                            @error('city')<p class="text-red-400 text-[10px] mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="group">
                            <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors" data-i18n="zip">ZIP / Postal Code</label>
                            <input type="text" name="zip_code"
                                   class="dp-input @error('zip_code') border-red-500 @enderror"
                                   placeholder="ZIP CODE"
                                   value="{{ old('zip_code') }}">
                            @error('zip_code')<p class="text-red-400 text-[10px] mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="group md:col-span-2">
                            <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors" data-i18n="country">Country</label>
                            <select name="country" class="dp-input @error('country') border-red-500 @enderror" required>
                                <option value="" disabled {{ !old('country') ? 'selected' : '' }}>SELECT COUNTRY</option>
                                @foreach(['Saudi Arabia','United Arab Emirates','Kuwait','Qatar','Bahrain','Oman','Egypt','Jordan','Lebanon','United States','United Kingdom','Germany','France','Canada','Australia'] as $country)
                                <option value="{{ $country }}" {{ old('country') === $country ? 'selected' : '' }}>{{ strtoupper($country) }}</option>
                                @endforeach
                            </select>
                            @error('country')<p class="text-red-400 text-[10px] mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                <section class="bg-[var(--bg-2)] border border-[var(--border)] p-6 md:p-8 relative">
                    <div class="scanning-line absolute top-0 start-0 end-0"></div>
                    <div class="flex items-center justify-between border-b border-[var(--border)] pb-3 mb-6">
                        <div class="flex items-center gap-4">
                            <span class="font-headline text-xs text-brand/50">03</span>
                            <h2 class="font-headline text-sm font-bold tracking-[0.3em] capitalize text-[var(--text)]">Secure Payment</h2>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[13px] text-brand/60">lock</span>
                            <span class="text-[9px] text-brand/60 font-label tracking-widest capitalize">AES_256</span>
                        </div>
                    </div>

                    {{-- Payment method tabs --}}
                    <div class="space-y-3 mb-6">
                        {{-- Cash on Delivery --}}
                        <label class="flex items-center gap-4 p-4 border border-brand bg-brand/5 cursor-pointer">
                            <input type="radio" name="payment_method" id="pm-cod" value="cod"
                                   {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}
                                   class="accent-brand focus:ring-brand">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-brand text-xl">payments</span>
                                <div>
                                    <p class="text-xs font-label tracking-widest capitalize text-[var(--text)] font-bold" data-i18n="cod">Cash on Delivery</p>
                                    <p class="text-[9px] text-[var(--text-muted)] font-label tracking-widest capitalize mt-0.5">Pay when you receive</p>
                                </div>
                            </div>
                        </label>

                        {{-- Credit Card (disabled) --}}
                        <label class="flex items-center gap-4 p-4 border border-[var(--border)] opacity-50 cursor-not-allowed relative overflow-hidden">
                            <input type="radio" name="payment_method" id="pm-credit" value="credit" disabled class="accent-brand">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-[var(--text-muted)] text-xl">credit_card</span>
                                <div>
                                    <p class="text-xs font-label tracking-widest capitalize text-[var(--text)] font-bold" data-i18n="credit-card">Credit Card</p>
                                    <p class="text-[9px] text-[var(--text-muted)] font-label tracking-widest capitalize mt-0.5" data-i18n="coming-soon">Coming Soon</p>
                                </div>
                            </div>
                            <span class="ms-auto text-[8px] bg-amber-500/20 text-amber-400 border border-amber-500/30 px-2 py-0.5 font-label capitalize tracking-widest" data-i18n="coming-soon">Coming Soon</span>
                        </label>
                    </div>

                    {{-- Credit card fields (hidden by default) --}}
                    <div id="cc-panel" class="hidden space-y-5">
                        <div class="group">
                            <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors">Card Number</label>
                            <div class="relative">
                                <input type="text" name="card_number"
                                       class="dp-input pe-10" placeholder="0000 0000 0000 0000">
                                <span class="absolute end-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-[var(--text-muted)] text-sm">credit_card</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="group">
                                <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors">Expiry</label>
                                <input type="text" name="card_expiry" class="dp-input" placeholder="MM / YY">
                            </div>
                            <div class="group">
                                <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize group-focus-within:text-brand transition-colors">CVC</label>
                                <input type="password" name="card_cvv" class="dp-input" placeholder="•••">
                            </div>
                        </div>
                    </div>
                </section>

                <section>
                    <label class="block text-[9px] font-label tracking-[0.25em] text-[var(--text-muted)] mb-2 capitalize" data-i18n="notes">Order Notes (optional)</label>
                    <textarea name="notes" rows="3"
                              class="dp-input resize-none"
                              placeholder="Any special instructions...">{{ old('notes') }}</textarea>
                </section>
            </div>

            <div class="lg:col-span-5">
                <div class="sticky top-[90px] bg-[var(--bg-2)] border border-[var(--border)] relative overflow-hidden">
                    <div class="scanning-line absolute top-0 start-0 end-0"></div>

                    <div class="px-6 py-5 border-b border-[var(--border)]">
                        <div class="flex items-center justify-between">
                            <h2 class="font-headline text-[11px] tracking-[0.4em] capitalize text-[var(--text)]" data-i18n="order-summary">Order Summary</h2>
                            <span class="text-[8px] text-brand/60 font-label tracking-widest capitalize">STATUS: PENDING</span>
                        </div>
                    </div>

                    {{-- Cart items list --}}
                    <div class="px-6 py-4 space-y-4 max-h-72 overflow-y-auto">
                        @foreach($cart as $item)
                        <div class="flex gap-4 group">
                            <div class="w-16 h-20 bg-[var(--bg-3)] border border-[var(--border)] shrink-0 overflow-hidden relative">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                     class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-all duration-500">
                            </div>
                            <div class="flex flex-col justify-between py-1 min-w-0">
                                <div>
                                    <h4 class="font-headline text-[10px] tracking-[0.15em] capitalize text-[var(--text)] line-clamp-2">{{ $item['name'] }}</h4>
                                    @if(!empty($item['size']))<p class="text-[8px] text-[var(--text-muted)] tracking-widest mt-0.5">{{ $item['size'] }}</p>@endif
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] text-[var(--text-muted)] font-label">×{{ $item['quantity'] }}</span>
                                    <span class="font-headline text-xs text-[var(--text)]">{!! formatPrice($item['price'] * $item['quantity']) !!}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="px-6 py-4 border-t border-[var(--border)] space-y-3 text-[10px]">
                        <div class="flex justify-between">
                            <span class="text-[var(--text-muted)] font-label tracking-widest capitalize" data-i18n="subtotal">Subtotal</span>
                            <span class="font-headline text-[var(--text)]">{!! formatPrice($subtotal) !!}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[var(--text-muted)] font-label tracking-widest capitalize" data-i18n="shipping">Shipping</span>
                            @if($shipping == 0)
                            <span class="font-label tracking-widest text-green-500 capitalize" data-i18n="free">FREE</span>
                            @else
                            <span class="font-headline text-[var(--text)]">{!! formatPrice($shipping) !!}</span>
                            @endif
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[var(--text-muted)] font-label tracking-widest capitalize" data-i18n="tax">Tax</span>
                            <span class="font-headline text-[var(--text)]">{!! formatPrice($tax) !!}</span>
                        </div>
                    </div>

                    {{-- Grand total + CTA --}}
                    <div class="px-6 py-5 border-t-2 border-[var(--border)]">
                        <div class="flex justify-between items-center mb-5">
                            <span class="font-headline text-[10px] tracking-[0.4em] capitalize text-[var(--text)]" data-i18n="total">Total</span>
                            <span class="font-headline text-2xl text-brand">{!! formatPrice($total) !!}</span>
                        </div>

                        <button type="submit"
                                class="w-full shimmer-btn bg-white text-black dark:bg-white dark:text-black font-headline text-[11px] tracking-[0.4em] capitalize py-5 hover:bg-brand hover:text-black transition-all duration-500 active:scale-[0.98]"
                                id="place-order-btn"
                                data-i18n="place-order">Place Order</button>

                        <p class="mt-4 text-[8px] text-[var(--text-muted)] font-label text-center tracking-widest capitalize leading-loose">
                            By placing your order you agree to our Terms of Service.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('checkout-form')?.addEventListener('submit', function(e) {
    e.preventDefault(); // Intercept form submission
    
    const form = this;
    const btn = document.getElementById('place-order-btn');
    const originalText = btn ? btn.innerHTML : '';
    
    if (btn) {
      btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">sync</span>';
      btn.disabled = true;
    }
    
    // Fake processing delay to make it realistic
    setTimeout(() => {
        const orderId = 'DP-' + Math.random().toString(36).substring(2, 10).toUpperCase();
        const email = document.querySelector('input[name="email"]')?.value || 'Guest';
        
        const brandColor = getComputedStyle(document.documentElement).getPropertyValue('--brand').trim() || '#D4AF37';
        
        // Show SweetAlert for fake ordering details
        Swal.fire({
          title: 'Order Transmitted',
          html: `
            <div class="text-[11px] font-label text-[#9CA3AF] tracking-[0.2em] capitalize space-y-3 mt-4 text-left p-4 bg-[var(--bg-3)] border border-[var(--border)] relative overflow-hidden">
              <div class="scanning-line absolute top-0 start-0 end-0"></div>
              <p><strong style="color: ${brandColor}">Transaction ID:</strong> ${orderId}</p>
              <p><strong style="color: ${brandColor}">Email:</strong> ${email}</p>
              <p><strong style="color: ${brandColor}">Status:</strong> Authorized</p>
              <p><strong style="color: ${brandColor}">ETA:</strong> 3-5 Business Days</p>
              <hr class="border-[var(--border)] my-3">
              <p class="text-[9px]" style="color: ${brandColor}">System received your order. Proceeding to fulfillment.</p>
            </div>
          `,
          icon: 'success',
          iconColor: brandColor,
          background: 'var(--bg-2)',
          color: 'var(--text)',
          confirmButtonText: 'Acknowledge',
          confirmButtonColor: brandColor,
          showCancelButton: true,
          cancelButtonText: 'Abort',
          cancelButtonColor: 'var(--bg-3)',
          customClass: {
            popup: 'border rounded-none',
            title: 'font-headline text-lg tracking-[0.3em] capitalize',
            confirmButton: 'font-headline text-[10px] tracking-[0.3em] capitalize text-black rounded-none px-6 py-3 hover:bg-white transition-colors font-bold',
            cancelButton: 'font-headline text-[10px] tracking-[0.3em] capitalize text-[var(--text-muted)] border border-[var(--border)] rounded-none px-6 py-3 hover:text-[var(--text)] transition-colors',
            htmlContainer: 'font-body'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // Wait brief moment then submit real form
            btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">sync</span>';
            setTimeout(() => {
                form.submit();
            }, 300);
          } else {
            // Restore button if canceled
            if (btn) {
              btn.innerHTML = originalText;
              btn.disabled = false;
            }
          }
        });
    }, 800);
  });
</script>
@endsection
