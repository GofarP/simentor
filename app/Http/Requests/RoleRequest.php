<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roleId = $this->route('role')?->id ?? null;
        return [
            'name' => 'required|string|max:100|unique:roles,name,' . $roleId,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Role sudah ada.',
            'permissions.required' => 'Pilih Permission',
            'permissions.array' => 'Format permissions harus berupa array.',
            'permissions.*.exists' => 'Permission tidak valid.',
        ];
    }
}
