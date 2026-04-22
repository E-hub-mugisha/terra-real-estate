<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->can('staff.assign_permissions');
    }

    public function rules(): array
    {
        return [
            'role'            => 'required|exists:roles,name',
            'permissions'     => 'array',
            'permissions.*'   => 'exists:permissions,name',
        ];
    }
}
