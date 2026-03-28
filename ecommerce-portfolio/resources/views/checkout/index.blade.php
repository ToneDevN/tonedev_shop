@extends('layouts.simple')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-10 text-gray-800">ชำระเงิน</h1>

    <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        @csrf @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        
        <div class="lg:col-span-7 space-y-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold mb-6 flex items-center">
                    <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">1</span>
                    ข้อมูลผู้รับและที่อยู่จัดส่ง
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">ชื่อ-นามสกุล</label>
                        <input type="text" name="customer_name" required value="{{ old('customer_name') }}"
                               class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">เบอร์โทรศัพท์</label>
                        <input type="text" name="phone" required value="{{ old('phone') }}"
                               class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">ที่อยู่สำหรับการจัดส่ง</label>
                        <textarea name="address" rows="4" required
                                  class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold mb-6 flex items-center">
                    <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">2</span>
                    วิธีการชำระเงิน
                </h2>
                <div class="p-4 border-2 border-indigo-600 bg-indigo-50 rounded-xl flex items-center">
                    <input type="radio" checked class="text-indigo-600 focus:ring-indigo-500">
                    <div class="ml-4">
                        <p class="font-bold text-indigo-900">โอนเงินผ่านบัญชีธนาคาร (Manual Transfer)</p>
                        <p class="text-sm text-indigo-700">แจ้งชำระเงินกับแอดมินหลังทำรายการสำเร็จ</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5">
            <div class="bg-gray-50 p-8 rounded-2xl border border-gray-200 sticky top-24">
                <h2 class="text-xl font-bold mb-6 text-gray-800">สรุปยอดสั่งซื้อ</h2>
                
                <div class="space-y-4 mb-8 max-h-64 overflow-y-auto pr-2">
                    @foreach(session('cart') as $id => $details)
                    <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <img src="{{ $details['image'] }}" class="w-12 h-12 object-cover rounded mr-3">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $details['name'] }}</p>
                                <p class="text-xs text-gray-500">จำนวน: {{ $details['quantity'] }}</p>
                            </div>
                        </div>
                        <p class="text-sm font-bold">฿{{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="space-y-3 border-t pt-6">
                    <div class="flex justify-between text-gray-600">
                        <span>ราคารวมสินค้า</span>
                        <span>฿{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>ค่าจัดส่ง</span>
                        <span class="text-green-600 font-medium">ฟรี</span>
                    </div>
                    <div class="flex justify-between text-xl font-extrabold text-gray-900 pt-3 border-t">
                        <span>ยอดรวมทั้งสิ้น</span>
                        <span class="text-indigo-600">฿{{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <button type="submit" class="w-full mt-8 bg-indigo-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition transform hover:-translate-y-1">
                    ยืนยันการสั่งซื้อและชำระเงิน
                </button>
                <p class="text-xs text-center text-gray-400 mt-4 italic">
                    * เมื่อกดยืนยัน คุณยอมรับเงื่อนไขการให้บริการของเรา
                </p>
            </div>
        </div>
    </form>
</div>
@endsection