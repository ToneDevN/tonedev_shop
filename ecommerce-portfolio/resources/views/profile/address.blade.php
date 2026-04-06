@extends('layouts.profile')

@section('profile-content')

    {{-- Session Toast --}}
    @if(session('status') === 'address-created')
        <div id="session-success" class="hidden">เพิ่มที่อยู่จัดส่งเรียบร้อยแล้ว</div>
    @elseif(session('status') === 'address-updated')
        <div id="session-success" class="hidden">แก้ไขที่อยู่จัดส่งเรียบร้อยแล้ว</div>
    @elseif(session('status') === 'address-deleted')
        <div id="session-success" class="hidden" data-type="warning">ลบที่อยู่จัดส่งเรียบร้อยแล้ว</div>
    @endif

    {{-- ─── Header ──────────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 sm:px-8 py-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-900">ที่อยู่จัดส่ง</h2>
                <p class="text-xs text-gray-400 mt-0.5">จัดการที่อยู่สำหรับการจัดส่งสินค้า</p>
            </div>
            <button
                type="button"
                onclick="openAddressModal()"
                class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-sm font-bold px-4 py-2 rounded-xl shadow-md shadow-indigo-200 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                เพิ่มที่อยู่
            </button>
        </div>

        {{-- ─── Address List ──────────────────────────────────────── --}}
        <div class="px-6 sm:px-8 py-6 space-y-4">

            @forelse($addresses as $addr)
                <div class="relative flex gap-4 p-5 rounded-2xl border border-gray-100 bg-gray-50 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all group">

                    {{-- Icon --}}
                    <div class="shrink-0 w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">{{ $addr->customer_name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $addr->phone }}</p>
                        <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $addr->address }}</p>
                    </div>

                    {{-- Actions --}}
                    <div class="shrink-0 flex items-start gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button
                            type="button"
                            onclick="openAddressModal({{ $addr->id }}, '{{ addslashes($addr->customer_name) }}', '{{ addslashes($addr->phone) }}', '{{ addslashes($addr->address) }}')"
                            class="text-xs font-bold text-indigo-600 hover:text-indigo-700 bg-white hover:bg-indigo-50 border border-indigo-200 px-3 py-1.5 rounded-lg transition-all">
                            แก้ไข
                        </button>
                        <form method="POST" action="{{ route('profile.address.destroy', $addr->id) }}"
                              onsubmit="return confirm('ต้องการลบที่อยู่นี้?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-xs font-bold text-rose-500 hover:text-rose-600 bg-white hover:bg-rose-50 border border-rose-200 px-3 py-1.5 rounded-lg transition-all">
                                ลบ
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-14 text-center">
                    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-500">ยังไม่มีที่อยู่จัดส่ง</p>
                    <p class="text-xs text-gray-400 mt-1">กดปุ่ม "เพิ่มที่อยู่" เพื่อเพิ่มที่อยู่ใหม่</p>
                </div>
            @endforelse

        </div>
    </div>

    {{-- ─── Modal ────────────────────────────────────────────────── --}}
    <div id="address-modal"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden"
         role="dialog" aria-modal="true">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeAddressModal()"></div>

        {{-- Dialog --}}
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <h3 id="modal-title" class="text-base font-bold text-gray-900">เพิ่มที่อยู่จัดส่ง</h3>
                <button type="button" onclick="closeAddressModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="address-form" method="POST" action="{{ route('profile.address.store') }}" class="px-6 py-6 space-y-4">
                @csrf
                <span id="method-field"></span>

                @if($errors->any())
                    <div class="text-xs text-rose-500 bg-rose-50 border border-rose-100 rounded-xl px-4 py-3 space-y-1">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- ชื่อผู้รับ --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">ชื่อผู้รับ <span class="text-rose-500">*</span></label>
                    <input
                        id="field-customer-name"
                        name="customer_name"
                        type="text"
                        placeholder="ชื่อ-นามสกุลผู้รับ"
                        value="{{ old('customer_name') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 bg-white focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                </div>

                {{-- เบอร์โทรศัพท์ --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">เบอร์โทรศัพท์ <span class="text-rose-500">*</span></label>
                    <input
                        id="field-phone"
                        name="phone"
                        type="tel"
                        placeholder="0xx-xxx-xxxx"
                        value="{{ old('phone') }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 bg-white focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                </div>

                {{-- ที่อยู่ --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">ที่อยู่ <span class="text-rose-500">*</span></label>
                    <textarea
                        id="field-address"
                        name="address"
                        rows="4"
                        placeholder="บ้านเลขที่ ถนน แขวง/ตำบล เขต/อำเภอ จังหวัด รหัสไปรษณีย์"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 bg-white focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all resize-none">{{ old('address') }}</textarea>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeAddressModal()"
                        class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        ยกเลิก
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-95 rounded-xl shadow-md shadow-indigo-200 transition-all">
                        บันทึก
                    </button>
                </div>

            </form>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sessionMsg = document.getElementById('session-success');
    if (sessionMsg) {
        const type = sessionMsg.dataset.type || 'success';
        showToast(sessionMsg.textContent.trim(), type);
    }

    @if($errors->any())
        openAddressModal(
            {{ old('_address_id', 0) }},
            '{{ addslashes(old('customer_name', '')) }}',
            '{{ addslashes(old('phone', '')) }}',
            '{{ addslashes(old('address', '')) }}'
        );
    @endif
});

function openAddressModal(id = 0, customerName = '', phone = '', address = '') {
    const modal      = document.getElementById('address-modal');
    const form       = document.getElementById('address-form');
    const title      = document.getElementById('modal-title');
    const methodEl   = document.getElementById('method-field');

    document.getElementById('field-customer-name').value = customerName;
    document.getElementById('field-phone').value          = phone;
    document.getElementById('field-address').value        = address;

    if (id) {
        title.textContent    = 'แก้ไขที่อยู่จัดส่ง';
        form.action          = `/profile/address/${id}`;
        methodEl.innerHTML   = '<input type="hidden" name="_method" value="PATCH">';
    } else {
        title.textContent    = 'เพิ่มที่อยู่จัดส่ง';
        form.action          = '{{ route('profile.address.store') }}';
        methodEl.innerHTML   = '';
    }

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAddressModal() {
    document.getElementById('address-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeAddressModal();
});
</script>

@endsection
