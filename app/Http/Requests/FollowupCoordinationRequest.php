<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowupCoordinationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);
        return [
            'coordination_id' => 'required',
            'proof'          => ($isUpdate ? 'nullable' : 'required') . '|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:1000',
            'attachment'     => ($isUpdate ? 'nullable' : 'required') . '|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:1000',
            'description'    => 'required|max:1000',

        ];
    }

    public function messages()
    {
        return [
            'coordination_id.required' => 'Silahkan pilih koordinasi.',

            'proof.required'          => 'Silahkan pilih bukti.',
            'proof.file'              => 'Bukti harus berupa file yang valid.',
            'proof.mimes'             => 'Bukti harus berupa file gambar/pdf (jpg, jpeg, png, gif, webp, pdf).',
            'proof.max'               => 'Ukuran bukti hanya maksimal 1 MB',

            'attachment.nullable'     => 'Lampiran bersifat opsional.',
            'attachment.file'         => 'Lampiran harus berupa file yang valid.',
            'attachment.mimes'        => 'Lampiran hanya boleh berupa file PDF atau gambar (jpg, jpeg, png, gif, webp).',
            'attachment.max'          => 'Ukuran lampiran maksimal 1 MB.',

            'description.required'    => 'Deskripsi wajib diisi.',
        ];
    }
}
