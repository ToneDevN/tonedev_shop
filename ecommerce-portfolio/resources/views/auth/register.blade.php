@extends('layouts.auth')

@section('title', 'สมัครสมาชิก - Tonedev Shop')

@section('content')
<div x-data="registerForm()">
    <h2 class="text-2xl font-bold text-gray-900 mb-1">สมัครสมาชิก</h2>
    <p class="text-sm text-gray-500 mb-6">สร้างบัญชีใหม่เพื่อเริ่มช้อปปิ้ง</p>

    {{-- Global error --}}
    <div x-show="globalError" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="mb-4 p-3 bg-rose-50 border border-rose-200 rounded-xl text-sm text-rose-600 flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span x-text="globalError"></span>
    </div>

    <form @submit.prevent="submit">
        {{-- Name row --}}
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1.5">ชื่อ</label>
                <input type="text" id="first_name" x-model="form.first_name"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-150 text-sm"
                       placeholder="ชื่อ" required>
                <p x-show="errors.first_name" x-text="errors.first_name?.[0]" class="mt-1 text-xs text-rose-500"></p>
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1.5">นามสกุล</label>
                <input type="text" id="last_name" x-model="form.last_name"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-150 text-sm"
                       placeholder="นามสกุล" required>
                <p x-show="errors.last_name" x-text="errors.last_name?.[0]" class="mt-1 text-xs text-rose-500"></p>
            </div>
        </div>

        {{-- Birth date --}}
        <div class="mb-4">
            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1.5">วันเกิด</label>
            <input type="date" id="birth_date" x-model="form.birth_date"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-150 text-sm"
                   required>
            <p x-show="errors.birth_date" x-text="errors.birth_date?.[0]" class="mt-1 text-xs text-rose-500"></p>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">อีเมล</label>
            <input type="email" id="email" x-model="form.email"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-150 text-sm"
                   placeholder="you@example.com" required>
            <p x-show="errors.email" x-text="errors.email?.[0]" class="mt-1 text-xs text-rose-500"></p>
        </div>

        {{-- Phone --}}
        <div class="mb-4">
            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1.5">เบอร์โทรศัพท์</label>
            <input type="tel" id="phone_number" x-model="form.phone_number"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-150 text-sm"
                   placeholder="0812345678" required>
            <p x-show="errors.phone_number" x-text="errors.phone_number?.[0]" class="mt-1 text-xs text-rose-500"></p>
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">รหัสผ่าน</label>
            <div class="relative" x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'" id="password" x-model="form.password"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-150 text-sm pr-10"
                       placeholder="อย่างน้อย 8 ตัวอักษร" required>
                <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            <p x-show="errors.password" x-text="errors.password?.[0]" class="mt-1 text-xs text-rose-500"></p>
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">ยืนยันรหัสผ่าน</label>
            <input type="password" id="password_confirmation" x-model="form.password_confirmation"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-150 text-sm"
                   placeholder="กรอกรหัสผ่านอีกครั้ง" required>
        </div>

        {{-- Submit --}}
        <button type="submit" :disabled="loading"
                class="w-full mt-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-2.5 px-4 rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:shadow-indigo-300 transition-all duration-200 text-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
            <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span x-text="loading ? 'กำลังสมัครสมาชิก...' : 'สมัครสมาชิก'"></span>
        </button>
    </form>
</div>

<script>
function registerForm() {
    return {
        form: {
            first_name: '',
            last_name: '',
            birth_date: '',
            email: '',
            phone_number: '',
            password: '',
            password_confirmation: '',
        },
        errors: {},
        globalError: '',
        loading: false,

        async submit() {
            this.errors = {};
            this.globalError = '';
            this.loading = true;

            try {
                const res = await axios.post('/api/auth/register', this.form);
                if (res.data.success) {
                    localStorage.setItem('jwt_token', res.data.token);
                    localStorage.setItem('user', JSON.stringify(res.data.user));
                    window.location.href = '/';
                }
            } catch (e) {
                if (e.response?.status === 422) {
                    this.errors = e.response.data.errors || {};
                } else {
                    this.globalError = 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง';
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection

@section('footer')
    <p class="text-sm text-gray-500">
        มีบัญชีอยู่แล้ว?
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold hover:underline">เข้าสู่ระบบ</a>
    </p>
@endsection
