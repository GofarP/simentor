<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Jika ingin semua user bisa request, return true
        return true;
    }

    public function rules(): array
    {
        // Ambil ID user dari route (untuk update)
        $id = $this->route('user');

        return [
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'password' => $id
                ? 'nullable|string|min:8|confirmed'   // update → optional
                : 'required|string|min:8|confirmed',  // create → wajib
            'telp' => ['required', 'string', 'max:15', 'regex:/^\d+$/'],
            'role_id' => ['required', 'exists:roles,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',

            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.regex' => 'Nomor telepon hanya boleh angka.',
            'telp.max' => 'Nomor telepon maksimal 15 digit.',

            'role_id.required' => 'Role wajib dipilih.',
            'role_id.exists' => 'Role tidak ditemukan.',
        ];
    }
}
