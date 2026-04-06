@extends('layouts.profile')

@section('profile-content')

    @if(session('status') === 'password-updated')
        <div id="session-success" class="hidden">เปลี่ยนรหัสผ่านเรียบร้อยแล้ว</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">เปลี่ยนรหัสผ่าน</h2>
            <p class="text-xs text-gray-400 mt-0.5">ตรวจสอบให้แน่ใจว่ารหัสผ่านของคุณมีความยาวอย่างน้อย 8 ตัวอักษร</p>
        </div>

        <form method="POST" action="{{ route('profile.password.update') }}" class="px-6 sm:px-8 py-6 space-y-5 max-w-md">
            @csrf

            {{-- รหัสผ่านปัจจุบัน --}}
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1.5">รหัสผ่านปัจจุบัน</label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    autocomplete="current-password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 focus:outline-none transition-all
                           {{ $errors->has('current_password') ? 'border-rose-400 focus:border-rose-400 focus:ring-rose-100' : '' }}"
                >
                @error('current_password')
                    <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- รหัสผ่านใหม่ --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">รหัสผ่านใหม่</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 focus:outline-none transition-all
                           {{ $errors->has('password') ? 'border-rose-400 focus:border-rose-400 focus:ring-rose-100' : '' }}"
                >
                @error('password')
                    <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- ยืนยันรหัสผ่านใหม่ --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">ยืนยันรหัสผ่านใหม่</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 focus:outline-none transition-all"
                >
            </div>

            <div class="pt-2">
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-bold px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    บันทึกรหัสผ่าน
                </button>
            </div>
        </form>

    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sessionMsg = document.getElementById('session-success');
    if (sessionMsg) showToast(sessionMsg.textContent.trim());
});
</script>

@endsection
