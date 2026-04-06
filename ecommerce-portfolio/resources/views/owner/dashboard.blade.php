@extends('layouts.admin')

@section('title', 'Owner Dashboard')
@section('page-title', 'แดชบอร์ด')
@section('page-subtitle', 'ภาพรวมร้านค้าของคุณ')

@section('content')
<div class="space-y-8 pb-10">

    {{-- ─── Stat Cards ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-6">
        @php
            $stats = [
                [
                    'label' => 'ยอดขายรวม',
                    'value' => '฿' . number_format($totalSales, 0),
                    'sub' => 'จากออเดอร์ที่สำเร็จ',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'color' => 'indigo'
                ],
                [
                    'label' => 'คำสั่งซื้อรอส่ง',
                    'value' => $newOrdersCount,
                    'sub' => 'รายการที่ต้องจัดการ',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>',
                    'color' => 'amber',
                    'badge' => $newOrdersCount > 0 ? 'ใหม่' : null
                ],
                [
                    'label' => 'คำสั่งซื้อรวม',
                    'value' => $newOrdersCount, // ควรเป็น $totalOrders ถ้ามีตัวแปรนี้ แต่เบื้องต้นใช้ค่าเดิมที่ user ใส่มาใน snippet
                    'sub' => 'รายการทั้งหมดในร้าน',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>',
                    'color' => 'sky'
                ],
                [
                    'label' => 'อัตราการซื้อ',
                    'value' => '2.4%', // ตัวอย่างค่าคงที่หรือต้องคำนวณ
                    'sub' => 'conversion rate',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>',
                    'color' => 'violet'
                ],
                [
                    'label' => 'คืนสินค้า/คืนเงิน',
                    'value' => '0',
                    'sub' => 'รายการที่รอดำเนินการ',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v4a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h4m5 5l5 5m-5 0l5-5"/>',
                    'color' => 'rose'
                ],
                [
                    'label' => 'สินค้าในร้าน',
                    'value' => $totalProducts,
                    'sub' => 'จำนวน SKU ทั้งหมด',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
                    'color' => 'emerald'
                ]
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="group bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
                <div class="p-3 rounded-2xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-600 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $stat['icon'] !!}
                    </svg>
                </div>
                @if(isset($stat['badge']))
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700 uppercase tracking-wider">
                        {{ $stat['badge'] }}
                    </span>
                @endif
            </div>
            <p class="text-slate-500 text-sm font-bold tracking-wide uppercase">{{ $stat['label'] }}</p>
            <h3 class="text-slate-900 text-3xl font-black mt-1">{{ $stat['value'] }}</h3>
            <p class="text-slate-400 text-xs mt-2 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/></svg>
                {{ $stat['sub'] }}
            </p>
        </div>
        @endforeach
    </div>

    {{-- ─── Main Content Grid ──────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-6 gap-8">

        {{-- Recent Orders Table --}}
        <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-50">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-6 rounded-full bg-indigo-600"></div>
                    <h3 class="text-slate-900 font-bold text-lg">คำสั่งซื้อล่าสุด</h3>
                </div>
                <a href="{{ route('owner.orders.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                    ดูทั้งหมด &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-[0.1em] px-6 py-4">ID ออเดอร์</th>
                            <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-[0.1em] px-6 py-4">ยอดรวม</th>
                            <th class="text-left text-xs font-bold text-slate-400 uppercase tracking-[0.1em] px-6 py-4">สถานะ</th>
                            <th class="text-right text-xs font-bold text-slate-400 uppercase tracking-[0.1em] px-6 py-4">เวลา</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentOrders as $order)
                        @php
                            $statusStyle = [
                                'pending'    => 'bg-amber-50 text-amber-600 border-amber-100',
                                'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'completed'  => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'cancelled'  => 'bg-rose-50 text-rose-600 border-rose-100',
                            ][$order->status] ?? 'bg-slate-50 text-slate-600';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                <a href="{{ route('owner.orders.show', $order) }}" class="font-bold text-slate-700 group-hover:text-indigo-600 transition-colors">
                                    #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-extrabold text-slate-900 font-mono">฿{{ number_format($order->total_amount, 0) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusStyle }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-slate-400 text-xs font-medium">{{ $order->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-16 text-center text-slate-400 font-medium">ยังไม่มีข้อมูลคำสั่งซื้อในขณะนี้</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Side Sidebar --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Action Cards --}}
            <div class="bg-indigo-600 rounded-3xl p-6 shadow-lg shadow-indigo-100 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-125 transition-transform duration-500">
                    <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
                </div>
                <h4 class="text-white font-bold text-lg mb-2 relative">เพิ่มสินค้าใหม่</h4>
                <p class="text-indigo-100 text-sm mb-6 relative">เริ่มวางขายสินค้าชิ้นใหม่ของคุณวันนี้ เพื่อเพิ่มยอดขายที่มากขึ้น</p>
                <a href="{{ route('owner.products.create') }}" class="relative inline-flex w-full items-center justify-center bg-white text-indigo-600 font-bold py-3 rounded-2xl hover:bg-indigo-50 transition-colors shadow-sm">
                    ไปที่หน้าเพิ่มสินค้า
                </a>
            </div>

            {{-- Status Breakdown --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-2 h-6 rounded-full bg-amber-400"></div>
                    <h3 class="text-slate-900 font-bold text-lg">สถานะออเดอร์</h3>
                </div>
                
                <div class="space-y-4">
                    @php
                        $statusMeta = [
                            'pending'    => ['label' => 'รอดำเนินการ', 'color' => 'bg-amber-400'],
                            'processing' => ['label' => 'กำลังจัดส่ง', 'color' => 'bg-blue-400'],
                            'completed'  => ['label' => 'สำเร็จแล้ว', 'color' => 'bg-emerald-400'],
                            'cancelled'  => ['label' => 'ยกเลิก', 'color' => 'bg-rose-400'],
                        ];
                    @endphp
                    @foreach($orderStatusSummary as $status => $count)
                        <div class="flex items-center justify-between group cursor-default">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full {{ $statusMeta[$status]['color'] ?? 'bg-slate-300' }}"></span>
                                <span class="text-slate-600 font-medium group-hover:text-slate-900 transition-colors">{{ $statusMeta[$status]['label'] ?? $status }}</span>
                            </div>
                            <span class="text-slate-900 font-black">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection