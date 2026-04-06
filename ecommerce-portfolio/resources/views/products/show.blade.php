@extends('layouts.simple')


@section('content')
    <div class="max-w-5xl mx-auto px-4">
                {{-- ... โค้ดอื่นๆ ... --}}
                <!DOCTYPE html>
                <html lang="th">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>{{ $product->name }} - ShopPortfolio</title>
                    @vite(['resources/css/app.css', 'resources/js/app.js'])
                    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
                </head>
                <body class="bg-gray-100 font-sans antialiased">

                    <nav class="bg-white shadow mb-8">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center">
                            <a href="/" class="text-indigo-600 font-bold text-xl">← Back to Shop</a>
                        </div>
                    </nav>

                    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
                        
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="md:flex">
                                
                                @php
                                    // รวมรูปภาพจาก 2 แหล่ง: ตาราง products (JSON column) และตาราง product_images (relationship)
                                    $gallery = collect();

                                    // 1. จาก JSON column ใน products
                                    if (is_array($product->images)) {
                                        foreach($product->images as $img) {
                                            $gallery->push($img);
                                        }
                                    }

                                    // 2. จากตาราง product_images
                                    foreach($product->product_images as $img) {
                                        $gallery->push($img->image_path);
                                    }

                                    // ลบค่าที่ซ้ำกันและจัดระเบียบใหม่
                                    $gallery = $gallery->filter()->unique()->values();

                                    // กำหนดรูปเปิดหน้าแรก (ถ้ามีรูปจาก product_images ที่เป็น is_primary ให้ใช้ก่อน)
                                    $initialImage = $product->coverImage->image_path ?? $gallery->first() ?? '';
                                @endphp

                                <div class="md:w-1/2 p-4" x-data="{ activeImage: '{{ $initialImage }}' }">
                                    <div class="h-96 bg-gray-200 rounded-lg overflow-hidden mb-4 flex items-center justify-center">
                                        <template x-if="activeImage">
                                            <img :src="activeImage" class="h-full object-contain">
                                        </template>
                                        <template x-if="!activeImage">
                                            <div class="text-gray-400">ไม่มีรูปภาพ</div>
                                        </template>
                                    </div>
                                    
                                    <div class="flex gap-2 overflow-x-auto pb-2">
                                        @foreach($gallery as $imgUrl)
                                        <button @click="activeImage = '{{ $imgUrl }}'" 
                                                class="w-20 h-20 border-2 rounded-md overflow-hidden hover:border-indigo-500 transition focus:outline-none flex-shrink-0"
                                                :class="activeImage === '{{ $imgUrl }}' ? 'border-indigo-500' : 'border-gray-200'">
                                            <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                                        </button>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="md:w-1/2 p-8">
                                    <div class="flex items-center text-sm text-gray-500 mb-2 space-x-2">
                                        @foreach($product->categories as $cat)
                                            <span class="bg-gray-200 px-2 py-1 rounded">{{ $cat->name }}</span>
                                        @endforeach
                                    </div>
                                    
                                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                                    
                                    <div class="text-4xl font-bold text-indigo-600 mb-6">฿{{ number_format($product->price, 2) }}</div>

                                    <div class="prose max-w-none text-gray-600 mb-8">
                                        {{ $product->description }} </div>

                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <div class="flex items-center space-x-4">
                                            <input type="number" name="quantity" min="1" value="1" class="w-20 border-gray-300 rounded-md">
                                            <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700">
                                                เพิ่มลงตะกร้า
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 p-8">
                                <h3 class="text-2xl font-bold mb-6">รายละเอียดสินค้า</h3>
                                
                                <div class="space-y-6 max-w-4xl mx-auto">
                                    @if(is_array($product->content_blocks))
                                        @if($product->content_blocks)
                                            @foreach($product->content_blocks as $block)
                                            
                                                @if($block['type'] === 'text' || $block['type'] === 'paragraph')
                                                    <p class="text-gray-700 leading-relaxed text-lg">{{ $block['data'] }}</p>
                                                
                                                @elseif($block['type'] === 'heading')
                                                    <h4 class="text-xl font-bold text-gray-900 mt-4">{{ $block['data'] }}</h4>

                                                @elseif($block['type'] === 'image')
                                                    <img src="{{ $block['data'] }}" class="w-full rounded-lg shadow-sm my-4">

                                                @endif

                                            @endforeach
                                        @else
                                            <p class="text-gray-400 italic">ไม่มีรายละเอียดเพิ่มเติม</p>
                                        @endif
                                    @else
                                        <p class="text-gray-400 italic">ไม่มีรายละเอียดเพิ่มเติม</p>
                                    @endif
                                </div>
                            </div>

                            <div class="border-t border-gray-200 p-8 bg-gray-50">
                                <h3 class="text-2xl font-bold mb-6">รีวิวจากลูกค้า ({{ $product->reviews->count() }})</h3>
                                <div class="space-y-4">
                                    @forelse($product->reviews as $review)
                                    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-semibold">{{ $review->user->full_name }}</span>
                                            <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex text-yellow-400 mb-2">
                                            @for($i=0; $i<5; $i++)
                                                <span>{{ $i < $review->rating ? '★' : '☆' }}</span>
                                            @endfor
                                        </div>
                                        <p class="text-gray-700">{{ $review->comment }}</p>
                                        
                                        @if($review->replies && $review->replies->count() > 0)
                                            <div class="ml-8 mt-4 p-3 bg-gray-100 rounded border-l-4 border-indigo-500">
                                                <p class="text-sm font-bold text-indigo-600">ตอบกลับจากร้านค้า:</p>
                                                <p class="text-sm text-gray-600">{{ $review->replies->first()->comment }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    @empty
                                        <p class="text-gray-500">ยังไม่มีรีวิว เป็นคนแรกเลยสิ!</p>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </main>
                </body>
                </html>
    </div>
@endsection
