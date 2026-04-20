@extends('layouts.simple')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">จัดการรายการสั่งซื้อ (Admin)</h1>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-4 font-semibold text-gray-700">เลขที่สั่งซื้อ</th>
                    <th class="p-4 font-semibold text-gray-700">ลูกค้า</th>
                    <th class="p-4 font-semibold text-gray-700">ยอดรวม</th>
                    <th class="p-4 font-semibold text-gray-700">สถานะ</th>
                    <th class="p-4 font-semibold text-gray-700">วันที่</th>
                    <th class="p-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4 font-mono text-sm text-indigo-600 font-bold">{{ $order->id }}</td>
                    <td class="p-4 text-gray-700">
                        <div class="font-medium">{{ $order->customer_name }}</div>
                        <div class="text-xs text-gray-500">{{ $order->phone }}</div>
                    </td>
                    <td class="p-4 font-bold text-gray-900">@currency($order->total_amount)</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4 text-right">
                        <a href="{{ route('owner.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">รายละเอียด</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection