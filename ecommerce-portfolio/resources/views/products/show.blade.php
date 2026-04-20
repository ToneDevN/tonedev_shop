@extends('layouts.simple')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 pt-8">

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        {{-- Product main section --}}
        <div class="md:flex">

            {{-- Image Gallery --}}
            <div class="md:w-1/2 p-6" x-data="{ activeImage: '{{ $product->coverImage?->image_path ?? '' }}' }">
                <div class="h-96 bg-gray-100 rounded-xl overflow-hidden mb-4 flex items-center justify-center">
                    @if($product->coverImage)
                        <img :src="activeImage" alt="{{ $product->name }}" class="h-full w-full object-contain">
                    @else
                        <div class="text-gray-400">ไม่มีรูปภาพ</div>
                    @endif
                </div>

                @php
                    $gallery = collect();
                    if (is_array($product->images)) {
                        foreach($product->images as $img) { $gallery->push($img); }
                    }
                    foreach($product->product_images as $img) {
                        $gallery->push($img->image_path);
                    }
                    $gallery = $gallery->filter()->unique()->values();
                @endphp

                @if($gallery->count() > 0)
                <div class="flex gap-2 overflow-x-auto pb-1">
                    @foreach($gallery as $imgUrl)
                    <button
                        @click="activeImage = '{{ $imgUrl }}'"
                        class="w-20 h-20 shrink-0 border-2 rounded-lg overflow-hidden hover:border-indigo-500 transition focus:outline-none"
                        :class="activeImage === '{{ $imgUrl }}' ? 'border-indigo-500' : 'border-gray-200'"
                    >
                        <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="md:w-1/2 p-8 flex flex-col">
                <div class="flex flex-wrap gap-1 mb-3">
                    @foreach($product->categories as $cat)
                        <span class="bg-indigo-50 text-indigo-600 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $cat->name }}</span>
                    @endforeach
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                <div class="text-4xl font-extrabold text-indigo-600 mb-4">@currency($product->price)</div>
                <p class="text-gray-500 mb-6">{{ $product->description }}</p>

                <div class="mb-3">
                    @if($product->stock_quantity > 0)
                        <span class="inline-flex items-center gap-1 text-green-600 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            มีสินค้า ({{ $product->stock_quantity }} ชิ้น)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-red-500 text-sm font-medium">
                            สินค้าหมด
                        </span>
                    @endif
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto">
                    @csrf
                    <div class="flex items-center gap-3">
                        <input type="number" name="quantity" min="1" max="{{ $product->stock_quantity }}"
                            value="1"
                            class="w-20 border border-gray-200 rounded-xl px-3 py-3 text-center focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold shadow-sm shadow-indigo-200 hover:shadow-indigo-300 transition"
                            @if($product->stock_quantity <= 0) disabled @endif>
                            เพิ่มลงตะกร้า
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Content Blocks --}}
        @if(is_array($product->content_blocks) && count($product->content_blocks))
        <div class="border-t border-gray-100 p-8">
            <h3 class="text-2xl font-bold mb-6">รายละเอียดสินค้า</h3>
            <div class="space-y-5 max-w-3xl">
                @foreach($product->content_blocks as $block)
                    @if(($block['type'] ?? '') === 'heading')
                        <h4 class="text-xl font-bold text-gray-900">{{ $block['data'] }}</h4>
                    @elseif(in_array($block['type'] ?? '', ['text', 'paragraph']))
                        <p class="text-gray-700 leading-relaxed">{{ $block['data'] }}</p>
                    @elseif(($block['type'] ?? '') === 'image')
                        <img src="{{ $block['data'] }}" class="w-full rounded-xl shadow-sm" alt="">
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Reviews --}}
        <div class="border-t border-gray-100 p-8 bg-gray-50">
            <h3 class="text-2xl font-bold mb-6">รีวิวจากลูกค้า ({{ $product->reviews->count() }})</h3>

            @auth
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                <h4 class="font-semibold text-gray-800 mb-4">เขียนรีวิว</h4>
                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">คะแนน</label>
                        <div x-data="{ rating: 0 }" class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" @click="rating = {{ $i }}"
                                class="text-3xl transition-transform hover:scale-110"
                                :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'">★</button>
                            @endfor
                            <input type="hidden" name="rating" :value="rating">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">ความคิดเห็น</label>
                        <textarea name="comment" rows="3" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            placeholder="แชร์ประสบการณ์การใช้งานสินค้านี้...">{{ old('comment') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">รูปภาพ (ไม่บังคับ)</label>
                        <input type="file" name="photo" accept="image/*"
                            class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                    </div>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition">
                        ส่งรีวิว
                    </button>
                </form>
            </div>
            @else
            <p class="text-sm text-gray-500 mb-6">
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">เข้าสู่ระบบ</a> เพื่อเขียนรีวิว
            </p>
            @endauth

            <div class="space-y-4">
                @forelse($product->reviews as $review)
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-gray-800">{{ $review->user->name }}</span>
                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex text-yellow-400 mb-2 text-lg">
                        @for($i = 0; $i < 5; $i++)
                            <span>{{ $i < $review->rating ? '★' : '☆' }}</span>
                        @endfor
                    </div>
                    <p class="text-gray-700 text-sm">{{ $review->comment }}</p>

                    @if($review->photo_path)
                        <img src="{{ $review->photo_path }}" class="mt-3 w-32 h-32 object-cover rounded-lg border border-gray-100" alt="review photo">
                    @endif

                    @if($review->replies->isNotEmpty())
                    <div class="ml-6 mt-4 p-4 bg-indigo-50 rounded-xl border-l-4 border-indigo-400">
                        <p class="text-xs font-bold text-indigo-700 mb-1">ตอบกลับจากร้านค้า:</p>
                        <p class="text-sm text-gray-700">{{ $review->replies->first()->comment }}</p>
                    </div>
                    @endif
                </div>
                @empty
                <p class="text-gray-500 text-sm">ยังไม่มีรีวิว เป็นคนแรกเลยสิ!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
