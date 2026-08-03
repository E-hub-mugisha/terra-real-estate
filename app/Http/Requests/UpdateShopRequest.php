<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only the owning shop's user may update it — enforced again in the
        // controller via $shop->user_id === auth()->id(), this is a defense-in-depth check.
        return $this->user()?->shop?->id === $this->route('shop')?->id
            || $this->user()?->id === $this->route('shop')?->user_id;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'max:4096'],

            'phone' => ['required', 'regex:/^(078|072|073|079)\d{7}$/'],
            'whatsapp_number' => ['required', 'regex:/^(078|072|073|079)\d{7}$/'],
            'email' => ['nullable', 'email', 'max:150'],

            'district' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'sector' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
        ];
    }
}
