<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deebify Admin | @yield('page-title', 'Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .sidebar-border { border-right: 1px solid rgba(201,168,76,0.1); }
        .gold { color: #C9A84C; }
        .bg-gold { background-color: #C9A84C; }
        .border-gold { border-color: #C9A84C; }
        .text-gold { color: #C9A84C; }
        .active-link { background-color: rgba(201,168,76,0.08); border-left: 3px solid #C9A84C; }
        
        [x-cloak] { display: none !important; }
        
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.3s ease-out forwards; }
    </style>
</head>
<body class="flex flex-col lg:flex-row min-h-screen bg-[#F8F8F8] text-gray-800 antialiased" x-data="{ mobileMenuOpen: false }">
    <!-- SIDEBAR -->
    <aside 
        class="fixed inset-y-0 left-0 z-50 w-[260px] flex-shrink-0 bg-[#0A0A0A] text-gray-300 sidebar-border flex flex-col h-screen transform transition-transform duration-300 lg:translate-x-0 lg:sticky lg:top-0"
        :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="p-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gold tracking-widest uppercase">Deebify</h1>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Admin Panel</p>
            </div>
            <button @click="mobileMenuOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="h-px bg-gold opacity-20 mx-4"></div>

        <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-6">
            <!-- OVERVIEW -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Overview</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 hover:text-gold transition-colors {{ request()->routeIs('admin.dashboard') ? 'active-link text-gold' : '' }}">
                    <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
            </div>

            <!-- CATALOG -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Catalog</p>
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 hover:text-gold transition-colors {{ request()->routeIs('admin.products.*') ? 'active-link text-gold' : '' }}">
                    <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Products
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2 hover:text-gold transition-colors {{ request()->routeIs('admin.categories.*') ? 'active-link text-gold' : '' }}">
                    <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Categories
                </a>
            </div>

            <!-- SALES -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Sales</p>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2 hover:text-gold transition-colors {{ request()->routeIs('admin.orders.*') ? 'active-link text-gold' : '' }}">
                    <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Orders
                </a>
            </div>

            <!-- CUSTOMERS -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Customers</p>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center px-4 py-2 hover:text-gold transition-colors justify-between {{ request()->routeIs('admin.messages.*') ? 'active-link text-gold' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z"></path></svg>
                        Messages
                    </div>
                    @php $unreadMsgs = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if($unreadMsgs > 0)
                        <span class="bg-gold text-black text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">{{ $unreadMsgs }}</span>
                    @endif
                </a>
            </div>
        </nav>

        <div class="p-4 bg-[#111] mt-auto">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 rounded-full bg-gold flex items-center justify-center text-black font-bold mr-3">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="text-xs truncate">
                    <p class="text-white font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-2 py-1.5 text-xs text-gray-400 hover:text-white transition-colors flex items-center group">
                    <svg class="w-4 h-4 mr-2 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
            <a href="{{ route('home') }}" target="_blank" class="block w-full text-left px-2 py-1.5 text-[11px] font-bold tracking-widest uppercase text-gold mt-2 hover:text-white transition-all underline underline-offset-4 decoration-gold/30">
                View Store &rarr;
            </a>
        </div>
    </aside>

    <!-- MOBILE OVERLAY -->
    <div 
        x-show="mobileMenuOpen" 
        x-transition:enter="transition-opacity ease-linear duration-300" 
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100" 
        x-transition:leave="transition-opacity ease-linear duration-300" 
        x-transition:leave-start="opacity-100" 
        x-transition:leave-end="opacity-0" 
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        @click="mobileMenuOpen = false"
    ></div>

    <!-- MAIN AREA -->
    <main class="flex-1 flex flex-col min-w-0">
        <!-- TOP BAR -->
        <header class="bg-white/80 backdrop-blur-md shadow-sm h-16 flex items-center justify-between px-4 md:px-8 sticky top-0 z-10 border-b border-gray-100">
            <div class="flex items-center">
                <button @click="mobileMenuOpen = true" class="lg:hidden mr-4 text-gray-600 hover:text-gold transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight capitalize">
                    @yield('page-title')
                </h2>
            </div>
            <div class="flex items-center space-x-6">
                <span class="hidden md:block text-[11px] font-semibold text-gray-400 uppercase tracking-widest">{{ now()->format('D, M j, Y') }}</span>
                <div class="w-px h-6 bg-gray-200 hidden md:block"></div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-brand font-label tracking-widest bg-brand/10 px-2 py-1 rounded hidden sm:block">ADMIN ACCESS</span>
                </div>
            </div>
        </header>

        <!-- FLASH MESSAGES -->
        <div class="px-4 md:px-8">
            @if(session('success'))
                <div class="bg-green-50 border-s-4 border-green-500 text-green-800 p-4 mt-6 rounded shadow-sm flex items-center gap-3 animate-fade-in" role="alert">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border-s-4 border-red-500 text-red-800 p-4 mt-6 rounded shadow-sm flex items-center gap-3" role="alert">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border-s-4 border-red-500 text-red-800 p-4 mt-6 rounded shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                         <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                         <p class="font-bold text-sm">Validation Errors:</p>
                    </div>
                    <ul class="list-disc ml-8 text-sm space-y-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- CONTENT -->
        <div class="p-4 md:p-8 flex-1">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
