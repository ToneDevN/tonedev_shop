<!DOCTYPE html>
<html lang="th" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Tonedev Shop</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('tonedev_logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&family=Mitr:wght@200;300;400;500;600;700&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }

        .sidebar-link { @apply flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-slate-500 hover:text-slate-900; }
        .sidebar-link:hover { @apply bg-slate-100; }
        
        /* Active States */
        .active-admin { @apply bg-rose-50 text-rose-600 font-bold border-r-4 border-rose-500 rounded-r-none; }
        .active-owner { @apply bg-indigo-50 text-indigo-600 font-bold border-r-4 border-indigo-500 rounded-r-none; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { @apply bg-slate-200 rounded-full; }
    </style>
</head>
<body class="h-full bg-slate-50 antialiased text-slate-900" x-data="{ mobileOpen: false }">

    @php
        $user = auth('api')->user();
        $isAdmin = $user && $user->role === 'admin';
        $accent = $isAdmin ? 'rose' : 'indigo';
        $accentColor = $isAdmin ? 'rose' : 'indigo';
        $activeClass = $isAdmin ? 'active-admin' : 'active-owner';
    @endphp

    {{-- ─── Mobile Sidebar Overlay ────────────────────────────── --}}
    <div x-show="mobileOpen" x-cloak @click="mobileOpen = false"
         class="fixed inset-0 z-40 bg-slate-900/20 backdrop-blur-sm lg:hidden"></div>

    {{-- ─── Sidebar ─────────────────────────────────────────────── --}}
    <aside class="fixed top-0 left-0 z-50 h-full w-[260px] flex flex-col border-r border-slate-200 bg-white lg:translate-x-0 transition-transform duration-300"
           :class="mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <div class="flex items-center gap-3 px-6 h-20 shrink-0">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-lg
                        {{ $isAdmin ? 'bg-rose-600 shadow-rose-100' : 'bg-indigo-600 shadow-indigo-100' }}">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div>
                <p class="text-slate-900 font-extrabold text-lg tracking-tight">Tonedev</p>
                <p class="text-[10px] font-black uppercase tracking-widest text-{{ $accent }}-500">
                    {{ $isAdmin ? 'System Admin' : 'Shop Manager' }}
                </p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-4 space-y-4">

            @if($isAdmin)
                {{-- 👑 ADMIN SIDEBAR MENU ────────────────────────── --}}
                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-3 mb-2">Overview</p>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? $activeClass : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        แดชบอร์ดระบบ
                    </a>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-3 mb-2">System Control</p>
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? $activeClass : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        จัดการผู้ใช้งาน
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? $activeClass : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        ออเดอร์ทั้งหมด
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? $activeClass : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                        จัดการหมวดหมู่
                    </a>
                </div>
            @else
                {{-- 🏪 OWNER SIDEBAR MENU ────────────────────────── --}}
                <div >
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Store Dashboard</p>
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-2 sidebar-link px-3 py-2 rounded-md hover:bg-slate-100  transition-all {{ request()->routeIs('owner.dashboard') ? $activeClass : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        หน้าแรกของฉัน
                    </a>
                </div>

                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Store Order</p>
                    <a href="{{ route('owner.orders.index') }}" class="flex items-center gap-2 sidebar-link px-3 py-2 rounded-md hover:bg-slate-100  transition-all {{ request()->routeIs('owner.orders.*') ? $activeClass : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        คำสั่งซื้อของลูกค้า
                        @php $pend = \App\Models\Order::where('status','pending')->count(); @endphp
                        @if($pend > 0)
                            <span class="ml-auto bg-amber-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-lg shadow-sm">{{ $pend }}</span>
                        @endif
                    </a>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Store Inventory</p>
                    <a href="{{ route('owner.orders.index') }}" class="flex items-center gap-2 sidebar-link px-3 py-2 rounded-md hover:bg-slate-100  transition-all {{ request()->routeIs('owner.orders.*') ? $activeClass : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        คลังสินค้า
                    </a>
                </div>
            @endif

            {{-- Common Links --}}
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Others</p>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 sidebar-link px-3 py-2 rounded-md hover:bg-slate-100  transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    เปิดหน้าร้านค้า
                </a>
            </div>
        </nav>

        <div class="p-2 border-t border-slate-100">
            <div class="flex justify-between bg-slate-50 p-1.5 rounded-2xl border border-slate-100">
                {{-- User Avatar & Role Badge --}}
                <div class="flex items-center gap-3 ">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-black text-white font-semibold text-sm shadow-sm
                                {{ $isAdmin ? 'bg-rose-500' : 'bg-indigo-500' }}">
                        {{ strtoupper(substr($user->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($user->last_name ?? 'N', 0, 1)) }}
                    </div>
                    <div class="hidden lg:block">
                        <p class="text-slate-900 text-xs font-bold leading-none">{{ $user->first_name }}</p>
                        <span class="text-[10px] font-bold text-{{ $accentColor }}-600 uppercase tracking-tighter">
                            {{ $isAdmin ? 'Admin' : 'Owner' }}
                        </span>
                    </div>
                </div>
                <button onclick="doLogout()" class="w-1/5 items-center justify-center gap-2 px-4 py-3 text-slate-600 text-xs font-black hover:rounded-2xl hover:bg-rose-50 hover:text-rose-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </div>
        </div>
    </aside>

    {{-- ─── Main Content Area ──────────────────────────────────── --}}
    <div class="lg:ml-[260px] min-h-screen flex flex-col relative z-10">

        <header class="sticky top-0 z-30 h-20 flex items-center justify-between px-6 bg-white/80 backdrop-blur-md border-b border-slate-200/60">
            <div class="flex items-center gap-4">
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2.5 rounded-xl bg-slate-100 text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-slate-900 font-black text-lg">@yield('page-title')</h1>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">@yield('page-subtitle')</p>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-4">
                <div class="flex items-center gap-1 border-r border-slate-100 pr-2 sm:pr-4">
                    <button class="p-2 rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all duration-200 group" title="ช่วยเหลือ">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </button>
                    <button class="p-2 rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all duration-200 group relative" title="ข้อความ">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        <span class="absolute top-1.5 right-1 w-3 h-3 bg-indigo-500 border-2 border-white rounded-full"></span>
                    </button>
                    <button class="p-2 rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all duration-200 group relative" title="แจ้งเตือน">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-3 h-3 bg-rose-500 border-2 border-white rounded-full animate-pulse"></span>
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden md:flex flex-col border-r border-slate-100 items-center pr-2 mr-1">
                        <span class="text-slate-900 text-sm font-black leading-tight" id="hdr-clock"></span>
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider" id="hdr-date"></span>
                    </div>
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-black text-white font-semibold text-sm shadow-sm
                            {{ $isAdmin ? 'bg-rose-500' : 'bg-indigo-500' }}">
                        {{ strtoupper(substr($user->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($user->last_name ?? 'N', 0, 1)) }}
                    </div>
                </div>
                
            </div>
        </header>

        <main class="flex-1 p-6 lg:p-10">
            @yield('content')
        </main>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('hdr-clock').textContent = now.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('hdr-date').textContent = now.toLocaleDateString('th-TH', { weekday: 'short', day: 'numeric', month: 'short' });
        }
        setInterval(updateClock, 60000); updateClock();

        function doLogout() {
            if(!confirm('ยืนยันการออกจากระบบ?')) return;
            axios.post('/api/auth/logout').finally(() => {
                document.cookie = "jwt_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                localStorage.clear();
                window.location.href = '{{ route("login") }}';
            });
        }
    </script>
    @stack('scripts')
</body>
</html>