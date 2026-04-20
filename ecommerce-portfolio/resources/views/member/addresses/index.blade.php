@extends('layouts.simple')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900">สมุดที่อยู่</h1>
        <a href="{{ route('addresses.create') }}"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            เพิ่มที่อยู่ใหม่
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
    @endif

    @if($addresses->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-gray-400">ยังไม่มีที่อยู่ที่บันทึกไว้</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($addresses as $address)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-start justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        @if($address->label)
                            <span class="bg-indigo-50 text-indigo-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $address->label }}</span>
                        @endif
                        @if($address->is_default)
                            <span class="bg-green-50 text-green-600 text-xs font-semibold px-2 py-0.5 rounded-full">ที่อยู่หลัก</span>
                        @endif
                    </div>
                    <p class="font-semibold text-gray-800">{{ $address->recipient_name }}</p>
                    <p class="text-sm text-gray-500">{{ $address->phone }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $address->toShippingString() }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('addresses.edit', $address) }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">แก้ไข</a>
                    <form action="{{ route('addresses.destroy', $address) }}" method="POST"
                        onsubmit="return confirm('ลบที่อยู่นี้ใช่ไหม?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-400 hover:text-red-600 transition">ลบ</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
