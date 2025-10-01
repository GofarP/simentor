<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructionRequest extends FormRequest
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
        $id = $this->route('instruction');

        return [
            'receiver_id' => 'required',
            'title' => 'required|string',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'attachment'    => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2048',

        ];
    }

    public function messges(): array
    {
        return [
            'receiver_id.required' => 'Silahkan pilih penerima',
            'title.required' => 'Silahkan pilih judul',
            'description.required' => 'Silahkan masukkan deskripsi',
            'start_time.required' => 'Silahkan masukkan waktu mulai',
            'end_time.required' => 'Silahkan masukkan batas waktu',
            'attachment.file'   => 'Lampiran harus berupa file.',
            'attachment.mimes'  => 'Lampiran hanya boleh berupa file PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, atau JPEG.',
            'attachment.max'    => 'Ukuran lampiran maksimal 2 MB.',
        ];
    }
}
