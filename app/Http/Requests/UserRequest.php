<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user'); // untuk update (abaikan email sendiri)

        return [
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|max:150|unique:users,email,' . $id,
            'password'  => $id
                ? 'nullable|string|min:8|confirmed'   // update → optional, tapi kalau diisi harus confirmed
                : 'required|string|min:8|confirmed',  // create → wajib, minimal 8, dan confirmed
            'telp'      => 'required|string|max:15|regex:/^[0-9]+$/',
            'role_id'   => 'required|exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama wajib diisi.',
            'name.max'          => 'Nama maksimal 100 karakter.',

            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak sama.',

            'telp.required'     => 'Nomor telepon wajib diisi.',
            'telp.regex'        => 'Nomor telepon hanya boleh angka.',
            'telp.max'          => 'Nomor telepon maksimal 15 digit.',

            'role_id.required'  => 'Role wajib dipilih.',
            'role_id.exists'    => 'Role tidak ditemukan.',
        ];
    }
}
