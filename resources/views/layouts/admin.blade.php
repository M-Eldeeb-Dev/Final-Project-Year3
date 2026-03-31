<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deebify Admin | @yield('page-title', 'Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .sidebar-border { border-right: 1px solid rgba(201,168,76,0.2); }
        .gold-border { border-color:
        .bg-gold { background-color:
        .text-gold { color:
        .hover-text-gold:hover { color:
        .active-link { background-color: rgba(201,168,76,0.1); border-left: 3px solid
    </style>
</head>
<body class="flex flex-row min-h-screen bg-[#F8F8F8] text-gray-800 antialiased">
    <!-- SIDEBAR -->
    <aside class="w-[260px] flex-shrink-0 bg-[#0A0A0A] text-gray-300 sidebar-border flex flex-col h-screen sticky top-0">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gold tracking-widest uppercase">Deebify</h1>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Admin Panel</p>
        </div>
        <div class="h-px bg-gold opacity-20 mx-4"></div>

        <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-6">
            <!-- OVERVIEW -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Overview</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                    <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
            </div>

            <!-- CATALOG -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Catalog</p>
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-2 hover:text-white transition-colors {{ request()->routeIs('admin.products.*') ? 'active-link' : '' }}">
                    <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Products
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2 hover:text-white transition-colors {{ request()->routeIs('admin.categories.*') ? 'active-link' : '' }}">
                    <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Categories
                </a>
            </div>

            <!-- SALES -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Sales</p>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2 hover:text-white transition-colors {{ request()->routeIs('admin.orders.*') ? 'active-link' : '' }}">
                    <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Orders
                </a>
            </div>

            <!-- CUSTOMERS -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Customers</p>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center px-4 py-2 hover:text-white transition-colors justify-between {{ request()->routeIs('admin.messages.*') ? 'active-link' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-[18px] h-[18px] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Messages
                    </div>
                    @php $unreadMsgs = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if($unreadMsgs > 0)
                        <span class="bg-gold text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadMsgs }}</span>
                    @endif
                </a>
            </div>
        </nav>

        <div class="p-4 bg-[#111]">
            <div class="flex items-center mb-3">
                <div class="w-8 h-8 rounded-full bg-gold flex items-center justify-center text-black font-bold mr-3">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="text-sm truncate">
                    <p class="text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-2 py-1 text-sm text-gray-400 hover:text-white">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
            <a href="{{ route('home') }}" target="_blank" class="block w-full text-left px-2 py-1 text-sm text-gold mt-2 hover:text-white">
                View Store &rarr;
            </a>
        </div>
    </aside>

    <!-- MAIN AREA -->
    <main class="flex-1 flex flex-col min-w-0">
        <!-- TOP BAR -->
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-8 sticky top-0 z-10">
            <h2 class="text-xl font-semibold text-gray-800">
                @yield('page-title')
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">{{ now()->format('D, M j, Y') }}</span>
            </div>
        </header>

        <!-- FLASH MESSAGES -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-8 mt-6 rounded shadow-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-8 mt-6 rounded shadow-sm" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-8 mt-6 rounded shadow-sm">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- CONTENT -->
        <div class="p-8">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
