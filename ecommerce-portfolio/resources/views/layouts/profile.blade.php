@extends('layouts.simple')

@section('content')

<div class="min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex gap-5 items-start">

            {{-- ─── Sidebar ──────────────────────────────────────────── --}}
            <aside class="hidden md:flex flex-col gap-3 w-52 shrink-0">

                {{-- Account section --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 pt-4 pb-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">บัญชีของฉัน</p>
                    </div>
                    <ul class="pb-2">
                        <li>
                            <a href="{{ route('profile.show') }}"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm transition-all border-l-[3px]
                                      {{ request()->routeIs('profile.show') ? 'font-semibold text-indigo-600 bg-indigo-50 border-indigo-500' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 border-transparent hover:border-indigo-200' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                โปรไฟล์
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.address') }}"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm transition-all border-l-[3px]
                                      {{ request()->routeIs('profile.address') ? 'font-semibold text-indigo-600 bg-indigo-50 border-indigo-500' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 border-transparent hover:border-indigo-200' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                ที่อยู่จัดส่ง
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.password') }}"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm transition-all border-l-[3px]
                                      {{ request()->routeIs('profile.password') ? 'font-semibold text-indigo-600 bg-indigo-50 border-indigo-500' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 border-transparent hover:border-indigo-200' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                เปลี่ยนรหัสผ่าน
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.privacy') }}"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm transition-all border-l-[3px]
                                      {{ request()->routeIs('profile.privacy') ? 'font-semibold text-indigo-600 bg-indigo-50 border-indigo-500' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 border-transparent hover:border-indigo-200' }}">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                ความเป็นส่วนตัว
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Activity section --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 pt-4 pb-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">กิจกรรม</p>
                    </div>
                    <ul class="pb-2">
                        <li>
                            <a href="{{ route('profile.orders') }}"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm transition-all border-l-[3px]
                                      {{ request()->routeIs('profile.orders') ? 'font-semibold text-indigo-600 bg-indigo-50 border-indigo-500' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 border-transparent hover:border-indigo-200' }}">
                                <svg class="w-4 h-4 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                การสั่งซื้อของฉัน
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.notifications') }}"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm transition-all border-l-[3px]
                                      {{ request()->routeIs('profile.notifications') ? 'font-semibold text-indigo-600 bg-indigo-50 border-indigo-500' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 border-transparent hover:border-indigo-200' }}">
                                <svg class="w-4 h-4 shrink-0 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                การแจ้งเตือน
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.coupons') }}"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm transition-all border-l-[3px]
                                      {{ request()->routeIs('profile.coupons') ? 'font-semibold text-indigo-600 bg-indigo-50 border-indigo-500' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 border-transparent hover:border-indigo-200' }}">
                                <svg class="w-4 h-4 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                คูปองของฉัน
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.coins') }}"
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm transition-all border-l-[3px]
                                      {{ request()->routeIs('profile.coins') ? 'font-semibold text-indigo-600 bg-indigo-50 border-indigo-500' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 border-transparent hover:border-indigo-200' }}">
                                <svg class="w-4 h-4 shrink-0 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                คอยน์ของฉัน
                            </a>
                        </li>
                    </ul>
                </div>

            </aside>

            {{-- ─── Main Content (หน้าย่อยแต่ละหน้าแทนที่ตรงนี้) ─────── --}}
            <div class="flex-1 min-w-0 space-y-4 w-full">
                @yield('profile-content')
            </div>

        </div>
    </div>
</div>

@endsection
