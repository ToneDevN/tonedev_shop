<?php

declare(strict_types=1);

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class UploadSlipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    public function rules(): array
    {
        return [
            'slip' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg',
                'max:5120', // 5 MB
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'slip.required' => 'กรุณาอัปโหลดหลักฐานการชำระเงิน',
            'slip.mimes' => 'ไฟล์ต้องเป็นรูปภาพ jpeg หรือ png',
            'slip.max' => 'ขนาดไฟล์ต้องไม่เกิน 5 MB',
        ];
    }
}
