<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowupInstructionRequest extends FormRequest
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
        return [
            'instruction_id' => 'required',
            'proof' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:2048',
            'attachment' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,webp|max:2048',
            'description' => 'required|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'instruction_id.required' => 'Silahkan pilih instruksi.',
            'proof.required'          => 'Silahkan pilih bukti.',
            'proof.mimes'             => 'Bukti harus berupa file gambar (jpg, jpeg, png, gif, webp).',
            'proof.max'             => 'Ukuran bukti hanya maksimal 2 MB',

            'attachment.required' => 'Silahkan pilih lampiran.',
            'attachment.file'     => 'Lampiran harus berupa file yang valid.',
            'attachment.mimes'    => 'Lampiran hanya boleh berupa file PDF atau gambar (jpg, jpeg, png, gif, webp).',
            'attachment.max'      => 'Ukuran lampiran maksimal 2 MB.',

            'description.required' => 'Deskripsi wajib diisi.',
        ];
    }


}
