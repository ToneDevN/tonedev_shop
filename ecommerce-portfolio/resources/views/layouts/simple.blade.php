<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tonedev Shop</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('tonedev_logo.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 antialiased min-h-screen font-sans">

    {{-- ─── Navbar ─────────────────────────────────────────────────── --}}
    <nav
        x-data="{ scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 12"
        :class="scrolled ? 'shadow-md bg-white/90 backdrop-blur-xl' : 'bg-white/95'"
        class="sticky top-0 z-50 border-b border-gray-100 transition-all duration-300"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                {{-- Logo --}}
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-sm group-hover:shadow-indigo-200 group-hover:scale-110 transition-all duration-200">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent tracking-tight">
                        Tonedev Shop
                    </span>
                </a>

                {{-- Nav Links --}}
                <div class="flex items-center gap-1 sm:gap-2">
                    <a href="/"
                       class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-indigo-50 transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        สินค้าทั้งหมด
                    </a>

                    <a href="{{ route('orders.track') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-indigo-50 transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        ติดตามสินค้า
                    </a>

                    {{-- Cart Button --}}
                    <a href="{{ route('cart.index') }}"
                       class="relative inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-sm hover:shadow-indigo-200 hover:shadow-md transition-all duration-150 ml-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="hidden sm:inline">ตะกร้า</span>

                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow ring-2 ring-white">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                </div>

            </div>
        </div>
    </nav>

    {{-- ─── Main Content ────────────────────────────────────────────── --}}
    <main class="min-h-[60vh]">
        @yield('content')
    </main>

    {{-- ─── Footer ──────────────────────────────────────────────────── --}}
    <footer class="bg-gray-950 text-gray-400 mt-0">

        {{-- Top gradient bar --}}
        <div class="h-px bg-gradient-to-r from-transparent via-indigo-500 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">

                {{-- Brand --}}
                <div class="sm:col-span-1">
                    <a href="/" class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="text-white text-lg font-extrabold tracking-tight">Tonedev Shop</span>
                    </a>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        ช้อปสินค้าคุณภาพดี ราคาเป็นมิตร พร้อมบริการที่ใส่ใจทุกรายละเอียด
                    </p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h3 class="text-white text-sm font-semibold uppercase tracking-widest mb-4">เมนู</h3>
                    <ul class="space-y-2.5">
                        <li>
                            <a href="/" class="text-sm text-gray-500 hover:text-indigo-400 flex items-center gap-2 transition-colors duration-150">
                                <span class="w-1 h-1 rounded-full bg-indigo-500 inline-block"></span>
                                หน้าแรก
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.track') }}" class="text-sm text-gray-500 hover:text-indigo-400 flex items-center gap-2 transition-colors duration-150">
                                <span class="w-1 h-1 rounded-full bg-indigo-500 inline-block"></span>
                                ติดตามสถานะสินค้า
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart.index') }}" class="text-sm text-gray-500 hover:text-indigo-400 flex items-center gap-2 transition-colors duration-150">
                                <span class="w-1 h-1 rounded-full bg-indigo-500 inline-block"></span>
                                ตะกร้าสินค้า
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Support --}}
                <div>
                    <h3 class="text-white text-sm font-semibold uppercase tracking-widest mb-4">ติดต่อเรา</h3>
                    <ul class="space-y-2.5 text-sm text-gray-500">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            contact@tonedev.shop
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            จ.–ศ. 09:00 – 18:00 น.
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-600">
                <span>© 2026 Tonedev Shop. All rights reserved.</span>
                <span class="flex items-center gap-1">
                    Built with
                    <svg class="w-3.5 h-3.5 text-rose-500 mx-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                    using Laravel & Tailwind CSS
                </span>
            </div>
        </div>

    </footer>

</body>
</html>
