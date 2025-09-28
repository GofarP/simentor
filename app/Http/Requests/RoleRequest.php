<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Bisa diatur untuk policy, sementara true
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('role'); // ambil id dari route (untuk update)

        return [
            'name' => 'required|string|max:100|unique:roles,name,' . $id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique'   => 'Role sudah ada.',
            'permission.required'=>'Pilih Permission',
            'permissions.*.exists' => 'Permission tidak valid.',
        ];
    }
}
