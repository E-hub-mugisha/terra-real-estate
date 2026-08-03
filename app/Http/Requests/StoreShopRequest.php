<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public registration form
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'max:4096'],

            // Rwandan mobile format: 078/072/073/079 + 7 digits
            'phone' => ['required', 'regex:/^(078|072|073|079)\d{7}$/'],
            'whatsapp_number' => ['required', 'regex:/^(078|072|073|079)\d{7}$/'],
            'email' => ['nullable', 'email', 'max:150'],

            'district' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'sector' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Enter a valid Rwandan phone number starting with 078, 072, 073, or 079.',
            'whatsapp_number.regex' => 'Enter a valid Rwandan WhatsApp number starting with 078, 072, 073, or 079.',
        ];
    }
}
