@extends('layouts.profile')

@section('profile-content')

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">ความเป็นส่วนตัว</h2>
            <p class="text-xs text-gray-400 mt-0.5">จัดการการตั้งค่าความเป็นส่วนตัวและการแสดงผลบัญชีของคุณ</p>
        </div>

        <div class="px-6 sm:px-8 py-6 space-y-6" x-data="{
            profilePublic: false,
            emailMarketing: true,
            emailOrders: true,
            emailSecurity: true
        }">

            {{-- การมองเห็นโปรไฟล์ --}}
            <div>
                <h3 class="text-sm font-bold text-gray-800 mb-4">การมองเห็นโปรไฟล์</h3>
                <div class="space-y-4">

                    <div class="flex items-center justify-between py-3 border-b border-gray-50">
                        <div class="flex-1 pr-4">
                            <p class="text-sm font-medium text-gray-800">โปรไฟล์สาธารณะ</p>
                            <p class="text-xs text-gray-400 mt-0.5">อนุญาตให้ผู้อื่นเห็นข้อมูลโปรไฟล์ของคุณ</p>
                        </div>
                        <button
                            type="button"
                            @click="profilePublic = !profilePublic"
                            :class="profilePublic ? 'bg-indigo-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 shrink-0"
                        >
                            <span
                                :class="profilePublic ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                            ></span>
                        </button>
                    </div>

                </div>
            </div>

            {{-- การแจ้งเตือนทางอีเมล --}}
            <div>
                <h3 class="text-sm font-bold text-gray-800 mb-4">การแจ้งเตือนทางอีเมล</h3>
                <div class="space-y-1">

                    <div class="flex items-center justify-between py-3 border-b border-gray-50">
                        <div class="flex-1 pr-4">
                            <p class="text-sm font-medium text-gray-800">โปรโมชันและข่าวสาร</p>
                            <p class="text-xs text-gray-400 mt-0.5">รับอีเมลเกี่ยวกับโปรโมชัน ส่วนลด และสินค้าใหม่</p>
                        </div>
                        <button
                            type="button"
                            @click="emailMarketing = !emailMarketing"
                            :class="emailMarketing ? 'bg-indigo-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 shrink-0"
                        >
                            <span
                                :class="emailMarketing ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                            ></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gray-50">
                        <div class="flex-1 pr-4">
                            <p class="text-sm font-medium text-gray-800">การอัปเดตคำสั่งซื้อ</p>
                            <p class="text-xs text-gray-400 mt-0.5">รับอีเมลเมื่อสถานะคำสั่งซื้อเปลี่ยนแปลง</p>
                        </div>
                        <button
                            type="button"
                            @click="emailOrders = !emailOrders"
                            :class="emailOrders ? 'bg-indigo-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 shrink-0"
                        >
                            <span
                                :class="emailOrders ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                            ></span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between py-3">
                        <div class="flex-1 pr-4">
                            <p class="text-sm font-medium text-gray-800">การแจ้งเตือนด้านความปลอดภัย</p>
                            <p class="text-xs text-gray-400 mt-0.5">รับอีเมลเมื่อมีการเข้าสู่ระบบจากอุปกรณ์ใหม่</p>
                        </div>
                        <button
                            type="button"
                            @click="emailSecurity = !emailSecurity"
                            :class="emailSecurity ? 'bg-indigo-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 shrink-0"
                        >
                            <span
                                :class="emailSecurity ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white shadow-sm transition-transform duration-200"
                            ></span>
                        </button>
                    </div>

                </div>
            </div>

            {{-- Coming soon notice --}}
            <div class="flex items-center gap-2 px-4 py-3 bg-amber-50 border border-amber-100 rounded-xl">
                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-amber-700">การตั้งค่าความเป็นส่วนตัวกำลังอยู่ในระหว่างการพัฒนา การเปลี่ยนแปลงจะยังไม่ถูกบันทึก</p>
            </div>

        </div>

    </div>

@endsection
