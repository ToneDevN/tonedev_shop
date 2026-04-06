@extends('layouts.profile')

@section('profile-content')

    {{-- Session Message (แสดงเป็น toast เมื่อ reload หลังบันทึก) --}}
    @if(session('status') === 'profile-updated')
        <div id="session-success" class="hidden">อัปเดตข้อมูลโปรไฟล์เรียบร้อยแล้ว</div>
    @endif

    {{-- ─── Profile Form Card ────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 sm:px-8 py-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900">ข้อมูลส่วนตัว</h2>
                <p class="text-xs text-gray-400 mt-0.5">จัดการข้อมูลเพื่อความปลอดภัยของบัญชี</p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-form" class="w-full">
            @csrf
            @method('PATCH')

            <div class="flex flex-row w-full border-t border-gray-100">

                {{-- Fields --}}
                <div class="flex-1 min-w-0 px-6 sm:px-8 py-6">
                    <table class="w-full border-separate border-spacing-y-0">
                        <tbody class="divide-y divide-gray-100">

                            {{-- ชื่อผู้ใช้ --}}
                            <tr>
                                <th scope="row" class="w-36 sm:w-44 text-xs font-semibold text-gray-400 uppercase tracking-wide text-right pr-6 align-middle py-3.5 whitespace-nowrap">
                                    ชื่อผู้ใช้
                                </th>
                                <td class="align-middle py-1">
                                    <input name="username" type="text" value="{{ old('username', $user->username) }}"
                                        placeholder="กรอกชื่อผู้ใช้"
                                        class="w-full max-w-xs border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-800 bg-gray-50 hover:bg-white focus:bg-white focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                                    @error('username') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </td>
                            </tr>

                            {{-- ชื่อ --}}
                            <tr>
                                <th scope="row" class="text-xs font-semibold text-gray-400 uppercase tracking-wide text-right pr-6 align-middle py-3.5 whitespace-nowrap">
                                    ชื่อ
                                </th>
                                <td class="align-middle py-1">
                                    <input name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}"
                                        placeholder="กรอกชื่อ"
                                        class="w-full max-w-xs border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-800 bg-gray-50 hover:bg-white focus:bg-white focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                                    @error('first_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </td>
                            </tr>

                            {{-- นามสกุล --}}
                            <tr>
                                <th scope="row" class="text-xs font-semibold text-gray-400 uppercase tracking-wide text-right pr-6 align-middle py-3.5 whitespace-nowrap">
                                    นามสกุล
                                </th>
                                <td class="align-middle py-1">
                                    <input name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}"
                                        placeholder="กรอกนามสกุล"
                                        class="w-full max-w-xs border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-800 bg-gray-50 hover:bg-white focus:bg-white focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                                    @error('last_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </td>
                            </tr>

                            {{-- อีเมล --}}
                            <tr x-data="{ editing: false }">
                                <th scope="row" class="text-xs font-semibold text-gray-400 uppercase tracking-wide text-right pr-6 align-middle py-3.5 whitespace-nowrap">
                                    อีเมล
                                </th>
                                <td class="align-middle py-1">
                                    <div class="flex items-center justify-between gap-3">
                                        <div x-show="!editing" class="flex items-center gap-3">
                                            @php
                                                $email  = $user->email ?? '';
                                                $masked = strlen($email) > 4
                                                    ? substr($email, 0, 2) . str_repeat('*', 6) . strstr($email, '@')
                                                    : $email;
                                            @endphp
                                            <span class="text-sm font-medium text-gray-700">{{ $masked }}</span>
                                            <button type="button" @click="editing = true; $nextTick(() => $refs.emailInput.focus())"
                                                class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1 rounded-lg transition-all">
                                                แก้ไข
                                            </button>
                                        </div>
                                        <div x-show="editing" x-cloak class="flex items-center gap-2">
                                            <input x-ref="emailInput" name="email" type="email" value="{{ old('email', $user->email) }}"
                                                placeholder="กรอกอีเมล"
                                                class="w-full max-w-xs border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-800 bg-gray-50 hover:bg-white focus:bg-white focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                                            <button type="button" @click="editing = false"
                                                class="text-xs text-gray-400 hover:text-gray-600 transition-colors">ยกเลิก</button>
                                        </div>
                                        @if(!$user->email_verified_at)
                                            <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-medium text-red-600 bg-red-50 border border-red-100 px-2.5 py-1 rounded-full shrink-0">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>ยังไม่ยืนยัน
                                            </span>
                                        @else
                                            <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full shrink-0">
                                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>ยืนยันแล้ว
                                            </span>
                                        @endif
                                    </div>
                                    @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </td>
                            </tr>

                            {{-- เพศ --}}
                            <tr>
                                <th scope="row" class="text-xs font-semibold text-gray-400 uppercase tracking-wide text-right pr-6 align-middle py-3.5 whitespace-nowrap">
                                    เพศ
                                </th>
                                <td class="align-middle py-1">
                                    <div class="flex items-center gap-5">
                                        @foreach(['male' => 'ชาย', 'female' => 'หญิง', 'other' => 'ไม่ระบุ'] as $val => $label)
                                        <label class="flex items-center gap-2 cursor-pointer group/radio">
                                            <input type="radio" name="gender" value="{{ $val }}"
                                                class="w-4 h-4 accent-indigo-600 cursor-pointer"
                                                {{ old('gender', $user->gender) === $val ? 'checked' : '' }}>
                                            <span class="text-sm text-gray-600 group-hover/radio:text-indigo-600 transition-all select-none">{{ $label }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @error('gender') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </td>
                            </tr>

                            {{-- เบอร์โทรศัพท์ --}}
                            <tr x-data="{ editing: false }">
                                <th scope="row" class="text-xs font-semibold text-gray-400 uppercase tracking-wide text-right pr-6 align-middle py-3.5 whitespace-nowrap">
                                    เบอร์โทร
                                </th>
                                <td class="align-middle py-1">
                                    <div class="flex items-center justify-between gap-3">
                                        <div x-show="!editing" class="flex items-center gap-3">
                                            @if($user->phone_number)
                                                <span class="text-sm font-medium text-gray-800">{{ $user->phone_number }}</span>
                                                <button type="button" @click="editing = true; $nextTick(() => $refs.phoneInput.focus())" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1 rounded-lg transition-colors">แก้ไข</button>
                                            @else
                                                <span class="text-sm text-gray-400 italic">ยังไม่ได้เพิ่ม</span>
                                                <button type="button" @click="editing = true; $nextTick(() => $refs.phoneInput.focus())" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-2.5 py-1 rounded-lg transition-colors">+ เพิ่ม</button>
                                            @endif
                                        </div>
                                        <div x-show="editing" x-cloak class="flex items-center gap-2">
                                            <input x-ref="phoneInput" name="phone_number" type="tel" value="{{ old('phone_number', $user->phone_number) }}"
                                                placeholder="0xx-xxx-xxxx"
                                                class="w-full max-w-xs border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-800 bg-gray-50 hover:bg-white focus:bg-white focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                                            <button type="button" @click="editing = false"
                                                class="text-xs text-gray-400 hover:text-gray-600 transition-colors">ยกเลิก</button>
                                        </div>
                                        @if(!$user->phone_number_verified_at)
                                            <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-medium text-red-600 bg-red-50 border border-red-100 px-2.5 py-1 rounded-full shrink-0">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>ยังไม่ยืนยัน
                                            </span>
                                        @else
                                            <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-full shrink-0">
                                                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>ยืนยันแล้ว
                                            </span>
                                        @endif
                                    </div>
                                    @error('phone_number') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </td>
                            </tr>

                            {{-- วันเกิด --}}
                            <tr>
                                <th scope="row" class="text-xs font-semibold text-gray-400 uppercase tracking-wide text-right pr-6 align-middle py-3.5 whitespace-nowrap">
                                    วันเกิด
                                </th>
                                <td class="align-middle py-1">
                                    <input name="birth_date" type="date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                        class="w-full max-w-xs border border-gray-200 rounded-xl px-3.5 py-2 text-sm text-gray-800 bg-gray-50 hover:bg-white focus:bg-white focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                                    @error('birth_date') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </td>
                            </tr>

                            {{-- Save Button --}}
                            <tr>
                                <th></th>
                                <td class="pt-6 pb-8">
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-bold px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 transition-all duration-150 w-fit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        บันทึกข้อมูล
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                {{-- Avatar Section --}}
                <div class="w-1/3 shrink-0 px-6 py-10 flex flex-col items-center gap-6 border-l border-gray-100">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-100 shadow-md bg-gradient-to-br from-indigo-100 to-purple-100">
                            <img
                                id="avatar-preview"
                                src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}"
                                alt="รูปโปรไฟล์"
                                class="w-full h-full object-cover {{ $user->avatar ? '' : 'hidden' }}"
                            >
                            <div id="avatar-initials" class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-4xl font-bold {{ $user->avatar ? 'hidden' : '' }}">
                                {{ strtoupper(substr($user->name ?: ($user->first_name ?: 'U'), 0, 1)) }}
                            </div>
                        </div>
                        <label for="avatar-upload" class="absolute inset-0 rounded-2xl bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer gap-1">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-white text-[10px] font-medium">เปลี่ยนรูป</span>
                        </label>
                    </div>

                    <input id="avatar-upload" type="file" accept="image/jpeg,image/png" class="hidden">
                    <input type="hidden" name="avatar" id="avatar-path-input" value="{{ $user->avatar }}">
                    <label for="avatar-upload" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 border border-gray-200 hover:border-indigo-300 hover:text-indigo-600 px-4 py-2 rounded-xl cursor-pointer transition-all hover:bg-indigo-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        เลือกรูปภาพ
                    </label>
                    <div class="text-center space-y-0.5">
                        <p class="text-xs text-gray-400">JPEG หรือ PNG · สูงสุด 1 MB</p>
                        @error('avatar') <p class="text-[10px] text-rose-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

            </div>
        </form>

    </div>

    {{-- ─── Danger Zone ──────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-rose-100 overflow-hidden">
        <div class="px-6 sm:px-8 py-4 border-b border-rose-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <h3 class="text-sm font-bold text-rose-600">โซนอันตราย</h3>
        </div>
        <div class="px-6 sm:px-8 py-5 flex items-center justify-between flex-wrap gap-4">
            <div>
                <p class="text-sm font-semibold text-gray-800">ลบบัญชีของฉัน</p>
                <p class="text-xs text-gray-400 mt-0.5">เมื่อลบบัญชีแล้ว ข้อมูลทั้งหมดจะถูกลบอย่างถาวรและไม่สามารถกู้คืนได้</p>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบบัญชีนี้?')">
                @csrf
                @method('DELETE')
                <input type="hidden" name="password" value="">
                <button type="submit" class="inline-flex items-center gap-1.5 text-sm font-semibold text-rose-600 border border-rose-200 hover:bg-rose-50 hover:border-rose-300 px-4 py-2 rounded-xl transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    ลบบัญชี
                </button>
            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sessionMsg = document.getElementById('session-success');
    if (sessionMsg) showToast(sessionMsg.textContent.trim());

    let pendingFile = null;

    document.getElementById('avatar-upload').addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        if (file.size > 1 * 1024 * 1024) {
            showToast('ขนาดไฟล์ต้องไม่เกิน 1 MB', 'warning');
            event.target.value = '';
            return;
        }

        pendingFile = file;

        const preview  = document.getElementById('avatar-preview');
        const initials = document.getElementById('avatar-initials');

        if (pendingFile._blobUrl) URL.revokeObjectURL(pendingFile._blobUrl);
        const blobUrl = URL.createObjectURL(file);
        pendingFile._blobUrl = blobUrl;

        preview.src = blobUrl;
        preview.classList.remove('hidden');
        initials.classList.add('hidden');
    });

    document.getElementById('profile-form').addEventListener('submit', async (event) => {
        if (!pendingFile) return;

        event.preventDefault();

        const saveBtn   = event.submitter;
        const pathInput = document.getElementById('avatar-path-input');
        const preview   = document.getElementById('avatar-preview');

        const originalLabel = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.innerHTML = `<svg class="w-4 h-4 animate-spin shrink-0" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg> กำลังบันทึก...`;
        preview.style.opacity = '0.5';

        const formData = new FormData();
        formData.append('image', pendingFile);
        formData.append('directory', 'avatars');

        try {
            const res = await axios.post('/api/upload/image', formData, {
                withCredentials: true,
            });

            pathInput.value = res.data.image_path;
            preview.src     = res.data.url;

            if (pendingFile._blobUrl) URL.revokeObjectURL(pendingFile._blobUrl);
            pendingFile = null;

            event.target.submit();
        } catch (error) {
            console.error('Upload failed:', error);
            showToast(error.response?.data?.message || 'อัปโหลดรูปภาพไม่สำเร็จ กรุณาลองใหม่', 'error');
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalLabel;
            preview.style.opacity = '1';
        }
    });
});
</script>

@endsection
