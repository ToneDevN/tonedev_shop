<nav
    x-data="{ open: false, dropdownOpen: false }"
    @scroll.window="$el.classList.toggle('shadow-md', window.scrollY > 12)"
    class="sticky top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-gray-100 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- ─── Logo ──────────────────────────────────────────── --}}
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-sm group-hover:scale-110 transition-all duration-200">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <span class="text-lg font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent tracking-tight">
                    Tonedev Shop
                </span>
            </a>

            {{-- ─── Desktop Nav ─────────────────────────────────── --}}
            <div class="hidden sm:flex items-center gap-1">

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}"
                   class="relative inline-flex items-center p-2 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute top-0.5 right-0.5 min-w-[16px] h-4 bg-rose-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center px-1">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>

                @if(auth('api')->check())
                    @php $authUser = auth('api')->user(); @endphp

                    {{-- Owner / Admin shortcut --}}
                    @if(in_array($authUser->role, ['owner', 'admin']))
                        <a href="{{ route('owner.dashboard') }}"
                           class="inline-flex items-center gap-1.5 text-sm font-medium text-amber-600 hover:text-amber-700 px-3 py-2 rounded-lg hover:bg-amber-50 transition-all duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            จัดการร้าน
                        </a>
                    @endif

                    {{-- User dropdown --}}
                    <div class="relative" @click.outside="dropdownOpen = false">
                        <button
                            @click="dropdownOpen = !dropdownOpen"
                            class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-indigo-50 transition-all duration-150"
                        >
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($authUser->first_name ?: 'U', 0, 1)) }}
                            </div>
                            <span class="max-w-[100px] truncate">{{ $authUser->first_name ?: $authUser->email }}</span>

                            @if($authUser->role === 'admin')
                                <span class="px-1.5 py-0.5 text-[10px] font-bold bg-rose-100 text-rose-600 rounded-full">Admin</span>
                            @elseif($authUser->role === 'owner')
                                <span class="px-1.5 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full">Owner</span>
                            @endif

                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div
                            x-show="dropdownOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50"
                        >
                            {{-- User info --}}
                            <div class="px-4 py-2.5 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $authUser->full_name }}</p>
                                <p class="text-xs text-gray-400 truncate mt-0.5">{{ $authUser->email }}</p>
                            </div>

                            <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                โปรไฟล์
                            </a>
                            <a href="{{ route('profile.orders') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                คำสั่งซื้อของฉัน
                            </a>

                            <div class="my-1 border-t border-gray-100"></div>

                            <button
                                onclick="jwtLogout()"
                                class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-rose-500 hover:bg-rose-50 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                ออกจากระบบ
                            </button>
                        </div>
                    </div>

                @else
                    {{-- Guest: Login / Register --}}
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-indigo-50 transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        เข้าสู่ระบบ
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-1.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg shadow-sm shadow-indigo-200 transition-all duration-150">
                        สมัครสมาชิก
                    </a>
                @endif

            </div>

            {{-- ─── Hamburger (mobile) ─────────────────────────── --}}
            <button @click="open = !open"
                    class="sm:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    {{-- ─── Mobile Menu ─────────────────────────────────────────── --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('cart.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                ตะกร้าสินค้า
            </a>

            @if(auth('api')->check())
                @php $authUser = auth('api')->user(); @endphp

                <div class="px-3 py-2 border-t border-gray-100 mt-2">
                    <p class="text-sm font-semibold text-gray-900">{{ $authUser->full_name }}</p>
                    <p class="text-xs text-gray-400">{{ $authUser->email }}</p>
                </div>

                <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    โปรไฟล์
                </a>
                <a href="{{ route('profile.orders') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    คำสั่งซื้อของฉัน
                </a>

                @if(in_array($authUser->role, ['owner', 'admin']))
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 text-sm text-amber-600 hover:bg-amber-50 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        จัดการร้าน
                    </a>
                @endif

                <button onclick="jwtLogout()" class="w-full flex items-center gap-2.5 px-3 py-2.5 text-sm text-rose-500 hover:bg-rose-50 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    ออกจากระบบ
                </button>

            @else
                <div class="flex flex-col gap-2 pt-2 border-t border-gray-100">
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-indigo-600 border border-indigo-200 rounded-xl hover:bg-indigo-50 transition-colors">
                        เข้าสู่ระบบ
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors">
                        สมัครสมาชิก
                    </a>
                </div>
            @endif
        </div>
    </div>
</nav>

<script>
function jwtLogout() {
    axios.post('/api/auth/logout', {}, {
        withCredentials: true,
    }).finally(() => {
        localStorage.removeItem('jwt_token');
        localStorage.removeItem('user');
        window.location.href = '/';
    });
}
</script>
