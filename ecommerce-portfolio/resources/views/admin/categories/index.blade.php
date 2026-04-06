@extends('layouts.admin')

@section('title', 'หมวดหมู่ (Admin)')
@section('page-title', 'จัดการหมวดหมู่')
@section('page-subtitle', 'ดูหมวดหมู่สินค้าทั้งหมดในระบบ')

@section('content')
<div class="space-y-6">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($categories as $category)
        <div class="bg-slate-900 border border-white/[0.06] rounded-2xl p-5 hover:border-rose-500/20 transition-all">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl bg-rose-500/15 flex items-center justify-center">
                    <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-semibold text-sm">{{ $category->name }}</p>
                    <p class="text-gray-500 text-xs">{{ $category->slug }}</p>
                </div>
            </div>
            <p class="text-rose-400 text-sm font-semibold">{{ $category->products_count }} สินค้า</p>
        </div>
        @empty
        <div class="col-span-3 py-12 text-center text-gray-500 text-sm">ไม่พบหมวดหมู่</div>
        @endforelse
    </div>

    @if($categories->hasPages())
    <div>{{ $categories->links() }}</div>
    @endif

</div>
@endsection
