@extends('layouts.simple')

@section('content')
<div class="max-w-3xl mx-auto py-20 px-4 text-center">
    <div class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-green-100 text-green-600 rounded-full">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
    </div>
    
    <h1 class="text-4xl font-extrabold text-gray-900 mb-4">ขอบคุณสำหรับการสั่งซื้อ!</h1>
    <p class="text-xl text-gray-600 mb-8">เราได้รับคำสั่งซื้อของคุณเรียบร้อยแล้ว เจ้าหน้าที่กำลังดำเนินการตรวจสอบ</p>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-10 text-left">
        <h3 class="text-lg font-bold mb-4 border-b pb-2">รายละเอียดคำสั่งซื้อ</h3>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-500">เลขที่สั่งซื้อ:</span>
                <span class="font-mono font-bold text-indigo-600">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">ยอดชำระทั้งสิ้น:</span>
                <span class="font-bold">฿{{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">ที่อยู่จัดส่ง:</span>
                <span class="text-right w-1/2">{{ $order->shipping_address }}</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="/" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
            กลับไปหน้าหลัก
        </a>
        <button onclick="window.print()" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-xl font-bold hover:bg-gray-300 transition">
            พิมพ์ใบเสร็จ
        </button>
    </div>
</div>
@endsection