@extends('layouts.simple')

@section('content')
<div class="max-w-xl mx-auto px-4 py-12">
    <a href="{{ route('addresses.index') }}" class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        กลับไปสมุดที่อยู่
    </a>
    <h1 class="text-2xl font-extrabold text-gray-900 mb-8">แก้ไขที่อยู่</h1>

    <form action="{{ route('addresses.update', $address) }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-5">
        @csrf @method('PATCH')
        @include('member.addresses._form')
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">
            บันทึกการเปลี่ยนแปลง
        </button>
    </form>
</div>
@endsection
