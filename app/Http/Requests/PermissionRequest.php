<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('permission'); // ambil id dari route (untuk update)

        return [
            'name' => 'required|string|max:100|unique:permissions,name,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique'   => 'Permission sudah ada.',
        ];
    }
}
