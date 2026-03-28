@extends('layouts.simple')

@section('content')
<div class="max-w-md mx-auto py-20 px-4">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-900">ติดตามสถานะคำสั่งซื้อ</h1>
        <p class="text-gray-500 mt-2">กรอกข้อมูลเพื่อตรวจสอบสถานะการจัดส่งสินค้าของคุณ</p>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('orders.track.search') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">เลขที่สั่งซื้อ</label>
                <input type="text" name="order_number" required placeholder="เช่น ORD-65BXXXX"
                       class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm uppercase">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">เบอร์โทรศัพท์ที่ใช้สั่งซื้อ</label>
                <input type="text" name="phone" required placeholder="08XXXXXXXX"
                       class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition transform hover:-translate-y-0.5">
                ตรวจสอบสถานะสินค้า
            </button>
        </form>
    </div>

    <div class="mt-8 text-center text-sm text-gray-400">
        พบปัญหาในการค้นหา? <a href="#" class="text-indigo-600 hover:underline">ติดต่อฝ่ายบริการลูกค้า</a>
    </div>
</div>
@endsection