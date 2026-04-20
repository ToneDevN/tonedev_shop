@extends('layouts.simple')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900">ประวัติการสั่งซื้อ</h1>
        <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">← ช้อปต่อ</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-gray-500 font-medium">ยังไม่มีรายการสั่งซื้อ</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                    <div>
                        <span class="font-mono text-indigo-600 font-bold text-sm">{{ $order->id }}</span>
                        <span class="ml-3 text-gray-400 text-xs">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span @class([
                            'px-3 py-1 rounded-full text-xs font-semibold',
                            'bg-yellow-100 text-yellow-700' => $order->status === 'pending',
                            'bg-blue-100 text-blue-700'    => $order->status === 'paid',
                            'bg-purple-100 text-purple-700'=> $order->status === 'shipped',
                            'bg-green-100 text-green-700'  => $order->status === 'completed',
                            'bg-red-100 text-red-700'      => $order->status === 'cancelled',
                        ])>{{ strtoupper($order->status) }}</span>
                        <span class="font-bold text-gray-900">@currency($order->total_amount)</span>
                    </div>
                </div>
                <div class="px-6 py-4 flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        จัดส่งถึง: {{ Str::limit($order->shipping_address, 60) }}
                    </p>
                    <a href="{{ route('member.orders.show', $order) }}"
                        class="text-sm text-indigo-600 hover:text-indigo-800 font-medium whitespace-nowrap ml-4">
                        ดูรายละเอียด →
                    </a>
                </div>

                {{-- Slip upload for pending orders --}}
                @if($order->status === 'pending' && $order->payment?->isPending())
                <div class="px-6 pb-4">
                    <form action="{{ route('member.orders.slip.upload', $order) }}" method="POST" enctype="multipart/form-data"
                        class="flex items-center gap-3 bg-yellow-50 p-3 rounded-xl border border-yellow-100">
                        @csrf
                        <input type="file" name="slip" accept="image/*"
                            class="text-xs text-gray-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-indigo-50 file:text-indigo-600">
                        <button type="submit" class="shrink-0 bg-indigo-600 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            อัปโหลดสลิป
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
