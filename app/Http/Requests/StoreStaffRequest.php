<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Use the FormRequest user() helper which is recognized and handles unauthenticated users safely.
        return optional($this->user())->can('staff.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'employee_id'   => 'required|string|unique:staff,employee_id',
            'department_id' => 'required|exists:departments,id',
            'position'      => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'joined_at'     => 'nullable|date',
            'role'          => 'required|exists:roles,name',
        ];
    }
}
