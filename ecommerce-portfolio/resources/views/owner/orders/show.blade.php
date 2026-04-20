@extends('layouts.simple')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('owner.orders.index') }}" class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                กลับรายการสั่งซื้อ
            </a>
            <h1 class="text-2xl font-bold text-gray-800">รายละเอียดคำสั่งซื้อ</h1>
            <p class="font-mono text-indigo-600 font-bold">{{ $order->id }}</p>
        </div>

        {{-- Status Update --}}
        <form action="{{ route('owner.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-2">
            @csrf @method('PATCH')
            <select name="status" class="rounded-xl border border-gray-200 text-sm px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                @foreach(['pending','paid','shipped','completed','cancelled'] as $status)
                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                        {{ strtoupper($status) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-600 text-white text-sm font-semibold px-4 py-2 rounded-xl hover:bg-indigo-700 transition">
                อัปเดต
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Order Items --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">รายการสินค้า</h2>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($order->items as $item)
                <div class="px-6 py-4 flex items-center gap-4">
                    @if($item->product?->coverImage)
                        <img src="{{ $item->product->coverImage->image_path }}" class="w-14 h-14 object-cover rounded-lg border border-gray-100">
                    @else
                        <div class="w-14 h-14 bg-gray-100 rounded-lg"></div>
                    @endif
                    <div class="flex-1">
                        <p class="font-medium text-gray-800 text-sm">{{ $item->product?->name ?? 'สินค้าถูกลบแล้ว' }}</p>
                        <p class="text-xs text-gray-400">จำนวน {{ $item->quantity }} × @currency($item->price)</p>
                    </div>
                    <p class="font-bold text-gray-900">@currency($item->price * $item->quantity)</p>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-between font-bold">
                <span>ยอดรวม</span>
                <span class="text-indigo-600">@currency($order->total_amount)</span>
            </div>
        </div>

        {{-- Customer + Payment info --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">ข้อมูลลูกค้า</h2>
                <p class="text-sm font-medium text-gray-700">{{ $order->customer_name }}</p>
                <p class="text-sm text-gray-500">{{ $order->phone }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $order->shipping_address }}</p>
            </div>

            @if($order->payment)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">การชำระเงิน</h2>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-500">วิธีการ</span>
                    <span class="font-medium">{{ strtoupper($order->payment->payment_method) }}</span>
                </div>
                <div class="flex justify-between text-sm mb-3">
                    <span class="text-gray-500">สถานะ</span>
                    <span @class([
                        'font-semibold text-xs px-2 py-1 rounded-full',
                        'bg-yellow-100 text-yellow-700' => $order->payment->isPending(),
                        'bg-green-100 text-green-700'   => $order->payment->isPaid(),
                    ])>{{ strtoupper($order->payment->status) }}</span>
                </div>
                @if($order->payment->slip_path)
                    <img src="{{ $order->payment->slip_path }}" class="w-full rounded-xl border border-gray-100" alt="slip">
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
