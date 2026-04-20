@extends('layouts.simple')

@section('content')
    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">ตะกร้าสินค้าของคุณ</h1>
        @if(session('cart'))
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4">สินค้า</th>
                            <th class="p-4">ราคา</th>
                            <th class="p-4">จำนวน</th>
                            <th class="p-4">รวม</th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('cart') as $id => $details)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 flex items-center">
                                <img src="{{ $details['image'] }}" class="w-16 h-16 object-cover rounded mr-4">
                                <span class="font-medium">{{ $details['name'] ?? 'ไม่มีชื่อสินค้า' }}</span>
                            </td>
                            <td class="p-4">@currency($details['price'])</td>
                            <td class="p-4">{{ $details['quantity'] }}</td>
                            <td class="p-4">@currency($details['price'] * $details['quantity'])</td>
                            <td class="p-4">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700">ลบ</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="p-6 bg-gray-50 flex justify-between items-center">
                    <div class="text-2xl font-bold text-gray-800">ราคารวมทั้งหมด: @currency($total)</div>
                    <a href={{ route('checkout.index') }} class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
                        ไปหน้าชำระเงิน (Checkout) →
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-xl mb-4">ยังไม่มีสินค้าในตะกร้า</p>
                <a href="/" class="text-indigo-600 font-bold hover:underline">← กลับไปเลือกซื้อสินค้า</a>
            </div>
        @endif
    </div>
    </div>
@endsection
    