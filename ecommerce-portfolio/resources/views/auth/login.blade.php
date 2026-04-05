@extends('layouts.auth')

@section('title', 'เข้าสู่ระบบ - Tonedev Shop')

@section('content')
<div x-data="loginForm()">
    <h2 class="text-2xl font-bold text-gray-900 mb-1">เข้าสู่ระบบ</h2>
    <p class="text-sm text-gray-500 mb-6">ยินดีต้อนรับกลับมา</p>

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
        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">อีเมล</label>
            <input type="email" id="email" x-model="form.email"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-150 text-sm"
                   placeholder="you@example.com" required>
            <p x-show="errors.email" x-text="errors.email?.[0]" class="mt-1 text-xs text-rose-500"></p>
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">รหัสผ่าน</label>
            <div class="relative" x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'" id="password" x-model="form.password"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition-all duration-150 text-sm pr-10"
                       placeholder="••••••••" required>
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

        {{-- Submit --}}
        <button type="submit" :disabled="loading"
                class="w-full mt-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-2.5 px-4 rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg hover:shadow-indigo-300 transition-all duration-200 text-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
            <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span x-text="loading ? 'กำลังเข้าสู่ระบบ...' : 'เข้าสู่ระบบ'"></span>
        </button>
    </form>
</div>

<script>
function loginForm() {
    return {
        form: { email: '', password: '' },
        errors: {},
        globalError: @json(session('error', '')),
        loading: false,

        async submit() {
            this.errors = {};
            this.globalError = '';
            this.loading = true;

            try {
                const res = await axios.post('/api/auth/login', this.form);
                if (res.data.success) {
                    localStorage.setItem('jwt_token', res.data.token);
                    localStorage.setItem('user', JSON.stringify(res.data.user));

                    // กลับไปยังหน้าที่ต้องการก่อนหน้า หรือ homepage
                    const params  = new URLSearchParams(window.location.search);
                    const redirect = params.get('redirect');
                    window.location.href = redirect && redirect.startsWith('/') ? redirect : '/';
                }
            } catch (e) {
                if (e.response?.status === 422) {
                    this.errors = e.response.data.errors || {};
                } else if (e.response?.status === 401) {
                    this.globalError = e.response.data.message || 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
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
        ยังไม่มีบัญชี?
        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold hover:underline">สมัครสมาชิก</a>
    </p>
@endsection
