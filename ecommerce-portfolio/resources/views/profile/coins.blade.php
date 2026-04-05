@extends('layouts.profile')

@section('profile-content')

    {{-- Coin Balance Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">คอยน์ของฉัน</h2>
            <p class="text-xs text-gray-400 mt-0.5">สะสมคอยน์เพื่อรับส่วนลดในการสั่งซื้อครั้งถัดไป</p>
        </div>

        {{-- Balance Display --}}
        <div class="px-6 sm:px-8 py-8">
            <div class="bg-gradient-to-br from-amber-400 to-yellow-500 rounded-2xl p-6 flex items-center gap-5 shadow-lg shadow-amber-100 max-w-sm">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white/80">ยอดคอยน์คงเหลือ</p>
                    <p class="text-4xl font-black text-white mt-0.5">0</p>
                    <p class="text-xs text-white/70 mt-1">คอยน์</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Transaction History --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-900">ประวัติการใช้คอยน์</h3>
        </div>

        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-14 px-6 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-600">ยังไม่มีประวัติการใช้คอยน์</p>
            <p class="text-xs text-gray-400 mt-1 max-w-xs">เมื่อคุณได้รับหรือใช้คอยน์ ประวัติจะแสดงที่นี่</p>
        </div>

    </div>

@endsection
