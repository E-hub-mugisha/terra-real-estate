<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return optional($this->user())->can('staff.edit') ?: false;
    }

    public function rules(): array
    {
        $staffId = $this->route('staff')->id;
        $userId  = $this->route('staff')->user_id;

        return [
            'name'          => 'required|string|max:255',
            'email'         => "required|email|unique:users,email,{$userId}",
            'employee_id'   => "required|string|unique:staff,employee_id,{$staffId}",
            'department_id' => 'required|exists:departments,id',
            'position'      => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'status'       => 'required|in:active,inactive,suspended',
            'joined_at'     => 'nullable|date',
            'role'          => 'required|exists:roles,name',
        ];
    }
}
