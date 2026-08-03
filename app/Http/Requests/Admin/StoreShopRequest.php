<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // gated by 'admin' middleware on the route
    }

    public function rules(): array
    {
        $shopId = $this->route('shop')?->id;

        return [
            // Existing owner OR create a new one inline
            'user_id'          => ['nullable', 'required_without:new_owner_email', 'exists:users,id'],
            'new_owner_name'   => ['nullable', 'required_without:user_id', 'string', 'max:255'],
            'new_owner_email'  => ['nullable', 'required_without:user_id', 'email', 'unique:users,email'],

            'name'             => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string', 'max:2000'],
            'logo'             => ['nullable', 'image', 'max:2048'],
            'cover_image'      => ['nullable', 'image', 'max:4096'],
            'phone'            => ['required', 'regex:/^(078|072|073|079)[0-9]{7}$/', Rule::unique('shops', 'phone')->ignore($shopId)],
            'whatsapp_number'  => ['required', 'regex:/^(078|072|073|079)[0-9]{7}$/'],
            'email'            => ['nullable', 'email', 'max:255'],
            'district'         => ['nullable', 'string', 'max:255'],
            'province'         => ['nullable', 'string', 'max:255'],
            'sector'           => ['nullable', 'string', 'max:255'],
            'address'          => ['nullable', 'string', 'max:500'],
            'status'           => ['required', 'in:pending,approved,rejected,suspended'],
            'is_featured'      => ['nullable', 'boolean'],
        ];
    }
}