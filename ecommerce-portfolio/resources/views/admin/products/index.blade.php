@extends('layouts.admin')

@section('title', 'สินค้าทั้งหมด (Admin)')
@section('page-title', 'จัดการสินค้า')
@section('page-subtitle', 'ดู เปิด/ปิด และลบสินค้าในระบบ')

@section('content')
<div class="space-y-6">

    <div class="bg-slate-900 border border-white/[0.06] rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">สินค้า</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">หมวดหมู่</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">ราคา</th>
                        <th class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">สถานะ</th>
                        <th class="text-right text-xs font-semibold text-gray-500 uppercase tracking-wider px-5 py-4">การจัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                    @forelse($products as $product)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->coverImage)
                                <img src="{{ $product->coverImage->image_path }}" alt="{{ $product->name }}"
                                     class="w-10 h-10 rounded-lg object-cover shrink-0 bg-slate-800">
                                @else
                                <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <p class="text-white text-sm font-medium">{{ $product->name }}</p>
                                    <p class="text-gray-500 text-xs">{{ $product->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($product->categories->take(2) as $cat)
                                <span class="text-xs bg-blue-500/10 text-blue-400 ring-1 ring-blue-500/20 px-2 py-0.5 rounded-lg">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-white text-sm font-semibold">฿{{ number_format($product->price, 0) }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium ring-1
                                         {{ $product->is_active ? 'bg-emerald-500/15 text-emerald-400 ring-emerald-500/20' : 'bg-red-500/15 text-red-400 ring-red-500/20' }}">
                                {{ $product->is_active ? 'เปิดขาย' : 'ปิดขาย' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.products.toggle', $product) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="text-xs px-3 py-1.5 rounded-lg font-medium transition-colors
                                                   {{ $product->is_active ? 'bg-amber-500/15 hover:bg-amber-500/25 text-amber-400' : 'bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-400' }}">
                                        {{ $product->is_active ? 'ปิดขาย' : 'เปิดขาย' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('ยืนยันลบสินค้า {{ $product->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500/15 hover:bg-red-500/25 text-red-400 text-xs px-3 py-1.5 rounded-lg font-medium transition-colors">
                                        ลบ
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-500 text-sm">ไม่พบสินค้า</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="px-5 py-4 border-t border-white/5">
            {{ $products->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
