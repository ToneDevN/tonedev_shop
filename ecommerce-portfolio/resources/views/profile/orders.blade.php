@extends('layouts.profile')

@section('profile-content')

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900">การสั่งซื้อของฉัน</h2>
                <p class="text-xs text-gray-400 mt-0.5">ติดตามและดูประวัติการสั่งซื้อทั้งหมดของคุณ</p>
            </div>
            @if($orders->total() > 0)
                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">
                    {{ $orders->total() }} รายการ
                </span>
            @endif
        </div>

        @if($orders->isEmpty())
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-600">ยังไม่มีคำสั่งซื้อ</p>
                <p class="text-xs text-gray-400 mt-1 max-w-xs">เมื่อคุณทำการสั่งซื้อสินค้า รายการจะแสดงที่นี่</p>
                <a href="{{ route('home') }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 border border-indigo-200 hover:bg-indigo-50 px-4 py-2 rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    เริ่มช้อปปิ้ง
                </a>
            </div>
        @else
            <div class="divide-y divide-gray-50">
                @foreach($orders as $order)
                    @php
                        $statusMap = [
                            'pending'   => ['label' => 'รอดำเนินการ', 'class' => 'text-amber-700 bg-amber-50 border-amber-100'],
                            'paid'      => ['label' => 'ชำระแล้ว',    'class' => 'text-blue-700 bg-blue-50 border-blue-100'],
                            'shipped'   => ['label' => 'กำลังจัดส่ง', 'class' => 'text-indigo-700 bg-indigo-50 border-indigo-100'],
                            'completed' => ['label' => 'สำเร็จ',       'class' => 'text-emerald-700 bg-emerald-50 border-emerald-100'],
                            'cancelled' => ['label' => 'ยกเลิก',       'class' => 'text-rose-700 bg-rose-50 border-rose-100'],
                        ];
                        $status = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'text-gray-600 bg-gray-50 border-gray-100'];
                    @endphp
                    <div class="px-6 sm:px-8 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">#{{ $order->id }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                @if($order->tracking_number)
                                    <p class="text-xs text-indigo-600 mt-0.5">
                                        <span class="text-gray-400">เลขพัสดุ:</span> {{ $order->tracking_number }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3 sm:gap-4">
                            <span class="inline-flex items-center text-xs font-semibold border px-2.5 py-1 rounded-full {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>
                            <span class="text-sm font-bold text-gray-900">
                                ฿{{ number_format($order->total_amount, 2) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($orders->hasPages())
                <div class="px-6 sm:px-8 py-4 border-t border-gray-100">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif

    </div>

@endsection
