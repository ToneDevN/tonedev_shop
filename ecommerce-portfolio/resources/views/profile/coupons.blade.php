@extends('layouts.profile')

@section('profile-content')

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">คูปองของฉัน</h2>
            <p class="text-xs text-gray-400 mt-0.5">คูปองส่วนลดและโปรโมชันที่ใช้ได้</p>
        </div>

        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-600">ยังไม่มีคูปอง</p>
            <p class="text-xs text-gray-400 mt-1 max-w-xs">คูปองส่วนลดและโค้ดโปรโมชันของคุณจะแสดงที่นี่</p>
        </div>

    </div>

@endsection
