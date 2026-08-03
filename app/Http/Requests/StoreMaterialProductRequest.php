<?php

namespace App\Http\Requests\Materials;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->shop !== null;
    }

    public function rules(): array
    {
        return [
            'material_category_id' => ['required', 'exists:material_categories,id'],
            'material_subcategory_id' => ['nullable', 'exists:material_subcategories,id'],

            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:3000'],

            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'size:3'],
            'unit' => ['nullable', 'string', 'max:50'],
            'min_order_quantity' => ['nullable', 'integer', 'min:1'],

            'stock_status' => ['required', 'in:in_stock,out_of_stock,made_to_order'],

            'images' => ['nullable', 'array', 'max:6'],
            'images.*' => ['image', 'max:3072'],
            'primary_image_index' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
