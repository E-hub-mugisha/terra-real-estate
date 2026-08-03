<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShopRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string', 'max:2000'],
            'logo'             => ['nullable', 'image', 'max:2048'],
            'cover_image'      => ['nullable', 'image', 'max:4096'],
            'phone'            => ['required', 'regex:/^(078|072|073|079)[0-9]{7}$/', 'unique:shops,phone'],
            'whatsapp_number'  => ['required', 'regex:/^(078|072|073|079)[0-9]{7}$/'],
            'email'            => ['nullable', 'email', 'max:255'],
            'district'         => ['nullable', 'string', 'max:255'],
            'province'         => ['nullable', 'string', 'max:255'],
            'sector'           => ['nullable', 'string', 'max:255'],
            'address'          => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex'           => 'Phone must be a valid Rwandan number (078/072/073/079XXXXXXX).',
            'whatsapp_number.regex' => 'WhatsApp number must be a valid Rwandan number (078/072/073/079XXXXXXX).',
        ];
    }
}