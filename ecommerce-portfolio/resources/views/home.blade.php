@extends('layouts.simple')

@section('content')

{{-- Banner Section --}}
<section class="relative w-full max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8" x-data="bannerSlider()">
    <div class="relative w-full overflow-hidden rounded-2xl shadow-xl aspect-[21/9] sm:aspect-[3/1] group">
        
        {{-- Images Container --}}
        <div class="flex transition-transform duration-500 ease-out h-full" 
             :style="`transform: translateX(-${current * 100}%)`">
            <img src="{{ asset('images/banner1.png') }}" alt="แบนเนอร์โปรโมชั่น 1" class="w-full h-full object-cover shrink-0">
            <img src="{{ asset('images/banner2.png') }}" alt="แบนเนอร์โปรโมชั่น 2" class="w-full h-full object-cover shrink-0">
            <img src="{{ asset('images/banner3.png') }}" alt="แบนเนอร์โปรโมชั่น 3" class="w-full h-full object-cover shrink-0">
            <img src="{{ asset('images/banner4.png') }}" alt="แบนเนอร์โปรโมชั่น 4" class="w-full h-full object-cover shrink-0">
        </div>

        {{-- Prev Button --}}
        <button @click="prev()" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white p-1.5 sm:p-2 rounded-full text-gray-800 transition shadow-md opacity-0 group-hover:opacity-100">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>

        {{-- Next Button --}}
        <button @click="next()" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white p-1.5 sm:p-2 rounded-full text-gray-800 transition shadow-md opacity-0 group-hover:opacity-100">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-3 sm:bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
            <template x-for="(item, index) in total" :key="index">
                <button @click="current = index" :class="{'bg-white w-4': current === index, 'bg-white/50 w-2': current !== index}" class="h-2 rounded-full transition-all duration-300"></button>
            </template>
        </div>
    </div>
</section>

{{-- Alpine.js Logic for Slider --}}
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('bannerSlider', () => ({
            current: 0,
            total: 4,
            init() {
                setInterval(() => {
                    this.next();
                }, 5000);
            },
            next() {
                this.current = (this.current + 1) % this.total;
            },
            prev() {
                this.current = (this.current - 1 + this.total) % this.total;
            }
        }));
    });
</script>
@endpush

{{-- Filter Bar --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <form action="{{ route('home') }}" method="GET" class="flex flex-wrap items-center gap-3">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        {{-- Category filter --}}
        <select name="category" onchange="this.form.submit()"
            class="px-4 py-2 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white">
            <option value="">ทุกหมวดหมู่</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        {{-- Price range --}}
        <div class="flex items-center gap-2">
            <input type="number" name="min_price" placeholder="ราคาต่ำสุด"
                value="{{ request('min_price') }}"
                class="w-28 px-4 py-2 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <span class="text-gray-400 text-sm">–</span>
            <input type="number" name="max_price" placeholder="ราคาสูงสุด"
                value="{{ request('max_price') }}"
                class="w-28 px-4 py-2 rounded-xl border border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition shadow-sm shadow-indigo-200">
                กรอง
            </button>
        </div>

        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
            <a href="{{ route('home') }}" class="text-sm text-rose-500 hover:text-rose-700 font-medium flex items-center gap-1 ml-2">
                ล้างตัวกรอง
            </a>
        @endif
    </form>
</section>

{{-- Products Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                @if(request('search'))
                    ผลการค้นหา: "{{ request('search') }}"
                @else
                    สินค้ามาใหม่
                @endif
            </h2>
            <p class="text-gray-500 text-sm mt-1">อัปเดตชุดใหม่ล่าสุด รับประกันคุณภาพทุกชิ้น</p>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
        @foreach($products as $product)
        <a href="{{ route('products.show', $product) }}" class="group block">
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full flex flex-col">

                {{-- Image --}}
                <div class="relative aspect-square bg-gray-50 overflow-hidden">
                    @if($product->coverImage)
                        <img
                            src="{{ $product->coverImage->image_path }}"
                            alt="{{ $product->name }}"
                            loading="lazy"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-gray-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-3 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm leading-snug line-clamp-2 group-hover:text-indigo-600 transition-colors">
                            {{ $product->name }}
                        </h3>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-lg font-extrabold text-indigo-600">@currency($product->price)</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    @if($products->isEmpty())
    <div class="text-center py-24 text-gray-500 bg-white rounded-3xl border border-dashed border-gray-200">
        <p class="text-lg font-medium">ไม่พบสินค้าที่ตรงกับการค้นหา</p>
        <a href="{{ route('home') }}" class="text-indigo-600 mt-2 inline-block hover:underline">ดูสินค้าทั้งหมด</a>
    </div>
    @endif

    @if($products->hasPages())
    <div class="mt-12">
        {{ $products->links() }}
    </div>
    @endif

</section>
@endsection
