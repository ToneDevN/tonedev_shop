@extends('layouts.simple')

@section('content')

<div class="min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex gap-5 items-start">

            {{-- ─── Filter Sidebar ──────────────────────────────────────────── --}}
            <aside class="hidden md:flex flex-col gap-3 w-52 shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <h3 class="font-bold text-gray-800 tracking-tight">ตัวกรองสินค้า</h3>
                    </div>

                    {{-- Category Filter --}}
                    <div class="p-4 border-b border-gray-50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">หมวดหมู่</p>
                        <ul class="space-y-2">
                            <li><label class="flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 cursor-pointer"><input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"> เสื้อผ้าแฟชั่น</label></li>
                            <li><label class="flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 cursor-pointer"><input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"> อุปกรณ์อิเล็กทรอนิกส์</label></li>
                            <li><label class="flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 cursor-pointer"><input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"> สุขภาพและความงาม</label></li>
                            <li><label class="flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 cursor-pointer"><input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"> ของใช้ในบ้าน</label></li>
                        </ul>
                    </div>

                    {{-- Price Filter --}}
                    <div class="p-4 border-b border-gray-50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">ช่วงราคา (บาท)</p>
                        <div class="flex items-center gap-2">
                            <input type="number" placeholder="ต่ำสุด" class="w-full px-2 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500">
                            <span class="text-gray-400">-</span>
                            <input type="number" placeholder="สูงสุด" class="w-full px-2 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        </div>
                        <button class="mt-3 w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-sm font-semibold py-1.5 rounded-lg transition-colors">นำไปใช้</button>
                    </div>

                    {{-- Rating Filter --}}
                    <div class="p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">คะแนน</p>
                        <ul class="space-y-2.5">
                            <li>
                                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 cursor-pointer">
                                    <input type="radio" name="rating" class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <div class="flex text-yellow-400 gap-0.5">
                                        @for($i=0; $i<5; $i++) <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center gap-2 text-sm text-gray-600 hover:text-indigo-600 cursor-pointer">
                                    <input type="radio" name="rating" class="text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <div class="flex text-yellow-400 gap-0.5">
                                        @for($i=0; $i<4; $i++) <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                                        <svg class="w-3.5 h-3.5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    </div>
                                    <span class="text-xs text-gray-500">ขึ้นไป</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>

            {{-- ─── Main Content ─────────────────────────────────────────── --}}
            <div class="flex-1 min-w-0 space-y-4 w-full mb-8">
                
                <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900">
                            ผลการค้นหาสำหรับ <span class="text-indigo-600">"{{ $query }}"</span>
                        </h2>
                        <p class="text-gray-500 text-sm mt-0.5">พบสินค้าทั้งหมด {{ $products->total() }} รายการ</p>
                    </div>
                    
                    {{-- Sort Dropdown --}}
                    <div class="hidden sm:flex items-center gap-3 shrink-0">
                        <span class="text-sm font-medium text-gray-600 whitespace-nowrap">เรียงโดย</span>
                        <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-auto min-w-[140px] p-2 pr-8">
                            <option>ใหม่ล่าสุด</option>
                            <option>ขายดีที่สุด</option>
                            <option>ราคา: ต่ำ - สูง</option>
                            <option>ราคา: สูง - ต่ำ</option>
                        </select>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    @foreach($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="group block">
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">

                            {{-- Image --}}
                            <div class="relative h-48 bg-gray-50 overflow-hidden">
                                @if($product->coverImage)
                                    <img
                                        src="{{ $product->coverImage->image_path }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    >
                                @else
                                    <div class="flex flex-col items-center justify-center h-full text-gray-300 gap-2">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs">ไม่มีรูปภาพ</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="p-3 bg-white">
                                <h3 class="font-medium text-gray-900 text-sm leading-snug line-clamp-2 group-hover:text-indigo-600 transition-colors h-10">
                                    {{ $product->name }}
                                </h3>

                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-lg font-bold text-indigo-600">฿{{ number_format($product->price, 0) }}</span>
                                </div>
                                <div class="mt-1.5 flex items-center justify-between">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="text-xs text-gray-600 font-medium">5.0</span>
                                    </div>
                                    <span class="text-[11px] text-gray-400 font-medium">ขายแล้ว 12 ชิ้น</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Empty State --}}
                @if($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-xl border border-gray-100 shadow-sm mt-4">
                    <div class="w-20 h-20 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <p class="text-lg font-bold text-gray-900">ไม่พบสินค้าที่ตรงกับการค้นหา</p>
                    <p class="text-sm text-gray-500 mt-1">ลองล้างตัวกรอง หรือค้นหาด้วยคำอื่นดูอีกครั้ง</p>
                </div>
                @endif

                {{-- Pagination --}}
                @if($products->hasPages())
                <div class="mt-10 w-full pt-6 border-t border-gray-200/60">
                    {{ $products->links() }}
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
