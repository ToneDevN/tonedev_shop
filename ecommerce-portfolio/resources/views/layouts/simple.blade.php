<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tonedev Shop</title>
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
<body class="bg-slate-50 antialiased min-h-screen font-sans">

    {{-- ─── Navbar ─────────────────────────────────────────────────── --}}
    @include('partials.navbar')

    {{-- ─── Main Content ────────────────────────────────────────────── --}}
    <main class="min-h-[60vh]">
        @yield('content')
    </main>

    {{-- ─── Toast ───────────────────────────────────────────────────── --}}
    <x-toast />

    {{-- ─── Global Axios 401 interceptor ─────────────────────────── --}}
    <script>
    (function () {
        if (typeof axios === 'undefined') return;

        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response && error.response.status === 401) {
                    // เก็บ URL ปัจจุบันเพื่อกลับมาหลัง login (เฉพาะ path เพื่อป้องกัน open redirect)
                    const intended = encodeURIComponent(window.location.pathname + window.location.search);
                    // หลีกเลี่ยง redirect loop เมื่ออยู่ที่หน้า login อยู่แล้ว
                    if (!window.location.pathname.startsWith('/login')) {
                        window.location.href = '{{ route('login') }}?redirect=' + intended;
                    }
                }
                return Promise.reject(error);
            }
        );
    })();
    </script>

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

    @stack('scripts')
</body>
</html>
