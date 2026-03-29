@extends('layouts.simple')

@section('content')

{{-- Hero Section --}}
<section class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <span class="inline-block bg-white/20 backdrop-blur text-white text-sm font-medium px-4 py-1.5 rounded-full mb-5 border border-white/30">
            ✨ สินค้าใหม่มาถึงแล้ว
        </span>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-5">
            ช้อปสินค้าคุณภาพ<br>
            <span class="text-yellow-300">ราคาดีที่สุด</span>
        </h1>
        <p class="text-white/80 text-lg max-w-xl mx-auto mb-8">
            ค้นพบสินค้าหลากหลายที่คัดสรรมาเพื่อคุณ พร้อมจัดส่งรวดเร็ว
        </p>
    </div>
</section>

{{-- Products Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">สินค้ามาใหม่</h2>
            <p class="text-gray-400 text-sm mt-1">อัปเดตทุกวัน รับประกันสินค้าแท้</p>
        </div>
        <span class="text-sm text-indigo-600 font-medium bg-indigo-50 px-3 py-1.5 rounded-full">
            {{ $products->total() }} รายการ
        </span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <a href="{{ route('products.show', $product) }}" class="group block">
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                {{-- Image --}}
                <div class="relative h-52 bg-gray-50 overflow-hidden">
                    @if($product->coverImage)
                        <img
                            src="{{ $product->coverImage->image_path }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                            decoding="async"
                            width="400"
                            height="208"
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

                    {{-- Category Badge --}}
                    @if($product->categories->isNotEmpty())
                        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur text-indigo-600 text-xs font-semibold px-2.5 py-1 rounded-full shadow-sm border border-indigo-100">
                            {{ $product->categories->first()->name ?? 'ทั่วไป' }}
                        </span>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 truncate text-sm leading-snug group-hover:text-indigo-600 transition-colors">
                        {{ $product->name }}
                    </h3>
                    <p class="text-gray-400 text-xs mt-1 truncate">
                        {{ Str::limit($product->description, 55) }}
                    </p>

                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <span class="text-xl font-extrabold text-gray-900">฿{{ number_format($product->price, 0) }}</span>
                            <span class="text-gray-400 text-xs">.00</span>
                        </div>
                        <button
                            class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-medium px-3 py-2 rounded-xl transition-all duration-150"
                            onclick="event.preventDefault(); event.stopPropagation();"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            ใส่ตะกร้า
                        </button>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Empty State --}}
    @if($products->isEmpty())
    <div class="text-center py-24 text-gray-400">
        <svg class="w-16 h-16 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <p class="text-lg font-medium">ยังไม่มีสินค้าในขณะนี้</p>
        <p class="text-sm mt-1">กรุณากลับมาใหม่ในภายหลัง</p>
    </div>
    @endif

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="mt-10 flex justify-center">
        {{ $products->links() }}
    </div>
    @endif

</section>
@endsection
