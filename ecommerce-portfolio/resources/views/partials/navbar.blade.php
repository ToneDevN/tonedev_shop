<nav
    x-data="navbarAuth()"
    x-init="checkAuth()"
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

            {{-- Search Bar (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-md mx-6 relative" @click.outside="showAutocomplete = false">
                <form @submit.prevent="handleSearch()" class="w-full relative group">
                    <input 
                        type="text" 
                        name="search" 
                        x-model="searchQuery"
                        @input.debounce.300ms="fetchAutocomplete"
                        @focus="if(searchQuery.length > 0) showAutocomplete = true"
                        autocomplete="off"
                        placeholder="ค้นหาสินค้าที่ต้องการ..."
                        class="block w-full pl-4 pr-12 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all shadow-sm"
                    >
                    <button type="submit" class="absolute inset-y-1 right-1 px-3 flex items-center bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>

                {{-- Autocomplete Dropdown --}}
                <div x-show="showAutocomplete && autocompleteResults.length > 0" 
                     x-transition.opacity.duration.200ms
                     style="display: none;"
                     class="absolute top-full left-0 mt-2 w-full bg-white rounded-xl shadow-xl border border-gray-100 overflow-y-auto max-h-[440px] z-50 custom-scrollbar">
                    <ul class="py-2">
                        <template x-for="result in autocompleteResults" :key="result.id">
                            <li>
                                <a :href="`/product/${result.slug}`" class="flex items-center gap-3 px-4 py-2 hover:bg-indigo-50 text-sm text-gray-700 hover:text-indigo-600 transition-colors">
                                    <template x-if="result.cover_image">
                                        <img :src="result.cover_image.image_path" class="w-8 h-8 rounded-md object-cover bg-gray-50 flex-shrink-0" alt="">
                                    </template>
                                    <template x-if="!result.cover_image">
                                        <div class="w-8 h-8 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 flex-shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    </template>
                                    <span x-text="result.name" class="line-clamp-1 font-medium"></span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            {{-- Nav Links --}}
            <div class="flex items-center gap-1 sm:gap-2">

                {{-- Cart Button --}}
                <a href="{{ route('cart.index') }}"
                   class="relative inline-flex items-center p-2 text-gray-900 hover:text-indigo-600 hover:bg-gray-100 rounded-xl transition-all duration-150 ml-1 group">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>

                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="absolute top-0.5 right-0.5 min-w-[18px] h-[18px] bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow ring-2 ring-white group-hover:ring-gray-100 transition-all">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
                
                {{-- Owner / Admin Links (แสดงเมื่อมีสิทธิ์) --}}
                <template x-if="isLoggedIn && (user.role === 'owner' || user.role === 'admin')">
                    <a href="{{ route('owner.dashboard') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-amber-600 hover:text-amber-700 px-3 py-2 rounded-lg hover:bg-amber-50 transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        จัดการร้าน
                    </a>
                </template>

                <template x-if="isLoggedIn && user.role === 'admin'">
                    <a href="{{ route('owner.orders.index') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-rose-600 hover:text-rose-700 px-3 py-2 rounded-lg hover:bg-rose-50 transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        แอดมิน
                    </a>
                </template>

                {{-- สถานะล็อกอินแล้ว (Dropdown) --}}
                <div class="relative hidden sm:block" x-show="isLoggedIn" @click.outside="dropdownOpen = false">
                    <button
                        @click="dropdownOpen = !dropdownOpen"
                        class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-indigo-50 transition-all duration-150"
                    >
                        <template x-if="user.avatar || user.image">
                            <img :src="(user.avatar || user.image).startsWith('http') ? (user.avatar || user.image) : `/storage/${(user.avatar || user.image).replace('public/', '')}`" 
                                 class="w-7 h-7 rounded-full object-cover shadow-sm bg-gray-200 border border-gray-100" 
                                 alt="User Avatar">
                        </template>
                        <template x-if="!(user.avatar || user.image)">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold" x-text="userInitial"></div>
                        </template>
                        <span class="max-w-[100px] truncate" x-text="user.name || user.first_name || 'My Profile'"></span>
                        
                        {{-- Role badge --}}
                        <template x-if="user.role === 'admin'">
                            <span class="px-1.5 py-0.5 text-[10px] font-bold bg-rose-100 text-rose-600 rounded-full">Admin</span>
                        </template>
                        <template x-if="user.role === 'owner'">
                            <span class="px-1.5 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full">Owner</span>
                        </template>

                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="dropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div
                        x-show="dropdownOpen"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50"
                    >
                        {{-- User info --}}
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900 truncate" x-text="user.name || `${user.first_name || ''} ${user.last_name || ''}`"></p>
                            <p class="text-xs text-gray-500 truncate" x-text="user.email"></p>
                        </div>

                        <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            โปรไฟล์
                        </a>

                        <div class="my-1 border-t border-gray-100"></div>

                        {{-- Logout --}}
                        <button @click="logout()" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-rose-500 hover:bg-rose-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            ออกจากระบบ
                        </button>
                    </div>
                </div>

                {{-- สถานะยังไม่ได้ล็อกอิน (ปุ่ม Login / Register) --}}
                <div x-show="!isLoggedIn" class="flex gap-1 sm:gap-2">
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg hover:bg-indigo-50 transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        เข้าสู่ระบบ
                    </a>
                    <a href="{{ route('register') }}"
                       class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-2 rounded-lg transition-all duration-150">
                        สมัครสมาชิก
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</nav>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('navbarAuth', () => ({
        scrolled: false,
        dropdownOpen: false,
        isLoggedIn: false,
        user: {},
        userInitial: '',
        searchQuery: '{{ request('search') }}',
        showAutocomplete: false,
        autocompleteResults: [],

        async fetchAutocomplete() {
            if (!this.searchQuery || this.searchQuery.trim() === '') {
                this.autocompleteResults = [];
                this.showAutocomplete = false;
                return;
            }

            try {
                const res = await axios.get(`{{ route('products.autocomplete') }}?search=${encodeURIComponent(this.searchQuery.trim())}`);
                this.autocompleteResults = res.data;
                this.showAutocomplete = this.autocompleteResults.length > 0;
            } catch (error) {
                console.error("Autocomplete fetch error: ", error);
            }
        },

        async handleSearch() {
            if (!this.searchQuery || this.searchQuery.trim() === '') {
                const input = document.querySelector('input[name="search"]');
                if (input) {
                    input.focus();
                    input.classList.add('ring-2', 'ring-rose-500/20', 'border-rose-500');
                    setTimeout(() => {
                        input.classList.remove('ring-2', 'ring-rose-500/20', 'border-rose-500');
                    }, 1000);
                }
                return;
            }

            const searchUrl = `{{ route('products.search') }}?search=${encodeURIComponent(this.searchQuery.trim())}`;

            // หากเราไม่ได้อยู่ที่หน้า search → ให้ Redirect ไปหน้าค้นหาตามปกติ
            if (window.location.pathname !== '/search') {
                window.location.href = searchUrl;
                return;
            }

            // หากอยู่ที่หน้า search อยู่แล้ว → ใช้ Axios เพื่อดึงข้อมูลเฉพาะส่วน Main Content มาอัปเดตแบบ Dynamic (Smooth Experience)
            try {
                const response = await axios.get(searchUrl);
                const parser = new DOMParser();
                const doc = parser.parseFromString(response.data, 'text/html');
                const newMainContent = doc.querySelector('main').innerHTML;
                
                if (newMainContent) {
                    document.querySelector('main').innerHTML = newMainContent;
                    history.pushState(null, '', searchUrl);
                    // อัปเดต Title ด้วยถ้าต้องการ
                    document.title = doc.title;
                }
            } catch (error) {
                console.error('Search failed:', error);
                window.location.href = searchUrl;
            }
        },

        async checkAuth() {
            const token = localStorage.getItem('jwt_token');
            const userData = localStorage.getItem('user');

            // 1) แสดง UI ทันทีจาก localStorage (ไม่รอ network)
            if (token && userData) {
                try {
                    this.user = JSON.parse(userData);
                    this.isLoggedIn = true;
                    
                    const name = this.user.name || this.user.first_name || 'User';
                    this.userInitial = name.charAt(0).toUpperCase();
                } catch (e) {
                    this.logoutLocally();
                    return;
                }
            } else {
                this.isLoggedIn = false;
                return; // ไม่มี token เลย → ไม่ต้อง verify
            }

            // 2) Verify กับ server ผ่าน cookie เท่านั้น
            // ไม่ส่ง Bearer header เพื่อให้ตรวจสอบ cookie จริงๆ
            // ถ้า cookie ถูกลบ → 401 → logoutLocally()
            try {
                const res = await axios.get('/api/auth/me', {
                    withCredentials: true,
                });

                if (res.data.success) {
                    // sync ข้อมูล user ให้เป็นปัจจุบัน
                    this.user = res.data.user;
                    localStorage.setItem('user', JSON.stringify(res.data.user));
                    const currentName = this.user.name || this.user.first_name || 'User';
                    this.userInitial = currentName.charAt(0).toUpperCase();
                }
            } catch (e) {
                // ลบ session เฉพาะเมื่อ server บอกว่า token ไม่ valid (401)
                // ไม่ลบถ้าเป็น network error หรือ error อื่นๆ
                if (e.response && e.response.status === 401) {
                    this.logoutLocally();
                }
                // กรณีอื่น (timeout, server error ฯลฯ) ให้คงสถานะ login ไว้ก่อน
            }
        },

        logout() {
            axios.post('/api/auth/logout', {}, {
                withCredentials: true,
            }).finally(() => {
                this.logoutLocally();
            });
        },

        logoutLocally() {
            localStorage.removeItem('jwt_token');
            localStorage.removeItem('user');
            window.location.href = '/';
        }
    }))
})
</script>