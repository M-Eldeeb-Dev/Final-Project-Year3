<!DOCTYPE html>
<html lang="en" dir="ltr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Deepify — Wear the Future')</title>
    <meta name="description" content="@yield('meta-desc', 'Deepify — Futuristic streetwear and fashion for the next generation.')">
    <link rel="icon" type="image/webp" href="{{ asset('assets/images/short-logo-light.webp') }}" media="(prefers-color-scheme: dark)">
    <link rel="icon" type="image/webp" href="{{ asset('assets/images/short-logo-dark.webp') }}" media="(prefers-color-scheme: light)">

    <script>
        (function(){
            var t = localStorage.getItem('dp-theme') || 'dark';
            var l = localStorage.getItem('dp-lang')  || 'en';
            document.documentElement.classList.toggle('dark', t === 'dark');
            document.documentElement.setAttribute('dir',  l === 'ar' ? 'rtl' : 'ltr');
            document.documentElement.setAttribute('lang', l);
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand:       'var(--brand)',
                        'brand-dim': 'var(--brand-dim)',
                        surface:  { DEFAULT:'#050505', 2:'#0C0C0C', 3:'#141414' },
                        bone:     '#E8E6E1',
                        outline:  { DEFAULT:'rgba(255,255,255,0.06)', light:'rgba(0,0,0,0.09)' },
                    },
                    fontFamily: {
                        headline: ['Inter', 'Alexandria', 'sans-serif'],
                        body:     ['Inter', 'Alexandria', 'sans-serif'],
                        label:    ['Inter', 'Alexandria', 'sans-serif'],
                    },
                    borderRadius: { DEFAULT:'0px', lg:'0px', xl:'0px', '2xl':'0px', full:'9999px' },
                }
            }
        };
    </script>

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @yield('styles')
</head>
<body class="bg-[var(--bg)] text-[var(--text)] font-body transition-theme min-h-screen flex flex-col">

    <div id="scroll-progress" class="fixed top-0 start-0 h-[2px] bg-brand z-[100] w-0 transition-all duration-100"></div>

    <div id="toast-container" class="fixed bottom-6 end-6 z-[200] flex flex-col gap-3 pointer-events-none" aria-live="polite">
        @if(session('success'))
        <div data-flash class="pointer-events-auto flex items-center gap-3 px-5 py-3 bg-green-600/90 text-white text-sm font-body max-w-lg w-full border-s-4 border-green-300 shadow-xl backdrop-blur-sm">
            <span class="material-symbols-outlined text-base shrink-0">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if(session('error'))
        <div data-flash class="pointer-events-auto flex items-center gap-3 px-5 py-3 bg-red-700/90 text-white text-sm font-body max-w-lg w-full border-s-4 border-red-300 shadow-xl backdrop-blur-sm">
            <span class="material-symbols-outlined text-base shrink-0">error</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif
        @if(session('warning'))
        <div data-flash class="pointer-events-auto flex items-center gap-3 px-5 py-3 bg-yellow-600/90 text-white text-sm font-body max-w-lg w-full border-s-4 border-yellow-300 shadow-xl backdrop-blur-sm">
            <span class="material-symbols-outlined text-base shrink-0">warning</span>
            <span>{{ session('warning') }}</span>
        </div>
        @endif
    </div>

    <div id="drawer-overlay" class="hidden fixed inset-0 bg-black/60 z-40 backdrop-blur-sm"></div>

    <div id="mobile-drawer" class="fixed top-0 start-0 h-full w-72 bg-[var(--bg-2)] z-50 flex flex-col shadow-2xl border-e border-[var(--border)] translate-x-[-100%] rtl:translate-x-[100%] transition-transform duration-300">
        <div class="flex items-center justify-between px-5 h-20 border-b border-[var(--border)]">
            <a href="{{ route('home') }}" class="shrink-0 flex items-center gap-3">
                <img src="{{ asset('assets/images/short-logo-light.webp') }}" alt="Deepify Logo" class="h-8 object-contain">
                <span class="font-headline font-black text-xl tracking-widest text-[var(--text)]">DEEPIFY</span>
            </a>
            <button id="drawer-close-btn" aria-label="Close menu" class="text-[var(--text-muted)] hover:text-brand transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-1 px-5 py-6 overflow-y-auto space-y-1">
            <a href="{{ route('home') }}" data-nav-link data-i18n="home" class="flex items-center gap-3 px-3 py-3 font-label text-xs tracking-widest capitalize text-[var(--text-muted)] hover:text-brand hover:bg-[var(--bg-3)] transition-all border-b border-[var(--border)]">
                <span class="material-symbols-outlined text-sm">home</span>
                Home
            </a>
            <a href="{{ route('products.index') }}" data-nav-link data-i18n="shop" class="flex items-center gap-3 px-3 py-3 font-label text-xs tracking-widest capitalize text-[var(--text-muted)] hover:text-brand hover:bg-[var(--bg-3)] transition-all border-b border-[var(--border)]">
                <span class="material-symbols-outlined text-sm">storefront</span>
                Shop
            </a>
            <a href="{{ route('about') }}" data-nav-link data-i18n="about" class="flex items-center gap-3 px-3 py-3 font-label text-xs tracking-widest capitalize text-[var(--text-muted)] hover:text-brand hover:bg-[var(--bg-3)] transition-all border-b border-[var(--border)]">
                <span class="material-symbols-outlined text-sm">info</span>
                About
            </a>
            <a href="{{ route('contact') }}" data-nav-link data-i18n="contact" class="flex items-center gap-3 px-3 py-3 font-label text-xs tracking-widest capitalize text-[var(--text-muted)] hover:text-brand hover:bg-[var(--bg-3)] transition-all border-b border-[var(--border)]">
                <span class="material-symbols-outlined text-sm">mail</span>
                Contact Us
            </a>
            <a href="{{ route('cart.index') }}" data-nav-link class="flex items-center gap-3 px-3 py-3 font-label text-xs tracking-widest capitalize text-[var(--text-muted)] hover:text-brand hover:bg-[var(--bg-3)] transition-all">
                <span class="material-symbols-outlined text-sm">shopping_bag</span>
                <span data-i18n="cart">Cart</span>
                <span data-cart-count class="{{ $cartCount > 0 ? '' : 'hidden' }} ms-auto text-[9px] bg-brand text-black w-5 h-5 flex items-center justify-center font-bold">{{ $cartCount }}</span>
            </a>
            <a href="{{ route('wishlist.index') }}" data-nav-link class="flex items-center gap-3 px-3 py-3 font-label text-xs tracking-widest capitalize text-[var(--text-muted)] hover:text-brand hover:bg-[var(--bg-3)] transition-all">
                <span class="material-symbols-outlined text-sm">favorite</span>
                <span>Wishlist</span>
                <span data-wishlist-count class="{{ $wishlistCount > 0 ? '' : 'hidden' }} ms-auto text-[9px] bg-brand text-black w-5 h-5 flex items-center justify-center font-bold">{{ $wishlistCount }}</span>
            </a>
            <a href="{{ route('orders.track') }}" data-nav-link class="flex items-center gap-3 px-3 py-3 font-label text-xs tracking-widest capitalize text-[var(--text-muted)] hover:text-brand hover:bg-[var(--bg-3)] transition-all">
                <span class="material-symbols-outlined text-sm">local_shipping</span>
                <span>Track Order</span>
            </a>
            @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" data-nav-link class="flex items-center gap-3 px-3 py-3 font-label text-xs tracking-widest capitalize text-brand hover:text-white hover:bg-[var(--bg-3)] transition-all">
                <span class="material-symbols-outlined text-sm">admin_panel_settings</span>
                <span>Admin Panel</span>
            </a>
            @endif
        </nav>
        <div class="px-5 py-4 border-t border-[var(--border)] space-y-3">
            <button data-theme-toggle class="w-full flex items-center gap-2 text-xs text-[var(--text-muted)] hover:text-brand transition-colors">
                <span class="material-symbols-outlined text-base theme-icon">dark_mode</span>
                <span data-i18n="toggle-theme">Toggle Theme</span>
            </button>
            <button data-lang-toggle class="w-full flex items-center gap-2 text-xs text-[var(--text-muted)] hover:text-brand transition-colors">
                <span class="material-symbols-outlined text-base">translate</span>
                <span data-lang-label>EN | عربي</span>
            </button>
        </div>
    </div>

    <header id="main-nav" class="glass-nav fixed top-0 start-0 end-0 z-30 transition-all duration-300">
        <div class="bg-brand text-black text-center py-1.5 px-4 text-[13px] font-label font-bold tracking-widest capitalize">
            <span data-i18n="free-ship-promo">Free shipping on orders over $100</span>
        </div>

        <div class="flex items-center gap-3 px-4 md:px-8 h-14 max-w-screen-2xl mx-auto">

            <a href="{{ route('home') }}" class="shrink-0 flex items-center gap-3">
                <img src="{{ asset('assets/images/short-logo-light.webp') }}" alt="Deepify Logo" class="h-10 object-contain dark:hidden">
                <img src="{{ asset('assets/images/short-logo-dark.webp') }}" alt="Deepify Logo" class="h-10 object-contain hidden dark:block">
                <span class="font-headline font-black text-2xl tracking-[0.2em] text-[var(--text)]">DEEPIFY</span>
            </a>

            <nav class="hidden md:flex items-center gap-6 ms-6">
                <a href="{{ route('home') }}" data-nav-link data-i18n="home" class="font-label text-[11px] capitalize tracking-[0.18em] text-[var(--text-muted)] hover:text-brand transition-colors duration-200">Home</a>
                <a href="{{ route('products.index') }}" data-nav-link data-i18n="shop" class="font-label text-[11px] capitalize tracking-[0.18em] text-[var(--text-muted)] hover:text-brand transition-colors duration-200">Shop</a>
                <a href="{{ route('about') }}" data-nav-link data-i18n="about" class="font-label text-[11px] capitalize tracking-[0.18em] text-[var(--text-muted)] hover:text-brand transition-colors duration-200">About</a>
                <a href="{{ route('contact') }}" data-nav-link data-i18n="contact" class="font-label text-[11px] capitalize tracking-[0.18em] text-[var(--text-muted)] hover:text-brand transition-colors duration-200">Contact Us</a>
                @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   class="font-label text-[11px] capitalize tracking-[0.18em] text-brand hover:text-white transition-colors duration-200">
                    Admin Panel
                </a>
                @endif
            </nav>

            <div class="ms-auto flex items-center gap-2">
                <button data-theme-toggle aria-label="Toggle theme" class="hidden md:flex w-9 h-9 items-center justify-center text-[var(--text-muted)] hover:text-brand transition-colors">
                    <span class="material-symbols-outlined text-xl theme-icon">dark_mode</span>
                </button>
                <button data-lang-toggle aria-label="Toggle language" class="hidden md:flex items-center gap-1 text-[var(--text-muted)] hover:text-brand transition-colors font-label text-[10px] tracking-widest">
                    <span class="material-symbols-outlined text-base">translate</span>
                    <span data-lang-label class="hidden sm:inline">EN</span>
                </button>
                <a href="{{ route('wishlist.index') }}" class="relative w-9 h-9 flex items-center justify-center text-[var(--text-muted)] hover:text-brand transition-colors" aria-label="Wishlist">
                    <span class="material-symbols-outlined text-xl">favorite</span>
                    <span data-wishlist-count class="{{ $wishlistCount > 0 ? '' : 'hidden' }} absolute -top-1 -end-1 text-[11px] bg-brand text-black w-4 h-4 flex items-center justify-center font-black">{{ $wishlistCount }}</span>
                </a>
                <a href="{{ route('cart.index') }}" class="relative w-9 h-9 flex items-center justify-center text-[var(--text-muted)] hover:text-brand transition-colors" aria-label="Cart">
                    <span class="material-symbols-outlined text-xl">shopping_bag</span>
                    <span data-cart-count class="{{ $cartCount > 0 ? '' : 'hidden' }} absolute -top-1 -end-1 text-[11px] bg-brand text-black w-4 h-4 flex items-center justify-center font-black">{{ $cartCount }}</span>
                </a>
                <button id="hamburger-btn" aria-label="Open menu" class="md:hidden w-9 h-9 flex items-center justify-center text-[var(--text-muted)] hover:text-brand transition-colors">
                    <span class="material-symbols-outlined text-xl">menu</span>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-1 mt-[90px]">
        @yield('content')
    </main>

    <footer class="bg-[var(--bg-2)] border-t border-[var(--border)] mt-auto">

        <div class="max-w-screen-xl mx-auto px-6 md:px-10 py-12 md:py-16 grid grid-cols-2 md:grid-cols-4 gap-10 md:gap-16">

            <div class="col-span-2 md:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-5">
                    <img src="{{ asset('assets/images/short-logo-light.webp') }}" alt="Deepify" class="h-8 object-contain dark:hidden">
                    <img src="{{ asset('assets/images/short-logo-dark.webp') }}" alt="Deepify" class="h-8 object-contain hidden dark:block">
                    <span class="font-headline font-black text-base tracking-widest text-[var(--text)]">DEEPIFY</span>
                </a>
                <p class="text-[12px] text-[var(--text-muted)] leading-relaxed tracking-wider mb-6 capitalize">
                    Engineered for the next dimension of style.
                </p>
                <div class="flex gap-4">
                    @foreach(['alternate_email','radio','rss_feed'] as $icon)
                    <a href="#" class="w-8 h-8 border border-[var(--border)] flex items-center justify-center text-[var(--text-muted)] hover:text-brand hover:border-brand transition-all">
                        <span class="material-symbols-outlined text-[16px]">{{ $icon }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h5 class="font-label text-[11px] capitalize tracking-[0.3em] text-[var(--text)] font-bold mb-5 border-b border-[var(--border)] pb-2">Shop</h5>
                <ul class="space-y-3 text-[11px]">
                    <li><a href="{{ route('products.index') }}" class="text-[var(--text-muted)] hover:text-brand transition-colors">All Products</a></li>
                    <li><a href="{{ route('products.index') }}?category=hoodies" class="text-[var(--text-muted)] hover:text-brand transition-colors">Hoodies</a></li>
                    <li><a href="{{ route('products.index') }}?category=jackets" class="text-[var(--text-muted)] hover:text-brand transition-colors">Jackets</a></li>
                    <li><a href="{{ route('products.index') }}?category=sneakers" class="text-[var(--text-muted)] hover:text-brand transition-colors">Sneakers</a></li>
                    <li><a href="{{ route('products.index') }}?category=accessories" class="text-[var(--text-muted)] hover:text-brand transition-colors">Accessories</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-label text-[11px] capitalize tracking-[0.3em] text-[var(--text)] font-bold mb-5 border-b border-[var(--border)] pb-2">Help</h5>
                <ul class="space-y-3 text-[11px]">
                    <li><a href="{{ route('contact') }}" class="text-[var(--text-muted)] hover:text-brand transition-colors" data-i18n="contact-us">Contact Us</a></li>
                    <li><a href="{{ route('about') }}"   class="text-[var(--text-muted)] hover:text-brand transition-colors" data-i18n="about-us">About Us</a></li>
                    <li><a href="#" class="text-[var(--text-muted)] hover:text-brand transition-colors">Shipping Policy</a></li>
                    <li><a href="#" class="text-[var(--text-muted)] hover:text-brand transition-colors">Returns</a></li>
                    <li><a href="#" class="text-[var(--text-muted)] hover:text-brand transition-colors">Privacy Policy</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-label text-[11px] capitalize tracking-[0.3em] text-[var(--text)] font-bold mb-5 border-b border-[var(--border)] pb-2" data-i18n="newsletter">Join our newsletter</h5>
                <p class="text-[12px] text-[var(--text-muted)] mb-4" data-i18n="newsletter-sub">
                    Get updates on new drops, exclusive offers, and more.
                </p>
                <form class="flex border border-[var(--border)]" onsubmit="return false">
                    <input type="email" placeholder="your@email.com"
                           class="flex-1 bg-transparent px-3 py-2 text-[13px] text-[var(--text)] placeholder:text-[var(--text-muted)] border-none focus:ring-0 outline-none font-body">
                    <button type="submit"
                            class="bg-brand text-black px-4 text-[11px] font-label tracking-widest capitalize hover:bg-lime-400 transition-colors"
                            data-i18n="subscribe">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="border-t border-[var(--border)] px-6 md:px-10 py-4 max-w-screen-xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-3 text-[11px] text-[var(--text-muted)]">
            <span data-i18n="copyright">&copy; {{ date('Y') }} Deepify. All rights reserved.</span>
            <div class="flex gap-6">
                <a href="#" class="hover:text-brand transition-colors">Privacy</a>
                <a href="#" class="hover:text-brand transition-colors">Terms</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/navbar.js') }}"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        function toggleWishlist(productId, btnElement) {
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

                    const counters = document.querySelectorAll('[data-wishlist-count]');
                    counters.forEach(c => {
                        c.textContent = data.count;
                        if(data.count > 0) c.classList.remove('hidden');
                        else c.classList.add('hidden');
                    });


                    if(btnElement) {
                        const icon = btnElement.querySelector('span.material-symbols-outlined');
                        if (data.action === 'added') {
                            icon.classList.add('fill-current', 'text-brand');
                        } else {
                            icon.classList.remove('fill-current', 'text-brand');
                        }
                    }
                }
            })
            .catch(err => console.error(err));
        }
    </script>
    @yield('scripts')
</body>
</html>
