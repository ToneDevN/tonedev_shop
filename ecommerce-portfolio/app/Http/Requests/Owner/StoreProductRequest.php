<?php

declare(strict_types=1);

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('owner') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'content_blocks' => ['nullable', 'array'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'กรุณากรอกชื่อสินค้า',
            'price.required' => 'กรุณากรอกราคาสินค้า',
            'categories.required' => 'กรุณาเลือกหมวดหมู่อย่างน้อย 1 หมวด',
            'image.required' => 'กรุณาอัปโหลดรูปภาพสินค้า',
            'image.mimes' => 'รูปภาพต้องเป็นไฟล์ jpeg, png, jpg หรือ webp เท่านั้น',
            'image.max' => 'ขนาดรูปภาพต้องไม่เกิน 2 MB',
        ];
    }
}
