@extends('layouts.admin')

@section('title', 'คำสั่งซื้อทั้งหมด (Admin)')
@section('page-title', 'จัดการคำสั่งซื้อ')
@section('page-subtitle', 'ดูและอัปเดตสถานะคำสั่งซื้อทั้งหมดในระบบ')

@section('content')
<div class="space-y-6">

    <div class="bg-slate-900 border border-white/[0.06] rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">Order #</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">ลูกค้า</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">ยอดรวม</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">สถานะ</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">วันที่</th>
                        <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">การจัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                    @forelse($orders as $order)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-3.5">
                            <span class="text-white text-sm font-mono font-medium">#{{ $order->id }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="text-white text-sm">{{ $order->customer_name ?? 'ไม่ระบุ' }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-white text-sm font-semibold">฿{{ number_format($order->total_amount, 0) }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $statusMap = [
                                    'pending'   => ['label' => 'รอดำเนินการ', 'class' => 'bg-amber-500/15 text-amber-400 ring-amber-500/20'],
                                    'processing'=> ['label' => 'กำลังจัดส่ง', 'class' => 'bg-blue-500/15 text-blue-400 ring-blue-500/20'],
                                    'completed' => ['label' => 'สำเร็จ',       'class' => 'bg-emerald-500/15 text-emerald-400 ring-emerald-500/20'],
                                    'cancelled' => ['label' => 'ยกเลิก',       'class' => 'bg-red-500/15 text-red-400 ring-red-500/20'],
                                ];
                                $s = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-500/15 text-gray-400 ring-gray-500/20'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium ring-1 {{ $s['class'] }}">{{ $s['label'] }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-gray-500 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center justify-end gap-2">
                                @csrf @method('PATCH')
                                <select name="status"
                                        class="bg-slate-800 border border-white/10 text-white text-xs rounded-lg px-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-rose-500">
                                    @foreach(['pending','processing','completed','cancelled'] as $st)
                                    <option value="{{ $st }}" @selected($order->status === $st)>{{ $st }}</option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="bg-rose-500/15 hover:bg-rose-500/25 text-rose-400 text-xs px-3 py-1.5 rounded-lg font-medium transition-colors">
                                    บันทึก
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-500 text-sm">ยังไม่มีคำสั่งซื้อ</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-5 py-4 border-t border-white/5">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
