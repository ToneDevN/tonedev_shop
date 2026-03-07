@extends('layouts.simple')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">เพิ่มสินค้าใหม่</h1>
            <p class="text-gray-600 mt-1">กรอกข้อมูลรายละเอียดสินค้าและอัปโหลดรูปภาพเพื่อวางขายในร้าน</p>
        </div>
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 font-medium">← ยกเลิก</a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" 
          class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @csrf

        <div class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">ชื่อสินค้า <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           placeholder="เช่น iPhone 15 Pro Max 256GB"
                           class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 transition shadow-sm">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">ราคา (บาท) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-400">฿</span>
                        <input type="number" name="price" step="0.01" required value="{{ old('price') }}"
                               placeholder="0.00"
                               class="w-full pl-8 pr-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">จำนวนในสต็อก</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}"
                           class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">รายละเอียดสั้นๆ</label>
                <textarea name="description" rows="3" 
                          placeholder="อธิบายสินค้าสั้นๆ เพื่อให้ลูกค้าเข้าใจง่าย..."
                          class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">หมวดหมู่สินค้า</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($categories as $category)
                    <label class="relative flex items-center p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-3 text-sm text-gray-700">{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div x-data="{ blocks: [] }">
                <label class="block text-sm font-semibold text-gray-700 mb-2">รายละเอียดเพิ่มเติม (Content Blocks)</label>
                
                <template x-for="(block, index) in blocks" :key="index">
                    <div class="bg-gray-50 p-4 rounded-xl mb-4 border border-gray-200 relative">
                        <div class="grid grid-cols-1 gap-4">
                            <select x-model="block.type" class="rounded-lg border-gray-300 text-sm">
                                <option value="text">ข้อความธรรมดา (Text)</option>
                                <option value="heading">หัวข้อ (Heading)</option>
                            </select>
                            <textarea x-model="block.data" rows="2" class="rounded-lg border-gray-300 text-sm" placeholder="ใส่เนื้อหาที่นี่..."></textarea>
                        </div>
                        <button type="button" @click="blocks.splice(index, 1)" class="absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full p-1 hover:bg-red-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l18 18"></path></svg>
                        </button>
                        <input type="hidden" :name="'content_blocks['+index+'][type]'" :value="block.type">
                        <input type="hidden" :name="'content_blocks['+index+'][data]'" :value="block.data">
                    </div>
                </template>

                <button type="button" @click="blocks.push({type: 'text', data: ''})" 
                        class="w-full py-2 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 hover:border-indigo-400 hover:text-indigo-500 transition text-sm font-medium">
                    + เพิ่มบล็อกเนื้อหา (Heading / Text)
                </button>
            </div>

            <div x-data="{ imageUrl: null }">
                <label class="block text-sm font-semibold text-gray-700 mb-2">รูปภาพหน้าปกสินค้า <span class="text-red-500">*</span></label>
                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-indigo-400 transition cursor-pointer relative"
                     :class="imageUrl ? 'border-indigo-400 bg-indigo-50' : ''">
                    
                    <div class="space-y-1 text-center" x-show="!imageUrl">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                <span>อัปโหลดไฟล์</span>
                                <input name="image" type="file" class="sr-only" required
                                       @change="const file = $event.target.files[0]; if (file) { imageUrl = URL.createObjectURL(file) }">
                            </label>
                            <p class="pl-1">หรือลากไฟล์มาวาง</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF สูงสุด 2MB</p>
                    </div>

                    <template x-if="imageUrl">
                        <div class="relative w-full flex justify-center">
                            <img :src="imageUrl" class="max-h-64 rounded-lg shadow-md">
                            <button type="button" @click="imageUrl = null; $refs.fileInput.value = ''" 
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-5 flex items-center justify-end space-x-4">
            <button type="reset" class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-200 rounded-xl transition">ล้างข้อมูล</button>
            <button type="submit" class="px-10 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition transform hover:-translate-y-0.5">
                ยืนยันการเพิ่มสินค้า
            </button>
        </div>
    </form>
</div>
@endsection