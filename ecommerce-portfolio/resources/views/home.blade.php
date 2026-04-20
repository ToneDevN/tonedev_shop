@extends('layouts.simple')

@section('content')

{{-- Banner Section --}}
<section class="relative w-full max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8" x-data="bannerSlider()">
    <div class="relative w-full overflow-hidden rounded-2xl shadow-xl aspect-[21/9] sm:aspect-[3/1] group">
        
        {{-- Images Container --}}
        <div class="flex transition-transform duration-500 ease-out h-full" 
             :style="`transform: translateX(-${current * 100}%)`">
            <img src="{{ asset('images/banner1.png') }}" loading="lazy" alt="แบนเนอร์โปรโมชั่น 1" class="w-full h-full object-cover shrink-0">
            <img src="{{ asset('images/banner2.png') }}" loading="lazy" alt="แบนเนอร์โปรโมชั่น 2" class="w-full h-full object-cover shrink-0">
            <img src="{{ asset('images/banner3.png') }}" loading="lazy" alt="แบนเนอร์โปรโมชั่น 3" class="w-full h-full object-cover shrink-0">
            <img src="{{ asset('images/banner4.png') }}" loading="lazy" alt="แบนเนอร์โปรโมชั่น 4" class="w-full h-full object-cover shrink-0">
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

{{-- Category Section  --}}
<section class="bg-gray-50/50 py-6 sm:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-end justify-between mb-10">
            <div class="space-y-1">
                <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                    เลือกตามหมวดหมู่
                </h2>
                <p class="text-sm text-gray-500">
                    ค้นหาสิ่งที่คุณต้องการได้รวดเร็วยิ่งขึ้น
                </p>
            </div>
            <a href="#" class="hidden sm:flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
                ดูทั้งหมด 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="w-full table-fixed border-collapse border border-gray-500 min-w-[1200px]">
                <tbody>
                    @php
                        // แบ่งข้อมูลเป็นแถวละ 8 ช่อง
                        $chunks = $categories->take(16)->chunk(8);
                    @endphp

                    @foreach($chunks as $row)
                        <tr>
                            @foreach($row as $category)
                                <th class="w-32 p-0 border border-gray-300 hover:bg-gray-50 transition-all duration-300 group cursor-pointer">
                                    <a href="#" class="flex flex-col items-center p-2 h-full">
                                        
                                        <div class="relative w-24 h-24 mb-4 transition-transform duration-500 group-hover:scale-110">
                                            <div class="absolute inset-0 bg-indigo-100 rounded-full scale-0 group-hover:scale-100 transition-transform duration-500 opacity-50"></div>
                                            
                                            <div class="relative w-full h-full rounded-lg overflow-hidden bg-gray-50 border border-gray-100 shadow-sm group-hover:border-indigo-200">
                                                @if($category->image)
                                                    <img src="{{ $category->image }}" class="w-full h-full object-cover">
                                                @else
                                                    <img src="https://picsum.photos/seed/cat-{{ $category->id }}/200/200" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <span class="text-xs sm:text-sm font-bold text-gray-800 text-center line-clamp-1 group-hover:text-indigo-600">
                                            {{ $category->name }}
                                        </span>
                                        
                                        <p class="mt-1 text-[10px] text-gray-400 font-medium tracking-tighter opacity-0 group-hover:opacity-100 transition-opacity">
                                            SHOP NOW
                                        </p>
                                    </a>
                                </th>
                            @endforeach

                            {{-- กรณีข้อมูลในแถวสุดท้ายมีไม่ถึง 8 ช่อง ให้เติมช่องว่างจนครบ --}}
                            @if($row->count() < 8)
                                @for($i = 0; $i < (8 - $row->count()); $i++)
                                    <td class="w-[12.5%] border border-gray-100 bg-gray-50/30"></td>
                                @endfor
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
