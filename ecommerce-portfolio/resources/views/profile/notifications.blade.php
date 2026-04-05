@extends('layouts.profile')

@section('profile-content')

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">การแจ้งเตือน</h2>
            <p class="text-xs text-gray-400 mt-0.5">การแจ้งเตือนและกิจกรรมล่าสุดของบัญชีคุณ</p>
        </div>

        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-600">ยังไม่มีการแจ้งเตือน</p>
            <p class="text-xs text-gray-400 mt-1 max-w-xs">เมื่อมีการแจ้งเตือนใหม่ จะแสดงที่นี่</p>
        </div>

    </div>

@endsection
