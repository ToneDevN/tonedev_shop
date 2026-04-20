<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // guest checkout is allowed
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => __('validation.required', ['attribute' => 'ชื่อ-นามสกุล']),
            'phone.required' => __('validation.required', ['attribute' => 'เบอร์โทรศัพท์']),
            'address.required' => __('validation.required', ['attribute' => 'ที่อยู่จัดส่ง']),
        ];
    }
}
