@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'แดชบอร์ดผู้ดูแลระบบ')
@section('page-subtitle', 'ภาพรวมการดำเนินงานและสถิติระบบทั้งหมด')

@section('content')
@php
    $statCards = [
        [
            'label'   => 'รายได้รวมทั้งหมด',
            'value'   => '฿' . number_format($totalRevenue, 0),
            'sub'     => 'เพิ่มขึ้น 12% จากเดือนที่แล้ว',
            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'color'   => 'rose',
        ],
        [
            'label'   => 'คำสั่งซื้อที่รอการจัดการ',
            'value'   => number_format($pendingOrders),
            'sub'     => 'จากทั้งหมด ' . number_format($totalOrders) . ' รายการ',
            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>',
            'color'   => 'amber',
        ],
        [
            'label'   => 'สินค้าที่วางขายอยู่',
            'value'   => number_format($activeProducts),
            'sub'     => 'สินค้าทั้งหมด ' . number_format($totalProducts) . ' SKU',
            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
            'color'   => 'indigo',
        ],
        [
            'label'   => 'จำนวนสมาชิก',
            'value'   => number_format($totalUsers),
            'sub'     => 'ผู้ใช้งานใหม่ 48 รายวันนี้',
            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
            'color'   => 'emerald',
        ],
    ];
@endphp

<div class="space-y-8 pb-10">

    {{-- ─── Admin Welcome Hero ────────────────────────────────── --}}
    <div class="relative overflow-hidden rounded-3xl bg-white border border-slate-200 shadow-sm p-6 sm:p-10">
        {{-- Decorative Gradient --}}
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-rose-50/50 to-transparent pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 border border-rose-100 text-rose-600 text-xs font-bold uppercase tracking-wider mb-4">
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                    Central Control
                </div>
                <h2 class="text-slate-900 text-3xl sm:text-4xl font-black tracking-tight mb-2">
                    จัดการระบบ, {{ $user->first_name ?? 'Admin' }}
                </h2>
                <p class="text-slate-500 text-lg max-w-2xl font-medium">
                    คุณกำลังใช้งานในฐานะ <span class="text-rose-600 font-bold underline decoration-rose-200 underline-offset-4">Super Admin</span> 
                    ตรวจสอบข้อมูลร้านค้าและผู้ใช้งานทั้งหมดได้ที่นี่
                </p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    จัดการผู้ใช้
                </a>
                <button class="p-3 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ─── Stat Bento Grid ────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($statCards as $card)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-2xl bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 transition-colors group-hover:bg-{{ $card['color'] }}-600 group-hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $card['icon'] !!}</svg>
                </div>
                <span class="text-{{ $card['color'] }}-600 bg-{{ $card['color'] }}-50 text-[10px] font-black px-2 py-1 rounded-lg uppercase tracking-tighter">Stats</span>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">{{ $card['label'] }}</p>
            <h3 class="text-slate-900 text-2xl font-black mt-1">{{ $card['value'] }}</h3>
            <p class="text-slate-400 text-[11px] font-medium mt-2 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                {{ $card['sub'] }}
            </p>
        </div>
        @endforeach
    </div>

    {{-- ─── Main Content ───────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-6 gap-8">
        
        {{-- Recent Activity Table --}}
        <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-8 py-6 border-b border-slate-50">
                <h3 class="text-slate-900 font-black text-xl">คำสั่งซื้อล่าสุด</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-rose-600 hover:underline">จัดการทั้งหมด</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">ออเดอร์</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">ชื่อลูกค้า</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">ยอดรวม</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-8 py-5">
                                <span class="font-black text-slate-900 group-hover:text-rose-600 transition-colors">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-700">{{ $order->customer_name ?? 'ลูกค้าทั่วไป' }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="text-sm font-black text-slate-900 font-mono">฿{{ number_format($order->total_amount, 0) }}</span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                @php
                                    $statusPill = [
                                        'pending'    => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'processing' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                        'completed'  => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'cancelled'  => 'bg-rose-100 text-rose-700 border-rose-200',
                                    ][$order->status] ?? 'bg-slate-100 text-slate-700';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black border uppercase {{ $statusPill }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 font-bold italic">ไม่พบข้อมูลคำสั่งซื้อในขณะนี้</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sidebar: Distribution --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Role Breakdown --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
                <h3 class="text-slate-900 font-black text-xl mb-6">สัดส่วนผู้ใช้งาน</h3>
                <div class="space-y-6">
                    @php
                        $roleConfig = [
                            'admin'  => ['color' => 'bg-rose-500',   'label' => 'Super Admin'],
                            'owner'  => ['color' => 'bg-indigo-500', 'label' => 'Shop Owner'],
                            'member' => ['color' => 'bg-emerald-500', 'label' => 'Verified Member'],
                        ];
                    @endphp
                    @foreach($usersByRole as $role => $count)
                        @php 
                            $pct = $totalUsers > 0 ? ($count / $totalUsers) * 100 : 0;
                            $cfg = $roleConfig[$role] ?? ['color' => 'bg-slate-400', 'label' => $role];
                        @endphp
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-xs font-black text-slate-700 uppercase tracking-tighter">{{ $cfg['label'] }}</span>
                                <span class="text-xs font-black text-slate-900">{{ number_format($count) }} <span class="text-slate-300 ml-1">{{ round($pct) }}%</span></span>
                            </div>
                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="{{ $cfg['color'] }} h-full rounded-full transition-all duration-1000" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Quick Links Grid --}}
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.categories.index') }}" class="flex flex-col items-center justify-center p-6 bg-rose-50 rounded-3xl border border-rose-100 text-rose-600 hover:bg-rose-600 hover:text-white transition-all group">
                    <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    <span class="text-xs font-black uppercase">หมวดหมู่</span>
                </a>
                <a href="{{ route('home') }}" class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-3xl border border-slate-100 text-slate-600 hover:bg-slate-900 hover:text-white transition-all group">
                    <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span class="text-xs font-black uppercase">หน้าร้าน</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection