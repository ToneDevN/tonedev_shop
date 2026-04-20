@extends('layouts.simple')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">

    <a href="{{ route('member.orders.index') }}" class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        กลับไปประวัติสั่งซื้อ
    </a>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h1 class="font-mono text-indigo-600 font-bold text-lg">{{ $order->id }}</h1>
                <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <span @class([
                'px-3 py-1 rounded-full text-xs font-semibold',
                'bg-yellow-100 text-yellow-700' => $order->status === 'pending',
                'bg-blue-100 text-blue-700'    => $order->status === 'paid',
                'bg-purple-100 text-purple-700'=> $order->status === 'shipped',
                'bg-green-100 text-green-700'  => $order->status === 'completed',
                'bg-red-100 text-red-700'      => $order->status === 'cancelled',
            ])>{{ strtoupper($order->status) }}</span>
        </div>

        {{-- Shipping info --}}
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">ที่อยู่จัดส่ง</h2>
            <p class="font-semibold text-gray-800">{{ $order->customer_name }}</p>
            <p class="text-sm text-gray-600">{{ $order->phone }}</p>
            <p class="text-sm text-gray-600 mt-1">{{ $order->shipping_address }}</p>
        </div>

        {{-- Order items --}}
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">รายการสินค้า</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4">
                    @if($item->product?->coverImage)
                        <img src="{{ $item->product->coverImage->image_path }}" class="w-14 h-14 object-cover rounded-lg border border-gray-100">
                    @else
                        <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 text-sm">{{ $item->product?->name ?? 'สินค้าถูกลบแล้ว' }}</p>
                        <p class="text-xs text-gray-400">จำนวน {{ $item->quantity }} × @currency($item->price)</p>
                    </div>
                    <p class="font-bold text-gray-900 text-sm">@currency($item->price * $item->quantity)</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Summary --}}
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>ราคารวมสินค้า</span>
                <span>@currency($order->total_amount)</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>ค่าจัดส่ง</span>
                <span class="text-green-600">ฟรี</span>
            </div>
            <div class="flex justify-between font-bold text-gray-900 text-base pt-2 border-t border-gray-200">
                <span>ยอดรวมทั้งสิ้น</span>
                <span class="text-indigo-600">@currency($order->total_amount)</span>
            </div>
        </div>

        {{-- Payment --}}
        @if($order->payment)
        <div class="px-6 py-5">
            <h2 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">ชำระเงิน</h2>
            <div class="flex items-center justify-between text-sm">
                <div>
                    <span class="text-gray-600">วิธีการชำระเงิน: </span>
                    <span class="font-medium text-gray-800">โอนเงิน (Transfer)</span>
                </div>
                <span @class([
                    'px-2.5 py-1 rounded-full text-xs font-semibold',
                    'bg-yellow-100 text-yellow-700' => $order->payment->isPending(),
                    'bg-green-100 text-green-700'   => $order->payment->isPaid(),
                ])>{{ strtoupper($order->payment->status) }}</span>
            </div>

            @if($order->payment->slip_path)
                <div class="mt-3">
                    <p class="text-xs text-gray-500 mb-1">สลิปการชำระเงิน:</p>
                    <img src="{{ $order->payment->slip_path }}" class="max-w-xs rounded-xl border border-gray-100 shadow-sm" alt="slip">
                </div>
            @elseif($order->payment->isPending())
                <form action="{{ route('member.orders.slip.upload', $order) }}" method="POST" enctype="multipart/form-data"
                    class="mt-4 flex items-center gap-3 bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                    @csrf
                    <div class="flex-1">
                        <p class="text-xs font-medium text-yellow-800 mb-2">อัปโหลดหลักฐานการชำระเงิน</p>
                        <input type="file" name="slip" accept="image/*"
                            class="text-xs text-gray-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-white file:text-indigo-600 file:border file:border-indigo-200">
                    </div>
                    <button type="submit" class="shrink-0 bg-indigo-600 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        อัปโหลด
                    </button>
                </form>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
