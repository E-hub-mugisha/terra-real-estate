<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Step 1
            'full_name'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255'],
            'phone'             => ['required', 'string', 'max:30'],
            'nationality'       => ['nullable', 'string', 'max:100'],
            'preferred_contact' => ['required', 'in:email,phone,whatsapp'],

            // Step 2
            'request_type'      => ['required', 'in:buy,rent,invest'],
            'property_type'     => ['required', 'in:house,apartment,land,commercial,architectural_design'],
            'property_status'   => ['required', 'in:new,existing,any'],

            // Step 3
            'preferred_province'=> ['nullable', 'string', 'max:100'],
            'preferred_district'=> ['nullable', 'string', 'max:100'],
            'preferred_sector'  => ['nullable', 'string', 'max:100'],
            'location_notes'    => ['nullable', 'string', 'max:1000'],

            // Step 4
            'currency'          => ['required', 'in:RWF,USD,EUR'],
            'budget_min'        => ['nullable', 'numeric', 'min:0'],
            'budget_max'        => ['nullable', 'numeric', 'min:0', 'gte:budget_min'],
            'timeline'          => ['required', 'in:immediate,1_3_months,3_6_months,6_12_months,flexible'],
            'financing_needed'  => ['sometimes', 'boolean'],

            // Step 5
            'bedrooms_min'      => ['nullable', 'integer', 'min:0', 'max:20'],
            'bathrooms_min'     => ['nullable', 'integer', 'min:0', 'max:20'],
            'land_size_min'     => ['nullable', 'numeric', 'min:0'],
            'land_size_max'     => ['nullable', 'numeric', 'min:0', 'gte:land_size_min'],
            'amenities'         => ['nullable', 'array'],
            'amenities.*'       => ['string', 'in:parking,garden,pool,security,generator,gym,elevator,borehole'],
            'must_have_features'    => ['nullable', 'array'],
            'must_have_features.*'  => ['string', 'max:100'],
            'nice_to_have_features' => ['nullable', 'array'],
            'nice_to_have_features.*' => ['string', 'max:100'],

            // Step 6
            'additional_notes'  => ['nullable', 'string', 'max:2000'],
            'newsletter_opt_in' => ['sometimes', 'boolean'],
            'how_did_you_hear'  => ['nullable', 'string', 'max:255'],
            'urgency'           => ['required', 'in:low,medium,high'],
        ];
    }

    public function messages(): array
    {
        return [
            'budget_max.gte'      => 'Maximum budget must be greater than or equal to the minimum budget.',
            'land_size_max.gte'   => 'Maximum land size must be greater than or equal to the minimum land size.',
            'email.email'         => 'Please provide a valid email address.',
            'request_type.in'     => 'Please select a valid request type (Buy, Rent, or Invest).',
            'property_type.in'    => 'Please select a valid property type.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'financing_needed'  => $this->boolean('financing_needed'),
            'newsletter_opt_in' => $this->boolean('newsletter_opt_in'),
        ]);
    }
}