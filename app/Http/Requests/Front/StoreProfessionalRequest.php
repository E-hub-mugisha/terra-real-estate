<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfessionalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Always validate all fields on final submit.
        // The _step field is only used by the view to restore the active tab on failure.
        return [
            // ── Step 1: Personal ──────────────────────────────────────
            'full_name'       => ['required', 'string', 'max:120'],
            'email'           => ['required', 'email', 'max:180', 'unique:users,email'],
            'phone'           => ['required', 'string', 'max:30'],
            'whatsapp'        => ['nullable', 'string', 'max:30'],
            'office_location' => ['nullable', 'string', 'max:120'],
            'languages'       => ['nullable', 'string', 'max:255'],

            // ── Step 2: Professional ──────────────────────────────────
            'profession'      => ['required', 'string', 'max:120'],
            'license_number'  => ['nullable', 'string', 'max:80'],
            'bio'             => ['required', 'string', 'min:30', 'max:3000'],
            'website'         => ['nullable', 'url', 'max:255'],
            'portfolio_url'   => ['nullable', 'url', 'max:255'],
            'linkedin'        => ['nullable', 'url', 'max:255'],
            'profile_image'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'credentials_doc' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],

            // ── Step 3: Services ──────────────────────────────────────
            'service_categories'   => ['nullable', 'array'],
            'service_categories.*' => ['integer', 'exists:service_categories,id'],
            'services'             => ['nullable', 'array'],
            'services.*'           => ['integer', 'exists:services,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required'  => 'Please enter the professional\'s full name.',
            'email.required'      => 'An email address is required.',
            'email.unique'        => 'This email is already registered on Terra.',
            'phone.required'      => 'A phone number is required.',
            'profession.required' => 'Please enter their profession or title.',
            'bio.required'        => 'A short bio is required for the public profile.',
            'bio.min'             => 'The bio must be at least 30 characters.',
            'profile_image.image' => 'The profile photo must be an image file.',
            'profile_image.max'   => 'The profile photo may not exceed 2 MB.',
            'credentials_doc.max' => 'The credentials document may not exceed 5 MB.',
        ];
    }

    /**
     * Return the step index the view should restore to on failure.
     * Matches the 0-indexed step that owns the first failing field.
     */
    public function failingStep(): int
    {
        $stepFields = [
            0 => ['full_name', 'email', 'phone', 'whatsapp', 'office_location', 'languages'],
            1 => ['profession', 'license_number', 'bio', 'website', 'portfolio_url', 'linkedin', 'profile_image', 'credentials_doc'],
            2 => ['service_categories', 'services'],
        ];

        foreach ($stepFields as $step => $fields) {
            foreach ($fields as $field) {
                if ($this->errors()->has($field)) {
                    return $step;
                }
            }
        }

        return 0;
    }
}