<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">ป้ายชื่อ (ไม่บังคับ)</label>
    <input type="text" name="label" value="{{ old('label', $address->label ?? '') }}"
        placeholder="เช่น บ้าน, ที่ทำงาน"
        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @error('label')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อผู้รับ <span class="text-red-500">*</span></label>
        <input type="text" name="recipient_name" required value="{{ old('recipient_name', $address->recipient_name ?? '') }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('recipient_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">เบอร์โทร <span class="text-red-500">*</span></label>
        <input type="text" name="phone" required value="{{ old('phone', $address->phone ?? '') }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">ที่อยู่ <span class="text-red-500">*</span></label>
    <textarea name="address" required rows="3"
        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('address', $address->address ?? '') }}</textarea>
    @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">อำเภอ/เขต</label>
        <input type="text" name="city" value="{{ old('city', $address->city ?? '') }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">จังหวัด</label>
        <input type="text" name="state" value="{{ old('state', $address->state ?? '') }}"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">รหัสไปรษณีย์</label>
    <input type="text" name="zip_code" value="{{ old('zip_code', $address->zip_code ?? '') }}"
        class="w-24 px-4 py-2.5 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
</div>

<label class="flex items-center gap-2 cursor-pointer">
    <input type="hidden" name="is_default" value="0">
    <input type="checkbox" name="is_default" value="1" {{ old('is_default', ($address->is_default ?? false) ? '1' : '0') == '1' ? 'checked' : '' }}
        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
    <span class="text-sm text-gray-700">ตั้งเป็นที่อยู่หลัก</span>
</label>
