@extends('layouts.simple')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">แผงควบคุมเจ้าของร้าน (Owner Dashboard)</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-indigo-600 p-6 rounded-2xl shadow-lg text-white">
            <p class="text-indigo-100 text-sm font-medium">ยอดขายทั้งหมด</p>
            <h3 class="text-3xl font-bold">฿{{ number_format($totalSales, 2) }}</h3>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm font-medium">คำสั่งซื้อใหม่</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $newOrdersCount }} รายการ</h3>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm font-medium">สินค้าในสต็อก</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalProducts }} ชิ้น</h3>
        </div>
    </div>

    <div class="flex gap-4">
        <a href="{{ route('owner.products.create') }}" class="bg-white border border-gray-200 px-6 py-3 rounded-xl hover:bg-gray-50 transition font-medium">
            + เพิ่มสินค้าใหม่
        </a>
        <a href="{{ route('owner.orders.index') }}" class="bg-white border border-gray-200 px-6 py-3 rounded-xl hover:bg-gray-50 transition font-medium">
            ดูรายการสั่งซื้อทั้งหมด
        </a>
    </div>
</div>
@endsection